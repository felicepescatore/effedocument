<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include("../../common/core/core.php");

$image_page="avvisi.png";

$id=$_GET['id'];
$tipo=$_GET['tipo'];

if($tipo==$objCore->getExtraAvvisiId()) $image_page="avvisi.png";
else if($tipo==$objCore->getExtraKnowledgebaseId()) $image_page="knowledge.png";

$array = $objCore->getExtra($id);
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>EffE Document - Info</title>
	<link rel="stylesheet" type="text/css" media="all" href="../../common/css/effecss.css" />      
<style type="text/css">
<!--
.Stile1 {font-size: 12px}
.Stile2 {font-size: 16px}
-->
</style>
</head>
<body>
<div id="wrapper">
  <h1>
   	<?php $level=2 ?>
    <?php include("../include/foheader.php"); ?>
  </h1>
</div>
<div id="wrapper">
    	<div id="secWrapper">
       	  <div id="container" class="clearfix">
       	    <center>
       	      <br />
       	      <table width="830" border="0" cellspacing="0" cellpadding="0">
       	        <tr>
       	          <td ><div class="qbtitle">
       	            <div align="left"><a href="extra.php?tipo=<?php echo $tipo?>">
       	              <?php if($tipo==$objCore->getExtraAvvisiId()) echo "Avvisi » vedi avviso"; else echo "Faq » vedi faq";?>
     	              </a></div>
     	            </div></td>
       	          <td align="right" valign="top"><div class="qbtitle">
       	            <div align="right">Data  d'inserimento: <b><?php echo visualizzaDataEuro($array['data']) ?></b></div>
     	            </div></td>
   	            </tr>
       	        <tr>
       	          <td colspan="2"><?php
							echo"<br>";
								echo "<tr class=\"qbrow1\">";
								echo "<td align=\"left\" valign=\"top\" class=\"smalltext\"><img src=\"../../common/images/icon/newsitembig.gif\" border=\"0\" /> <b>".$array['titolo_domanda']."</b> , titolo: &nbsp;&nbsp;<i>".$array['breve']."</i></td>";
								echo "</tr>";
							$descrizione=$array['descrizione_risposta'];
							?></td>
   	            </tr>
       	        <tr>
       	          <td colspan="2"><br />
       	            <fieldset class="swiftfieldset">
       	              <legend>Dettagli</legend>
       	              <p class="Stile2"><b><?php echo $descrizione;?></b></p>
   	                </fieldset></td>
   	            </tr>
   	          </table>
              <p> <?php echo "<a href=\"extra.php?tipo=".$tipo."\">&lt;&lt;&lt; ";

	if($tipo==$objCore->getExtraAvvisiId()) echo "Visualizza tutti gli Avvisi &gt;&gt;&gt;</a><br>";
	else if($tipo==$objCore->getExtraKnowledgebaseId()) echo "Visualizza tutte le Faq &gt;&gt;&gt;</a><br>";
?> </p>
              <br />
       	    </center>
       	  </div>
  </div>
</div>
<?php include("../include/folfooter.php"); ?>
</body>
</html>
