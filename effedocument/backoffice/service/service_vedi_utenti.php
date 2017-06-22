<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

	$arr = array($objCore->getRuoloCollaboratoreId(),$objCore->getRuoloResponsabileId(),$objCore->getRuoloProtocollatoreId(), $objCore->getRuoloSupervisoreId());
	applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Dettagli</title>
<link href="../../common/css/effecss.css" rel="stylesheet">

<script>
function change(nuovo_valore){
	array=nuovo_valore.split("-");
	window.opener.formData.idx_utente.value=array[0];
	window.opener.formData.utente.value=array[1];

}
</script>
</head>
 <body>
<div id="page">
  <div align="center">                
                 <p>
					<?php
						$result = $objCore->getUtenti();
						if ($result){
							echo "<select name=\"elenco_utenti\" size=\"10\" id=\"elenco_utenti\" onclick=\"change(value);\" >";

							while ($array=mysql_fetch_array($result))
								echo "<option value=\"".$array['id']."-".$array['nome']." ".$array[cognome]."\">".$array['nome']." ".$array[cognome]."</option>";
							
							echo "</select>";
						}
						echo "<br><br>";
							
					?>
</body>
</html>
