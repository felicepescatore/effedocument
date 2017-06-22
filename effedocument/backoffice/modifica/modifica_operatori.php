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

if (isset($_GET['id'])) $id=$_GET['id'];
else $_GET['id']="";
?>

<?php
		if(isset($_POST['op']) && $_POST['op']=="ins"){
			//cattura i dati dal modulo
			$idx =$_POST['idx'];
			$nome =$_POST['nome'];
			$cognome =$_POST['cognome'];
			$email =$_POST['email'];
			$login=$_POST['login'];

			//li inserisce nella tabella
			if($objCore->updateOperatore($nome, $cognome, $email, $login, $idx)) $objCore->logWrite("aggiornamento Operatore effettuato");
			else $objCore->logWrite("aggiornamento Operatore non effettuato");
			
			echo"<script language=javascript>";
			echo"document.location.href='../service/service_operatori.php'";
			echo"</script>";
		} $sel_operatore=$objCore->getOperatore($id);
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
createMenu($objCore,6, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"><a href="../inserimento/inserisci_operatori.php">Inserisci operatori</a></div>
<div align="center">                
    <div class="row">
      <form name="form1" method="post" action="">
        <input type="hidden" value="ins" name="op">
        <input type="hidden" value="<?php echo $id;?>" name="idx">
        <table width="100%"  border="0" cellspacing="1" cellpadding="2">
          <tr>
            <td width="30%" align="left" valign="top" class="row2"><span class="smalltext">Nome: </span></td>
            <td width="70%"><input name="nome" type="text" size="25" class="swifttext" value="<?php echo $sel_operatore['nome'];?>"></td>
          </tr>
          <tr>
            <td width="30%" align="left" valign="top" class="row2"><span class="smalltext">Cognome: </span></td>
            <td width="70%"><input name="cognome" type="text" size="25" class="swifttext" value="<?php echo $sel_operatore['cognome'];?>"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="row2"><span class="smalltext">Email: </span></td>
            <td><input name="email" type="text" size="25" class="swifttext" value="<?php echo $sel_operatore['email'];?>"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="row2">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top" class="row2"><span class="smalltext">Login:</span></td>
            <td><input name="login" type="text" class="swifttext" id="login" value="<?php echo $sel_operatore['login']?>" size="20"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="row2">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top" class="row2">&nbsp;</td>
            <td><label>
              <input type="submit" name="button" id="button" value="Aggiorna">
            </label></td>
          </tr>
        </table>
      </form>
      </div>
                <div class="row">&nbsp;</div>
                <div class="row"><?php include("../_include/bofooter.php");?></div>        
  </div>
</div>
</body>
</html>