<?php
// Alternative PZN table
$out2 = "<div class='container-sm row justify-content-center'>";
$out2 .= "<table class='table table-striped'>";
$out2 .= "<tr><th scope='col' colspan='7'>Alternative PZN: </th></tr>";
$out2 .= "<tr><th scope='col'>PZN</th>";
$out2 .= "<th scope='col'>Key_FAM</th>";
$out2 .= "<th scope='col'>Key_STO</th>";
$out2 .= "<th scope='col'>Hauptwirkstoff:</th>";
$out2 .= "<th scope='col'>Einstufung:</th>";
$out2 .= "<th scope='col'>Einheit:</th>";
$out2 .= "<th scope='col'>Zahl:</th>";
$out2 .= "</tr>";

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
    and PAE.PZN ='$ReplacementPZN'
    AND PZG.Key_GRU = IZG.Key_GRU
    AND FAI.Einheit = '$einheit'
    AND FAI.Zahl = '$zahl'
    AND PGR.Einstufung = '$einstufung'
    AND IZG.IK = '$IK' ";    

// save potential PZN replacement result
$sql = $PotentialReplacementPZNQuery;
include 'query.php';
$PotentialReplacementResult = $result;


// Check if query had results
if (mysqli_num_rows($PotentialReplacementResult) > 0) {

    
                
    // Put info in alternative PZN table
    foreach($PotentialReplacementResult as $res){

        // check if result is the same as entered PZN
        if($PZN != $res['PZN']){
            
            $out2 .= "<tr class='anzag'>";
            $out2 .= "<td >". $res ['PZN'] ."</td>";
            $out2 .= "<td>". $res['Key_FAM'] ."</td>";
            $out2 .= "<td>". $keysto = $res['Key_STO'] ."</td>";
            $out2 .= "<td>". $keysto = $res['Name']. "</td>";
            $out2 .= "<td>".$einstufung = $res['Einstufung']."</td>";
            $out2 .= "<td>". $einheit = $res['Einheit']."</td>";
            $out2 .= "<td>".$zahl = $res['Zahl']."</td>";  
            $out2 .= "</tr>";
    
        } // End if not same check

    } // end foreach

}// end if query results check

?>