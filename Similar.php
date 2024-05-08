<?php
  $showSimilarPZNQuery = "
SELECT 
	PAE.*,
	PAC.Langname,
	SNA.Key_STO,
	SNA.Name,
	PGR.Einstufung,
	FAI.Einheit,
	FAI.Zahl

FROM 
    abda_dbk.PAC_APO PAC, #Hauptdatenbank AEK
    abda_dbk.PAE_DB PAE, # verknupft PZN mit Key_FAM	
    abda_dbk.FAM_DB FAM, # Hauptdatenbank DBK 
    abda_dbk.FAI_DB FAI, # Info ueber wirk und hilfstoffen
    abda_dbk.STO_DB STO, # Info ueber Stoffkeys
    abda_dbk.SNA_DB SNA, # Wirkstoff name zu Stoffkey
    abda_aek.PGR_APO PGR, # Einstufung packungsgrosse
    abda_aek.PGR2_APO PGR2 # Zaehler MUSS 1 sein

WHERE 
	PAC.PZN = PGR.PZN
	AND PAC.PZN = PGR2.PZN
	AND PAC.PZN = PAE.PZN 
	AND PAE.Key_FAM = FAM.Key_FAM 
	AND FAM.Key_FAM = FAI.Key_FAM 
	AND FAI.Key_STO = STO.Key_STO 
	AND STO.Key_STO = SNA.Key_STO 
    AND PAC.PZN = '$item'
	AND FAI.Stofftyp = 1 
	AND vorzugsbezeichnung ='1'
	AND PGR2.Zaehler = 1 ";


  $sql = $showSimilarPZNQuery;
  include 'query.php';
  $SimilarPZNQueryResult = $result;

  $out3 .= "<div class='container-sm row justify-content-center'>";
  $out3 .= "<table class='table table-striped'>";

  $out3 .= "<tr>";
  $out3 .= "<th scope='col' colspan='8'>aehnliche PZN: </th></tr>";
  $out3 .= "<tr><th scope='col'>PZN</th>";
  $out3 .= "<th scope='col'>Key_FAM</th>";
  $out3 .= "<th scope='col'>Langname</th>";
  $out3 .= "<th scope='col'>Key_STO</th>";
  $out3 .= "<th scope='col'>Hauptwirkstoff:</th>";
  $out3 .="<th scope='col'>Einstufung:</th>";
  $out3 .= "<th scope='col'>Einheit:</th>";
  $out3 .= "<th scope='col'>Zahl:</th></tr>";
  
  foreach($SimilarPZNQueryResult as $res){

      $out3 .= "<tr class='orange'>";
      $out3 .= "<td>".$item. "</td>";
      $out3 .= "<td>".$res ['Key_FAM']."</td>";
      $out3 .= "<td>".$res ['Langname']."</td>";
      $out3 .= "<td>".$res ['Key_STO']."</td>";
      $out3 .= "<td>".$res ['Name']."</td>";
      $out3 .= "<td>".$res ['Einstufung']."</td>";
      $out3 .= "<td>".$res ['Einheit']."</td>";
      $out3 .= "<td>".$res ['Zahl']."</td>";
      $out3 .= "</tr>";
     }
?>