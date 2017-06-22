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

$id=$_GET['id'];
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
createMenu($objCore,12, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"></div>          
<div align="center">                
 <div class="row">
 <fieldset>
   <legend><img src="../../common/images/layout/servizi.png" width="60" height="60">Modifica il nome dell'ufficio</legend>
   <br><br>
   <form method="post" action="<?php $PHP_SELF ?>">
     <input type="hidden" name="op" value="modd">
     <input type="hidden" name="idx" value="<?php echo $id;?>">
     <table width="60%">
       <tr>
         <td>Nome Ufficio:</td>
         <td><input type="text" name="nome" value="<?php echo $objCore->getUfficioNome($id)?>">         </td>
       </tr>
       <tr>
         <td>Descrizione:</td>
         <td><input type="text" name="descrizione" value="<?php echo $objCore->getUfficioDescrizione($id)?>">         </td>
       </tr>
       <tr>
         <td></td>
         <td><input type="submit" value="Modifica"></td>
       </tr>
     </table>
   </form>
   <?php
	if(isset($_POST['op']) && $_POST['op']=="modd")
	{
		$idx=$_POST['idx'];
		$nome=$_POST['nome'];
		$descrizione=$_POST['descrizione'];
		
		if($objCore->updateUfficio($idx, $nome, $descrizione)) echo bjCore->logWrite("modifica dell'ufficio effettuato");
		else eecho bjCore->logWrite("modifica dell'ufficio non effettuato");
		
		echo"<script language=javascript>";
		echo"document.location.href='../service/service_uffici.php'";
		echo"</script>";}
?>
   
   <p></p>
 </fieldset>
 </div>
 <div class="row"><?php include("../_include/bofooter.php");?></div>        
 </div>
</div>
</body>
</html>