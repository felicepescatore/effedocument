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
createMenu($objCore,61, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"></div>
<div align="center">                
          <div class="row">
                 <p>
                 <strong>Inserisci un nuovo ruolo</strong> <br>
<!-- pagina inserimento dati by phpdbwizard -->
<form method="post" action="<?php $PHP_SELF ?>">
    <input type="hidden" name="op" value="ins">
    <table width="100%">
    <tr><td>nome</td><td> <input type="text" name="nome"> <input type="submit" value="Inserisci"> </td></tr>
    </table>
</form>
<?php
					if($_POST['op']=="ins"){
						//cattura i dati dal modulo
						$nome =$_POST['nome'];
					
						//li inserisce nella tabella	
						if($objCore->insertRuolo($nome))echo "inserimento corretto";
						else echo "inserimento fallito";
	
						echo"<script language=javascript>";
						echo"document.location.href='../service/service_ruoli.php'";
						echo"</script>";	
					}
?>                 
				</p>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row"><?php include("../_include/bofooter.php");?></div>        
                </div>
</div>
</body>
</html>