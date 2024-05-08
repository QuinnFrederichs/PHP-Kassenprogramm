<?php
$KrankenkasseQuery = " 
SELECT 
    PZG.PZN,
    PAC.Langname,
    IZG.IK,
    IKZ.Name

FROM
    abda_aek.PZG_APO PZG, # Key_GRU zu PZN verknupfen
    abda_aek.IZG_APO IZG, # Key_GRU zu IK verknupfen
    abda_aek.IKZ_APO IKZ, # Name der IK 
    abda_aek.PAC_APO PAC # Hauptdatenbank AEK

WHERE
    PAC.PZN = PZG.PZN
    AND PZG.Key_GRU = IZG.Key_GRU
    AND IKZ.IK = IZG.IK
    AND PZG.PZN = '$PZN'
    AND IZG.IK = '$IK' ";

$sql = $KrankenkasseQuery;

require_once 'query.php';

$KrankenKasseResult = $result;

if ( mysqli_num_rows($KrankenKasseResult) > 0) {
    $out = "<div class='container-sm row justify-content-center'>";
    $out .= "<table class='table table-striped'>";
    $out .= "<tr><th scope='col' colspan='4'>Diese PZN wird uebernommen. </th></tr>";
    $out .= "<tr><th scope='col'>PZN</th><th scope='col'>Langname</th><th scope='col'>IK</th><th scope='col'>Name</th></tr>";

    foreach($KrankenKasseResult as $res){
        echo "<tr class='phoenix' scope='row'><td>". $res['PZN']."</td><td>". $res['Langname']."</td><td>". $res['IK']."</td><td>". $res['Name']."</td></tr>";
    }
}
?>