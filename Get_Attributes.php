<?php

// get attributes of current PZN
$GetAttributes = " 
SELECT
    PAE.PZN,
    PAE.Key_FAM,
    SNA.Key_STO,
    SNA.Name,
    PGR.Einstufung,
    FAI.Einheit,
    FAI.Zahl
FROM
    # DBK
    abda_dbk.PAE_DB PAE, # PZN > Key_FAM
    abda_dbk.FAI_DB FAI, # Information über stoffmenge und rang
    abda_dbk.SNA_DB SNA, # Name zu Key_STU
    #AEK
    abda_aek.PGR_APO PGR
WHERE
    PAE.PZN = '$PZN'
    AND PAE.Key_FAM = FAI.Key_FAM
    AND FAI.Rang = 1
    AND FAI.Stofftyp = 1
    AND FAI.Key_STO = SNA.Key_STO
    AND SNA.Vorzugsbezeichnung = '1'
    AND PAE.PZN = PGR.PZN;	"; 
    
// Save current PZN attributes

$sql = $GetAttributes;
include 'query.php';
$GetAttributesResult = $result;

// Check if query had results
if (mysqli_num_rows($GetAttributesResult) > 0) {

    // Put query results in variable
    foreach($GetAttributesResult as $res){

        $einheit = $res['Einheit'];
        $zahl = $res['Zahl'];
        $keysto = $res['Key_STO'];
        $einstufung = $res['Einstufung'];  

    } // end foreach

}
?>