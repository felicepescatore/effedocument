<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
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
<link href="../../common/css/effecss.css" rel="stylesheet">

</head>
 <body>
<div id="page">
<div class="row">
  <table width="100%" border="0">
    <tr>
      <td width="38%"><img src="../../common/images/loghi/effedocument_top.png" alt="logo"></td>
      <td width="62%"><div align="right">
        <?php include ("../_include/boheader.php"); ?>
      </div></td>
    </tr>
  </table>
</div>
<div id="bar1">
<?php 
createMenu($objCore,6, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"><a href="../inserimento/inserisci_operatori.php">Inserisci operatori</a> || <a href="service_operatori.php?attivi=0">Visualizza Operatori non attivi</a></div>
 <div align="center">
  <div class="row"><fieldset><legend>
  <img src="../../common/images/layout/operatori.png" width="60" height="60">Ci sono
<?php
	if ($attivi==1) $result = $objCore->getOperatoriAttivi();
	else $result = $objCore->getOperatoriNonAttivi();
	
	echo "<b>".mysql_num_rows($result);
	if ($attivi==1)	echo "</b> operatori attivi";
	else echo "</b> operatori non attivi";
?></legend>
      <p><img src="../../common/images/extra/longmenu_right.gif" width="455"></p>
      <br>
 <div class="table">
<table width="100%">
<?php
	echo "<tr style=\"background-image:url(../../common/images/icon/bgfooter.gif);\">";
    echo "<td width=\"6\">modifica</td>";
    echo "<td width=\"6\">att/dis</td>";		
	echo "<td><b>nome</b></td>";
	echo "<td><b>cognome</b></td>";
	echo "<td><b>email</b></td>";
	echo "<td><b>login</b></td>";
	echo "<td><b>ruolo</b></td>";
	echo "<td><b>tipologie/a.tematiche</b></td>";	
	echo "</tr>";
	while($array=mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td> <a href=\"../modifica/modifica_operatori.php?id=".$array['id']."\"><img src=\"../../common/images/icon/pen16.gif\" border=0></a></td>";
		echo "<td> <a href=\"..\service\service_operatori.php?id=".$array['id']."&op=modstat\" onclick=\"return(confirm('Sei sicuro di voler disabilitare/abilitare questo operatore ??'))\"><img src=\"../../common/images/icon/move16.gif\" border=0></a></td>";		
		echo "<td>".$array['nome']."</td>";
		echo "<td>".$array['cognome']."</td>";
		echo "<td>".$array['email']."</td>";
		echo "<td>".$array['login']."</td>";
		echo "<td>".$objCore->getRuoloNome($array['id_ruolo']);
		if (($array['id_ruolo'] != $objCore->getRuoloAmministratoreId()) && ($array['id_ruolo'] != $objCore->getRuoloVisualizzatoreReportId()) && ($array['id_ruolo'] != $objCore->getRuoloProtocollatoreId()) && ($array['id_ruolo'] != $objCore->getRuoloSupervisoreId())){
			echo "<td>";			
			echo " <a href=\"../modifica/modifica_servizio_operatori.php?id=".$array['id']."\">[visualizza / cambia]</a></td>";
		}
		else echo "<td>nessuna";
		echo "</tr>";
	}
?>
</table>
</div>
<?php
	if(isset($_GET['op']) && $_GET['op']=="modstat")
	{
		$id=$_GET['id'];
		
		if($objCore->abilitaDisabilitaOperatore($id)) $objCore->logWrite("modifica dello Stato Operatore effettuata");
		else $objCore->logWrite("modifica dello Stato Operatore non effettuata");
	
		echo"<script language=javascript>";
		echo"document.location.href='service_operatori.php'";
		echo"</script>";}
?>
                 </p>
                
  </fieldset>
</div>
    <div class="row">&nbsp;</div>
                <div class="row"><?php include("../_include/bofooter.php");?></div>        
     </div>
</div>
</body>
</html>