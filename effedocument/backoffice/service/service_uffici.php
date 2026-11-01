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
	
if (isset($_GET['attivi'])) $attivi=$_GET['attivi'];
else $attivi=1;
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
<?php $menuSelezionato=12; include("../_include/bonav.php"); ?>
<div id="spazio" style="padding:7px;font-size:14px;"><a href="../inserimento/inserisci_ufficio.php">Inserisci Uffici</a> || <a href="service_uffici.php?attivi=0">Visualizza Uffici non attivi</a></div>
<div align="center">
	<div class="row"><fieldset><legend><img src="../../common/images/layout/uffici.png" width="60" height="60"><i>Uffici</i></legend>
        <p><img src="../../common/images/extra/longmenu_right.gif" width="455"></p>
        <p><br>
          
          </p>
      <div class="table">
<table width="100%">
<?php
	$regione_precedente="";
	$provincia_precedente="";
	echo "<tr style=\"background-image:url(../../common/images/icon/bgfooter.gif);\">";
    echo "<td width=\"6\">modifica</td>";
    echo "<td width=\"6\">&nbsp;</td>";	
    echo "<td width=\"6\">attiva/disattiva</td>";	
    echo "<td width=\"6\">&nbsp;</td>";	
	echo "<td><strong>Nome</strong></td>";
	echo "<td><strong>Descrizione</strong></td>";	
	echo "</tr>";
	
	if ($attivi==1) $result = $objCore->getUfficiAttivi();
	else $result = $objCore->getUfficiNonAttivi();

	while($array=mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td> <a href=\"../modifica/modifica_ufficio.php?id=".$array['id']."&op=mod\"><img src=\"../../common/images/icon/pen16.gif\" border=0></a></td>";
		echo "<td width=\"6\">&nbsp;</td>";
    	echo "<td> <a href=\"..\service\service_uffici.php?id=".$array['id']."&op=modstat\" onclick=\"return(confirm('Sei sicuro di abilitare/disabilitare il servizio ??'))\"><img src=\"../../common/images/icon/move16.gif\" border=0></a></td>";		
	    echo "<td width=\"6\">&nbsp;</td>";	
		echo "<td>".$array['nome']."</td>";
		echo "<td>".$array['descrizione']."</td>";		
		echo "</tr>";
	}
?>
</table>
</div>                 
<?php
	if(isset($_GET['op']) && $_GET['op']=="modstat")
	{
		$id=$_GET['id'];
		
		if($objCore->abilitaDisabilitaUfficio($id)) echo $objCore->logWrite("modifica dello Stato Uffici effettuata");
		else $objCore->logWrite("modifica dello Stato Uffici non effettuata");
	
		echo"<script language=javascript>";
		echo"document.location.href='service_uffici.php'";
		echo"</script>";}
?>
    </fieldset>
    </div>
                <div class="row">&nbsp;</div>
                        </div>
<?php include("../_include/bofooter.php"); ?>
</div>
</body>
</html>