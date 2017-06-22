<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("../../common/core/core.php");
$image_page="document_open.png";
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>EffE Document - DocWizard 1</title>
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
       	      <table width="830" border="0" cellspacing="0" cellpadding="0">
       	        <tr>
       	          <td colspan="2"><div class="qbtitle">
       	            <div align="left">Doc Wizard, fase 1: Selezionare il servizio per il quale si chiede assistenza</div>
     	            </div></td>
   	            </tr>
       	        <tr>
       	          <td colspan="2"><div align="left">
       	            <?php
								$result = $objCore->getTipologieAttive();
								while($array=mysql_fetch_array($result)){
									echo "<br/>";
									echo"<div><img src=\"../../common/images/icon/folder.png\" border=0><b>".$array['nome']."</b></div>";
									$result_sub = $objCore->getServiziAttivi($array['id']);
									$count=0;
									while($array_sub =mysql_fetch_array($result_sub))
									{
										$count=$count+1;
										echo"<div class=\"navitem\" onMouseOver=\"javascript:this.className='navitemhover';\" onMouseOut=\"javascript:this.className='navitem';\">---><img src=\"../../common/images/icon/folder.gif\" border=0>&nbsp;<a href=\"docwizard2.php?id_servizio=".$array_sub['id']."\">".$array_sub['nome']."</a></div>";
									}
									if ($count==0)  echo"<div>--->nessun servizio attivo per questa area</div>";
								}

								?>
     	            </div></td>
   	            </tr>
   	          </table>
       	    </center>
       	  </div>
  </div>
</div>
<?php include("../include/folfooter.php"); ?>
</body>
</html>
