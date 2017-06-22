<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("../common/core/core.php");

?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Effe Document</title>
	<link rel="stylesheet" type="text/css" media="all" href="../common/css/effecss.css" />        
</head>
<body>
<div id="wrapper">
  <h1>
    <?php include("include/foheader.php"); ?>
  </h1>
</div>
<div id="wrapper">
    	<div id="secWrapper">
       	  <div id="container" class="clearfix">
       	    <center>
       	      <table width="830" border="0">
       	        <tr>
       	          <td width="299"><div align="center">
       	            <p><a href="extra/extra.php?tipo=<?php echo $objCore->getExtraKnowledgebaseId() ?>"><img src="../common/images/layout/knowledge.png" alt="" border="0" /></a></p>
       	            <p><a href="extra/extra.php?tipo=<?php echo $objCore->getExtraKnowledgebaseId() ?>" id="moduletitle3"><strong>Knowledgebase</strong></a><br />
       	              <span class="smalltext">Risposta alle domande
       	                piu frequenti suddivise per categorie (FAQ)</span></p>
     	            </div></td>
       	          <td width="252"><p align="center"><a href="wizard/docwizard1.php"><img src="../common/images/layout/document_open.png" alt="" border="0" /></a></p>
       	            <p align="center"><a href="wizard/docwizard1.php" id="moduletitle2"><strong>Registra un nuovo documento</strong></a><br />
       	              <span class="smalltext">Registra un documento per l'assegnazione ai nostri funzionari</span></p></td>
       	          <td width="265"><p align="center"><a href="extra/extra.php?tipo=<?php echo $objCore->getExtraAvvisiId() ?>"><img src="../common/images/layout/avvisi.png" alt="" border="0" /></a></p>
       	            <p align="center"><a href="extra/extra.php?tipo=<?php echo $objCore->getExtraAvvisiId() ?>" id="moduletitle4"><strong>Avvisi</strong></a><br />
       	              <span class="smalltext"> Visualizza gli ultimi
       	                avvisi e annunci.</span></p></td>
   	            </tr>
       	        <tr>
       	          <td>&nbsp;</td>
       	          <td>&nbsp;</td>
       	          <td>&nbsp;</td>
   	            </tr>
       	        <tr>
       	          <td>&nbsp;</td>
       	          <td>&nbsp;</td>
       	          <td>&nbsp;</td>
   	            </tr>
       	        <tr>
       	          <td colspan="3"><div align="right"><img src="../common/images/extra/longmenu_right.gif" alt="" width="455" height="10" /></div></td>
   	            </tr>
   	          </table>
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
								echo"<div class=\"navitem\" onMouseOver=\"javascript:this.className='navitemhover';\" onMouseOut=\"javascript:this.className='navitem';\"><font color=\"#E55838\"><strong>&raquo;</strong></font>&nbsp;<a href=\"extra/extra_leggi.php?tipo=".$objCore->getExtraAvvisiId()."&id=".$array['id']."\">$array[titolo_domanda] (".visualizzaDataEuro($array['data']).")</a></div>";}
							?>
     	            </div></td>
   	            </tr>
   	          </table>
       	      <p>&nbsp;</p>
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
								echo"<div class=\"navitem\" onMouseOver=\"javascript:this.className='navitemhover';\" onMouseOut=\"javascript:this.className='navitem';\"><font color=\"#E55838\"><strong>&raquo;</strong></font>&nbsp;<a href=\"extra/extra_leggi.php?tipo=".$objCore->getExtraKnowledgebaseId()."&id=".$array['id']."\">$array[titolo_domanda] (".visualizzaDataEuro($array['data']).")</a></div>";}
							?>
     	            </div></td>
   	            </tr>
   	          </table>
       	      <br />
       	    </center>
       	  </div>
  </div>
</div>
<?php include("include/folfooter.php"); ?>
</body>
</html>
