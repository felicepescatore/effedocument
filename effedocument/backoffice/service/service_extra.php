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
	
	if (isset($_GET['tipo'])) $tipo=$_GET['tipo'];
    else $tipo=$objCore->getExtraAvvisiId();
	
	if (isset($_GET['visibili'])) $visibili=$_GET['visibili'];
	else $visibili=1;
	
	if (isset($_GET['op'])){
		if($_GET['op']=="modd") $objCore->abilitaDisabilitaExtra($_GET['id']);
		else if($_GET['op']=="del") $objCore->eliminaExtra($_GET['id']);
	}

 	if ($visibili==1) $result = $objCore->getExtraVisibili($tipo);
	else $result = $objCore->getExtraNonVisibili($tipo);	
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
createMenu($objCore,4, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;">
  <div align="left"><a href="../inserimento/inserisci_extra.php?tipo=<?php echo $tipo ?>">Inserisci <?php if($tipo==$objCore->getExtraAvvisiId())echo "Avviso"; else echo "Faq";?></a> || <a href="service_extra.php?tipo=<?php echo $tipo ?>&visibili=1">Mostra <?php if($tipo==$objCore->getExtraAvvisiId())echo "Avvisi"; else echo"Faq";?> Visibili</a> || <a href="service_extra.php?tipo=<?php echo $tipo ?>&visibili=0">Mostra <?php if($tipo==$objCore->getExtraAvvisiId()) echo "Avvisi"; else echo "Faq";?> non Visibili</a></div>
</div>          
<div align="center">
    <div class="row"><fieldset>
      <legend><img src="../../common/images/layout/extra.png" width="60" height="60"><?php if($tipo==$objCore->getExtraAvvisiId())echo "Avvisi"; else echo "Faq";?></legend>
      <p><img src="../../common/images/extra/longmenu_right.gif" width="455"></p>
<br>
      <table width="100%" border="0">
	<?php
    echo "<tr style=\"background-image:url(../../common/images/icon/bgfooter.gif);\">";
    echo "<td width=\"6\"><b>visualizza/nascondi</b></td>";
    echo "<td width=\"6\"><b>cancella</b></td>";	
    echo "<td><b>titolo</b></td>";
    echo "<td><b>breve</b></td>";
    echo "<td><b>descrizione</b></td>";
    echo "<td><b>data</b></td>";
    echo "</tr>";
    while($array=mysql_fetch_array($result)){
	    echo "<tr>";
		echo"<td><a href=\"..\service\service_extra.php?tipo=".$tipo."&id=".$array['id']."&op=modd\" onclick=\"return(confirm('Sei sicuro di voler modificare lo stato ??'))\"><img src=\"../../common/images/icon/move16.gif\" border=0></a></td>";
		echo"<td><a href=\"..\service\service_extra.php?tipo=".$tipo."&id=".$array['id']."&op=del\" onclick=\"return(confirm('Sei sicuro di volerne effettuare la cancellazione ??'))\"><img src=\"../../common/images/icon/delete.png\" border=0></a></td>";		
	    echo "<td>".$array['titolo_domanda']."</td>";
   	 	echo "<td>".$array['breve']."</td>";
    	echo "<td>".$array['descrizione_risposta']."</td>";
   		echo "<td>".$array['data']."</td>";
    	echo "<td>";
    	echo"</td>";
    	echo "</tr>";
    }
   ?>
   </table>
</fieldset>
</table>   
</div>
 <div class="row"><?php include("../_include/bofooter.php");?></div>        
</body>
</html>