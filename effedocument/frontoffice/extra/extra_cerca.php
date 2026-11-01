<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("../../common/core/core.php");

$keyword= $_POST['keyword'];

$image_page="cerca.png";
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
       	      <table width="830" border="0" cellspacing="0" cellpadding="0">
       	        <tr>
       	          <td><table width="830" border="0" cellspacing="0" cellpadding="0">
       	            <tr>
       	              <td><div class="qbtitle">
       	                <div align="left">Avvisi o Knowledgebase presenti in archivio</div>
     	                </div></td>
   	                </tr>
       	            <tr>
       	              <td>&nbsp;</td>
   	                </tr>
       	            <tr>
       	              <td><div align="left">
       	                <p class="Stile1">
       	                  <?php
							$result = $objCore->cercaExtra($keyword);
							$find=false;
							while($array=mysql_fetch_array($result)){
								$find=true;
								echo "<tr class=\"qbrow1\">";
								echo "<td align=\"left\" valign=\"top\" class=\"smalltext\"><img src=\"../../common/images/icon/newsitembig.gif\" border=\"0\" /> ";
								if ($array['id_tipo']==$objCore->getExtraAvvisiId()) echo "<i>Avviso</i>, " ;
								else echo "<i>Faq</i>, ";
								echo "<a href=\"extra_leggi.php?tipo=".$array['id_tipo']."&id=".$array['id']."\"> ".$array['breve']."</a>&nbsp;&nbsp; (<i>".visualizzaDataEuro($array['data'])."</i>)";
								echo "</tr>";
							}
								if (!$find) echo "Nessun elemento trovato";
							?>
   	                    </p>
       	                <p>&nbsp; </p>
     	                </div></td>
   	                </tr>
     	            </table></td>
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
