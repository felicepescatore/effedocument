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

</head><body>
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
createMenu($objCore,11, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"><a href="../inserimento/inserisci_servizi.php">Inserisci Servizi</a><a href="service_ricerca.php"></a> || <a href="service_servizi.php?attivi=0">Visualizza Servizi non attivi</a></div>
<div align="center">                
<div class="row">
                 <p>                 
                 <div class="table"><fieldset>
<legend><img src="../../common/images/layout/servizi.png" width="60" height="60">Servizi</legend>
<p><img src="../../common/images/extra/longmenu_right.gif" width="455"></p>
<br><b>Tipologie Attive</b>
<table width="100%">
	<?php echo "<br>";
    echo "<tr style=\"background-image:url(../../common/images/icon/bgfooter.gif);\">";
    echo "<td width=\"6\">modifica</td>";
    echo "<td width=\"6\">attiva/disattiva</td>";
    echo "<td><strong>nome</strong></td>";
    echo "<td><strong>servizio padre</strong></td>";
    echo "<td><strong>ufficio</strong></td>";	
	echo "<td><strong>workflow</strong></td>";	
    echo "</tr>";
    
	$result = $objCore->getTipologieAttive();
	while($array=mysql_fetch_array($result)){
		echo "<tr>";
    	echo "<td> <a href=\"../modifica/modifica_servizio.php?id=".$array['id']."&ufficio=".$array['id_ufficio']."&op=mod\"><img src=\"../../common/images/icon/pen16.gif\" border=0></a></td>";
    	echo "<td> <a href=\"..\service\service_servizi.php?id=".$array['id']."&op=modstat\" onclick=\"return(confirm('Sei sicuro di abilitare/disabilitare il servizio ??'))\"><img src=\"../../common/images/icon/move16.gif\" border=0></a></td>";
  	  	echo "<td> <img src=\"../../common/images/icon/folder.png\" border=0>".$array['nome']."</td>";
	    echo "<td>nessuno</td>";
		echo "<td><b>".$objCore->getUfficioNome($objCore->getUfficioServizio($array['id_ufficio']))."</td>";		
		echo "<td><b>".$objCore->getWokflowNome($array['workflow'])."</td>";
    	echo "</tr>";
		if ($attivi==1)	$result_sub = $objCore->getServiziAttivi($array['id']);
		else $result_sub = $objCore->getServiziNonAttivi($array['id']);
    	
		while($array_sub=mysql_fetch_array($result_sub)){
    		echo "<tr>";
    		echo "<td> <a href=\"../modifica/modifica_servizio.php?id=".$array_sub['id']."&ufficio=".$array['id_ufficio']."&op=mod\"><img src=\"../../common/images/icon/pen16.gif\" border=0></a></td>";
    		echo "<td> <a href=\"..\service\service_servizi.php?id=".$array_sub['id']."&op=modstat\" onclick=\"return(confirm('Sei sicuro di abilitare/disabilitare il servizio ??'))\"><img src=\"../../common/images/icon/move16.gif\" border=0></a></td>";			
    		echo "<td> ----><img src=\"../../common/images/icon/folder.gif\" border=0>".$array_sub['nome']."</td>";
		    echo "<td>".$array['nome']."</td>";
    		echo "</tr>";
    	}
	}?>
</table>
<?php $result = $objCore->getTipologieNonAttive(); 
$array=mysql_fetch_array($result);
?>
<?php if ($attivi==0 && $array) {?>
<br><br><b>Tipologie non Attive</b>
<table width="100%">
	<?php echo "<br>";
    echo "<tr style=\"background-image:url(../../common/images/icon/bgfooter.gif);\">";
    echo "<td width=\"6\">modifica</td>";
    echo "<td width=\"6\">attiva/disattiva</td>";
    echo "<td><strong>nome</strong></td>";
    echo "<td><strong>servizio padre</strong></td>";
    echo "<td><strong>ufficio</strong></td>";	
    echo "<td><strong>workflow</strong></td>";	
    echo "</tr>";
    
	do{
		echo "<tr>";
    	echo "<td> <a href=\"../modifica/modifica_servizio.php?id=".$array['id']."&ufficio=".$array['id_ufficio']."&op=mod\"><img src=\"../../common/images/icon/pen16.gif\" border=0></a></td>";
    	echo "<td> <a href=\"..\service\service_servizi.php?id=".$array['id']."&op=modstat\" onclick=\"return(confirm('Sei sicuro di abilitare/disabilitare servizio ??'))\"><img src=\"../../common/images/icon/move16.gif\" border=0></a></td>";
  	  	echo "<td> <img src=\"../../common/images/icon/folder.png\" border=0>".$array['nome']."</td>";
	    echo "<td>nessuno</td>";
		echo "<td><b>".$objCore->getUfficioNome($objCore->getUfficioServizio($array['id_ufficio']))."</td>";		
		echo "<td><b>".$objCore->getWokflowNome($array['workflow'])."</td>";				
    	echo "</tr>";
		$result_sub = $objCore->geServizi($array['id']);
    	
		while($array_sub=mysql_fetch_array($result_sub)){
    		echo "<tr>";
    		echo "<td> <a href=\"../modifica/modifica_servizio.php?id=".$array_sub['id']."&ufficio=".$array['id_ufficio']."&op=mod\"><img src=\"../../common/images/icon/pen16.gif\" border=0></a></td>";
    		echo "<td> <a href=\"..\service\service_servizi.php?id=".$array_sub['id']."&op=modstat\" onclick=\"return(confirm('Sei sicuro di abilitare/disabilitare servizio ??'))\"><img src=\"../../common/images/icon/move16.gif\" border=0></a></td>";			
    		echo "<td> ----><img src=\"../../common/images/icon/folder.gif\" border=0>".$array_sub['nome']."</td>";
		    echo "<td>".$array['nome']."</td>";
    		echo "</tr>";
    	}
	}while($array=mysql_fetch_array($result));
	?>
</table>
<?php }?>
</fieldset>
</div>
<?php
	if(isset($_GET['op']) && $_GET['op']=="modstat")
	{
		$id=$_GET['id'];
		
		if($objCore->abilitaDisabilitaServizi($id)) $objCore->logWrite("modifica dello Stato Servizi effettuata");
		else $objCore->logWrite("modifica dello Stato Servizi non effettuata");
	
		echo"<script language=javascript>";
		echo"document.location.href='service_servizi.php'";
		echo"</script>";}
?>               </p>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row"><?php include("../_include/bofooter.php");?></div>        </div>
</div>
</body>
</html>