<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloCollaboratoreId(),$objCore->getRuoloResponsabileId(),$objCore->getRuoloAmministratoreId(),$objCore->getRuoloVisualizzatoreReportId(), $objCore->getRuoloProtocollatoreId(), $objCore->getRuoloSupervisoreId());

applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);

if (isset($_GET['errore'])) $errore=$_GET['errore'];
else $errore="";
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
createMenu($objCore,0, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"></div>
<div align="center">                
          <div class="row"></div>
    <div class="row">
    <fieldset><legend><img src="../../common/images/layout/operatori.png" width="60" height="60"> Modifca Password</legend>
    <?php  
				if ($errore==1) echo "<b>Password corrente non inserita</b>";
				else if ($errore==2) echo "<b>Nuova password non inserita</b>";
				else if ($errore==3) echo "<b>Password ripetuta non inserita</b>";
				else if ($errore==4) echo "<b>Password ripetuta non corrispondente<</b>";
				else if ($errore==5) echo "<b>Password corrente non corretta</b>";
			?>
    <form method="post" action="modifica_password.php">
      <input type="hidden" name="op" value="modd">
      <table width="60%">
        <tr>
          <td>Inserisci la password attuale:</td>
          <td><input type="text" name="password_attuale" id="password_attuale"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Nuova password:</td>
          <td><label>
            <input type="password" name="nuova_password" id="nuova_password">
          </label></td>
        </tr>
        <tr>
          <td>Ripeti nuova password:</td>
          <td><label>
            <input type="password" name="nuova_password_ripetuta" id="nuova_password_ripetuta">
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
          <td></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Modifica"></td>
        </tr>
      </table>
    </form>
    <?php
	if(isset($_POST['op']) && $_POST['op']=="modd"){
		$password_attuale=$_POST['password_attuale'];
		$nuova_password=$_POST['nuova_password'];
		$nuova_password_ripetuta=$_POST['nuova_password_ripetuta'];

		if ($password_attuale=="")
		{
			echo"<script language=javascript>";
			echo"document.location.href='modifica_password.php?errore=1'";
			echo"</script>";
		}
		if ($nuova_password=="")
		{
			echo"<script language=javascript>";
			echo"document.location.href='modifica_password.php?errore=2'";
			echo"</script>";
		}
		else if ($nuova_password_ripetuta=="")
		{
			echo"<script language=javascript>";
			echo"document.location.href='modifica_password.php?errore=3'";
			echo"</script>";
		}		
		else if ($nuova_password!=$nuova_password_ripetuta)
		{
			echo"<script language=javascript>";
			echo"document.location.href='modifica_password.php?errore=4'";
			echo"</script>";
		}
		else if (($objCore->getLoggedOperatorePassword()=="") || ($objCore->getLoggedOperatorePassword()!=$password_attuale))
		{
			echo"<script language=javascript>";
			echo"document.location.href='modifica_password.php?errore=5'";
			echo"</script>";		
		}else{
			echo"<script language=javascript>";
			if($objCore->updatePassword($nuova_password))
			{
				$_SESSION['message_to_show']="Password modificata con successo";
				$objCore->logWrite("aggiornamento Password effettuata");
			}
			else{
				$_SESSION['message_to_show']="Password non aggiornata";		
				$objCore->logWrite("aggiornamento Password non effettuata");
			}
			echo"document.location.href='../service/service_message.php'";
			echo"</script>";
		}
	}
	?>
    </center>
    </p>
    </fieldset>
    </div>
    <div class="row"><?php include("../_include/bofooter.php");?></div>        
    </div>
</div>
</body>
</html>