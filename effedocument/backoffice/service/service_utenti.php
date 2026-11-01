<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.5.0.0 - Licenza GPL-->
<!-- Data Rilascio: 01 Novembre 2026 (prima versione: 02 Febbraio 2010)-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloAmministratoreId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css?v=1.5.0-5759dd" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../../common/script/effe-ui.js?v=1.5.0-5759dd" defer></script>

</head>
 <body>
<div id="page">
<?php $menuSelezionato=5; include("../_include/bonav.php"); ?>
<div id="spazio" style="padding:7px;font-size:14px;"></div>
 <div align="center">
  <div class="row"><fieldset><legend>
  <img src="../../common/images/layout/utenti.png" width="60" height="60">Ci sono
					    <?php
						$result = $objCore->getUtenti();
						
						echo "<b>".mysql_num_rows($result)."</b> utenti che hanno fatto richieste";
					?>
				      </legend>
      <p><img src="../../common/images/extra/longmenu_right.gif" width="455"></p>
      <table width="100%">
<?php	echo "<br>";
	echo "<tr style=\"background-image:url(../../common/images/icon/bgfooter.gif);\">";
	echo "<td><b>cognome</b></td>";
	echo "<td><b>nome</b></td>";
	echo "<td><b>email</b></td>";
	echo "<td><b>telefono</b></td>";
	echo "</tr>";
	while($array=mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td>".$array['cognome']."</td>";
		echo "<td>".$array['nome']."</td>";
		echo "<td>".$array['email']."</td>";
		echo "<td>".$array['telefono']."</td>";
		echo "<td>";
		echo"</td>";
		echo "</tr>";
	}
?>
</table>       
  </fieldset>
</div>
    <div class="row">&nbsp;</div>
                        
     </div>
<?php include("../_include/bofooter.php"); ?>
</div>
</body>
</html>
