<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("../../common/core/core.php");

if (isset($_GET['id_servizio'])) $id_servizio=$_GET['id_servizio'];
else {
	echo"<script language=javascript>";
	echo"document.location.href='docwizard1.php'";
	echo"</script>";	
}

$id_ufficio=$objCore->getUfficioServizio($id_servizio);

$image_page="document_open.png";
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>EffE Document - DocWizard 2</title>
	<script language="JavaScript" src="../../common/script/ts_picker.js"></script>
	<script src="../../common/script/validation.js" language="JavaScript"></script>
	<script src="../../common/script/effescript.js" language="JavaScript"></script>
	<link rel="stylesheet" type="text/css" media="all" href="../../common/css/effecss.css" />
 <script language="JavaScript">	
 	function init(){
		define('cognome','string','Nome', null, null);
		define('nome','string','Nome', null, null);
		define('email','email','Email',null,null);	
		define('oggetto','string','Oggetto',10,300);		
	}
  </script>    
</head>
<body onLoad="init();">
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
       	            <div align="left">Doc Wizard, fase 2: fase di invio</div>
     	            </div></td>
   	            </tr>
       	        <tr>
       	          <td height="569" colspan="2" valign="top"><form action="docwizard3.php" method="post" id="formData" enctype="multipart/form-data" onsubmit="validate();return returnVal;">
       	            <input type="hidden" value="ins" name="op" />
       	            <?php
			echo"<input type=\"hidden\" name=\"id_servizio\" value=\"$id_servizio\">";
			echo"<input type=\"hidden\" name=\"id_ufficio\" value=\"$id_ufficio\">";
			
			?>
       	            <br />
       	            <fieldset class="swiftfieldset">
       	              <legend>Dettagli Messaggio</legend>
       	              <table width="100%">
       	                <tr>
       	                  <td>&nbsp;</td>
       	                  <td>&nbsp;</td>
   	                    </tr>
       	                <tr>
       	                  <td><div align="left">Servizio Selezionato:</div></td>
       	                  <td><div align="left"><?php echo $objCore->getServizioNome($id_servizio); ?></div></td>
   	                    </tr>
       	                <tr>
       	                  <td><div align="left">Ufficio di Competenza:</div></td>
       	                  <td><div align="left"><?php echo $objCore->getUfficioNome($objCore->getUfficioServizio($id_servizio)); ?></div></td>
   	                    </tr>
       	                <tr>
       	                  <td>&nbsp;</td>
       	                  <td>&nbsp;</td>
   	                    </tr>
       	                <tr>
       	                  <td colspan="2">&nbsp;</td>
   	                    </tr>
       	                <tr>
       	                  <td colspan="2"><fieldset class="swiftfieldset">
       	                    <legend>Dati relativi alla richiesta</legend>
     	                    </fieldset></td>
   	                    </tr>
       	                <tr>
       	                  <td><div align="left">Cognome Richiedente:</div></td>
       	                  <td><div align="left">
       	                    <input name="cognome" type="text" id="cognome" />
       	                    <img src="../../common/images/icon/star.gif" alt="" width="16" height="16" /></div></td>
   	                    </tr>
       	                <tr>
       	                  <td><div align="left">Nome Richiedente:</div></td>
       	                  <td><div align="left">
       	                    <input name="nome" type="text" id="nome" />
       	                    <img src="../../common/images/icon/star.gif" alt="" width="16" height="16" /></div></td>
   	                    </tr>
       	                <tr>
       	                  <td><div align="left">Email:</div></td>
       	                  <td><div align="left">
       	                    <input name="email" type="text" id="email" />
       	                    <img src="../../common/images/icon/star.gif" alt="" width="16" height="16" /></div></td>
   	                    </tr>
       	                <tr>
       	                  <td><div align="left">Telefono:</div></td>
       	                  <td><div align="left">
       	                    <input name="telefono" type="text" id="telefono" />
     	                    </div></td>
   	                    </tr>
       	                <tr>
       	                  <td><div align="left"></div></td>
       	                  <td><div align="left"></div></td>
   	                    </tr>
       	                <tr>
       	                  <td><div align="left">Oggetto:</div></td>
       	                  <td><label>
       	                    <div align="left">
       	                      <textarea name="oggetto" id="oggetto" cols="45" rows="5"></textarea>
       	                      <img src="../../common/images/icon/star.gif" alt="" width="16" height="16" /></div>
       	                    </label></td>
   	                    </tr>
       	                <tr>
       	                  <td></td>
       	                  <td>&nbsp;</td>
   	                    </tr>
       	                <tr>
       	                  <td></td>
       	                  <td>&nbsp;</td>
   	                    </tr>
       	                <tr>
       	                  <td><div align="left">Allega File:</div></td>
       	                  <td><div align="left">
       	                    <input name="file1" type="file" id="file1" />
     	                    </div>
       	                    <div align="left"><a href="javascript:apri('scansione','applet/test2.html',400,150);"></a></div></td>
   	                    </tr>
       	                <tr>
       	                  <td>&nbsp;</td>
       	                  <td>&nbsp;</td>
   	                    </tr>
       	                <tr>
       	                  <td colspan="2">&nbsp;</td>
   	                    </tr>
   	                  </table>
       	              <div align="center">
       	                <input type="submit" name="submit" id="submit" value="Invia" />
   	                  </div>
   	                </fieldset>
       	            <div align="center"><br />
   	                </div>
     	            </form></td>
   	            </tr>
   	          </table>
       	    </center>
       	  </div>
  </div>
  <?php include("../include/folfooter.php"); ?>
</div>
</body>
</html>
