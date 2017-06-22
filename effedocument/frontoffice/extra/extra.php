<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("../../common/core/core.php");

if (isset($_get['id'])) $id=$_GET['id'];
$tipo=$_GET['tipo'];


if($tipo==$objCore->getExtraAvvisiId()){ 
	$result = $objCore->getExtraVisibili($objCore->getExtraAvvisiId());
	$image_page="avvisi.png";
}
else if($tipo==$objCore->getExtraKnowledgebaseId()){ 
	$result = $objCore->getExtraVisibili($objCore->getExtraKnowledgebaseId());
	$image_page="knowledge.png";
}
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>EffE Document - Info</title>
	<link rel="stylesheet" type="text/css" media="all" href="../../common/css/effecss.css" />      
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
                  <td><table width="830" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="2"><div class="qbtitle">
                        <div align="left">
                          <?php if($tipo==$objCore->getExtraAvvisiId()) echo "Avvisi"; else echo "Knowledgebase";?>
                          presenti in archivio</div>
                      </div></td>
                    </tr>
                    <tr>
                      <td colspan="2"><div align="left">
                        <?php
							$result = $objCore->getTipologieAttive();
							while($array=mysql_fetch_array($result)){				
									echo "<tr>";
									echo "<td><div align=\"left\"><img src=\"../../common/images/icon/folder.png\" border=0>&nbsp;".$array['nome']."(".$objCore->getExtraServizioTotale($array['id'], $tipo).") </div></td>";
									echo "</tr>";
									$result_sub = $objCore->getServiziAttivi($array['id']);
									
									while($array_sub=mysql_fetch_array($result_sub)){
										echo "<tr>";
										echo "<td><div align=\"left\" class=\"navitem\" onMouseOver=\"javascript:this.className='navitemhover';\" onMouseOut=\"javascript:this.className='navitem';\">----<img src=\"../../common/images/icon/folder.gif\" border=0>&nbsp;<a href=\"extra_selected.php?tipo=".$tipo."&servizio=".$array_sub['id']."\">".$array_sub['nome']."</a> (".$objCore->getExtraServizioTotale($array_sub['id'], $tipo).") </div></td>";
										echo "</tr>";
									}
								}
							?>
                      </div></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <table width="830" border="0" cellspacing="0" cellpadding="0">
  <tr>
       	          <td colspan="2"><div class="qbtitle">
       	            <div align="left">Ultimi avvisi</div>
     	            </div></td>
   	            </tr>
       	        <tr>
       	          <td colspan="2"><div align="left">
       	            <?php
							$result = $objCore->getAvvisiHomePage();
							while($array=mysql_fetch_array($result)){
								echo"<div class=\"navitem\" onMouseOver=\"javascript:this.className='navitemhover';\" onMouseOut=\"javascript:this.className='navitem';\"><font color=\"#E55838\"><strong>&raquo;</strong></font>&nbsp;<a href=\"extra_leggi.php?tipo=".$objCore->getExtraAvvisiId()."&id=".$array['id']."\">$array[titolo_domanda] (".visualizzaDataEuro($array['data']).")</a></div>";}
							?>
     	            </div></td>
   	            </tr>
   	          </table>
       	      <p><br />
   	          </p>
       	      <table width="830" border="0" cellspacing="0" cellpadding="0">
       	        <tr>
       	          <td ><div class="qbtitle">
       	            <div align="left">Ultime knowledgebase</div>
     	            </div></td>
   	            </tr>
       	        <tr>
       	          <td><div align="left">
       	            <?php
										$result = $objCore->getKnowledgebaseHomePage();
							while($array=mysql_fetch_array($result)){
								echo"<div class=\"navitem\" onMouseOver=\"javascript:this.className='navitemhover';\" onMouseOut=\"javascript:this.className='navitem';\"><font color=\"#E55838\"><strong>&raquo;</strong></font>&nbsp;<a href=\"extra_leggi.php?tipo=".$objCore->getExtraKnowledgebaseId()."&id=".$array['id']."\">$array[titolo_domanda] (".visualizzaDataEuro($array['data']).")</a></div>";}
							?>
     	            </div></td>
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
