<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("../../common/core/core.php");

$tipo=$_GET['tipo'];
$servizio=$_GET['servizio'];



if($tipo==$objCore->getExtraAvvisiId()){ 
	$result = $objCore->getExtraServizio($servizio,$objCore->getExtraAvvisiId());
	$image_page="avvisi.png";
}
else if($tipo==$objCore->getExtraKnowledgebaseId()){ 
	$result = $objCore->getExtraServizio($servizio,$objCore->getExtraKnowledgebaseId());
	$image_page="knowledge.png";
}
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>EffE Document - Info</title>
	<link rel="stylesheet" type="text/css" media="all" href="../../common/css/effecss.css?v=1.5.0-5759dd" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../../common/script/effe-ui.js?v=1.5.0-5759dd" defer></script>      
<style type="text/css">
<!--
.Stile1 {font-size: 12px}
-->
</style>
</head>
<body>
<?php $level=2 ?>
<?php include("../include/foheader.php"); ?>
<div id="wrapper" class="fo-main">
    	<div id="secWrapper">
       	  <div id="container" class="clearfix">
       	    <center>
       	      <br />
       	      <table width="830" border="0" cellspacing="0" cellpadding="0">
       	        <tr>
       	          <td ><div class="qbtitle">
       	            <div align="left">
       	              <?php if($tipo==$objCore->getExtraAvvisiId()) echo "Avvisi"; else echo "Knowledgebase";?>
       	              relativi al servizio <b><?php echo $objCore->getServizioNome($servizio);?></b></div>
     	            </div></td>
       	          <td align="right" valign="top"><div class="qbtitle">Data  d'inserimento</div></td>
   	            </tr>
       	        <tr>
       	          <td colspan="2"><?php echo "<br>";
							while($array=mysql_fetch_array($result)){
							echo "<tr class=\"qbrow1\">";
							echo "<td align=\"left\" valign=\"top\" class=\"smalltext\"><img src=\"../../common/images/icon/newsitembig.gif\" border=\"0\" /><a href=\"extra_leggi.php?tipo=".$tipo."&id=".$array['id']."\"> ".$array['breve']."</a></td>";
							echo "<td width=\"200\" align=\"right\" valign=\"top\" class=\"smalltext\">".visualizzaDataEuro($array['data'])."</td>";
							echo "</tr>";
							}
							?></td>
   	            </tr>
   	          </table>
       	      <br />
       	    </center>
       	  </div>
  </div>
</div>
<?php include("../include/folfooter.php"); ?>
</body>
</html>
