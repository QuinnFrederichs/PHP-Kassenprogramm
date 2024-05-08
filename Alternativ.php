<?php // start of PHP

include 'conn.php';

// variables
$PZN = NULL;
$IK = NULL;
$PZN    = ( $PZN != NULL ) ? $PZN : "03820525"  ;
$IK     = ( $IK  != NULL ) ? $IK  : "103411401" ;
$PotentialReplacementPZNResult = NULL;
$KrankenKasseResult = NULL;
$einheit = "Undefined";
$zahl = "Undefined";
$keysto = "Undefined";
$einstufung = "Undefined"; 
$out = NULL;
$out2 = NULL;
$out3 = NULL;

$items = array();
$ReplacementPZN = NULL;

if(isset($_POST['PZN']) && isset($_POST['IK'])){
    
    $IK =  $_POST['IK'] ;
    $PZN =  $_POST['PZN'] ; /// Beispiel PZN 03820525

    include 'PZN_IK.php';

            include 'Get_Attributes.php';

        // Query3 Check for possible alternative PZN 
        $PotentialReplacementPZNQuery = " 
        SELECT
            PAE.*,
            FAI.Rang,
            FAI.Einheit,
            FAI.Zahl,
            FAI.Stofftyp,
            SNA.Name,
            PGR.Einstufung,
            SNA.Key_STO
        FROM
            abda_dbk.PAE_DB PAE, # PZN > Key_FAM
            abda_dbk.FAI_DB FAI, # Information über stoffmenge und rang
            abda_dbk.SNA_DB SNA, # Name zu Key_STU
            abda_aek.PGR_APO PGR,
            abda_aek.PZG_APO PZG,
            abda_aek.IZG_APO IZG
        WHERE
            PAE.Key_FAM = FAI.Key_FAM
            AND FAI.Stofftyp = 1
            AND FAI.Key_STO = SNA.Key_STO
            AND SNA.Vorzugsbezeichnung = '1'
            AND PAE.PZN = PGR.PZN
            AND SNA.Key_STO  = '$keysto'
            AND PAE.PZN = PZG.PZN
            AND PZG.Key_GRU = IZG.Key_GRU
            AND FAI.Einheit = '$einheit'
            AND FAI.Zahl = '$zahl'
            AND PGR.Einstufung = '$einstufung'
            AND IZG.IK = '$IK' ";     

        // Save alternative PZN info in $PotentialReplacementPZNQuery
        $sql = $PotentialReplacementPZNQuery;
        include 'query.php';
        $PotentialReplacementPZNResult = $result;
        

        
        // Check if query had results
        if (mysqli_num_rows($PotentialReplacementPZNResult) > 0) {

            foreach($PotentialReplacementPZNResult as $res){
                $items[] = $res['PZN'];  
            } // end foreach

        }// end if
        else{
            echo "";
        } // end else
    }

    $CountQuery="
    select 
        count(FAI.Stofftyp) as CountStofftyp1 
    from  
        abda_dbk.FAI_DB FAI,
        abda_dbk.PAE_DB PAE  
    where 
        PAE.PZN = '$PZN'  
        AND PAE.Key_FAM = FAI.Key_FAM 
        AND FAI.Stofftyp = 1";

    $sql = $CountQuery;
    include 'query.php';
    $resultCount = $result;

    if (mysqli_num_rows($resultCount) > 0) {

        foreach($resultCount as $row){
        $Count= $row['CountStofftyp1'];

        
    }

    if(count($items)){

        // Count stofftyp 1 from each pzn and compare
        foreach($items as $item){
            $CountQuery="
            select 
                count(FAI.Stofftyp) as CountStofftyp1 
            from  
                abda_dbk.FAI_DB FAI, 
                abda_dbk.PAE_DB PAE  
            where 
                PAE.PZN = '$item'  
                AND PAE.Key_FAM = FAI.Key_FAM
                AND FAI.Stofftyp = 1";
            

            $sql = $CountQuery;
            include 'query.php';
            $resultCount = $result;

            if (mysqli_num_rows($resultCount) > 0) {
                foreach($resultCount as $row){
                $Count1= $row['CountStofftyp1'];
                }
            }
            if($Count1==$Count){
                
                $ReplacementPZN = $item;
            }
            else{
                include 'Similar.php';
              

                } // end foreach
            } // end check resultcount > 0
        } // end foreach items 
    }
    include 'Alternative_PZN.php';

    if($KrankenKasseResult == NULL){

        $out .= "<div class='red'><h3><center>PZN: ". $PZN ." Wird nicht uebernommen von IK: ". $IK . "!</center></h3></div>";

    }

    if($PotentialReplacementPZNResult == NULL){

        $out .= "<div class='red'><h3><center>Keine alternative fuer PZN: ". $PZN ." und IK: ". $IK . " gefunden!</center></h3></div>";
    }





include 'Form.php';
echo "<body style='background-color:white'>"
?>