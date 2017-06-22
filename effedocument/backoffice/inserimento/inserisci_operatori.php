<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 09 Aprile 2008-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloAmministratoreId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
?>

<?php
	if(isset($_POST['op']) && $_POST['op']=="ins"){
		//cattura i dati dal modulo
		$nome =$_POST['nome'];
		$cognome =$_POST['cognome'];
		$email =$_POST['email'];
		$password =$_POST['password'];
		$today = date("j F Y, g:i a");
		$servizio=$_POST['servizio'];
		$ruolo=$_POST['ruolo'];
		$login=$_POST['login'];
		
		$errore = false;
								
		if ($ruolo==$objCore->getRuoloResponsabileId() || $ruolo==$objCore->getRuoloCollaboratoreId())
		{	if ($servizio =="" || $servizio ==-1)
			{	$errore=true;
			
				$_SESSION['message_to_show']="Servizio obbligatorio";
				$_SESSION['link_to_send']="inserisci_operatori.php";
				echo"<script language=javascript>";
				echo"document.location.href='../service/service_message.php'";
				echo"</script>";
			} else
			 if ($ruolo==$objCore->getRuoloResponsabileId() && $objCore->getResponsabileServizio($servizio) !=-1)
			 {	$errore=true;
			
				$_SESSION['message_to_show']="Esiste già un responsabile per il Servizio specificato";
				$_SESSION['link_to_send']="inserisci_operatori.php";
				echo"<script language=javascript>";
				echo"document.location.href='../service/service_message.php'";
				echo"</script>";
			 
			 }
		}else if ($ruolo==$objCore->getRuoloSupervisoreId() || $ruolo==$objCore->getRuoloProtocollatoreId())
		{	if (($ruolo==$objCore->getRuoloSupervisoreId() && $objCore->getSupervisore()!=-1) || ($ruolo==$objCore->getRuoloProtocollatoreId() && $objCore->getProtocollatore()!=-1))
			{	$errore=true;			
				
				$_SESSION['message_to_show']="Esiste già un operatore che ricopre il ruolo scelto";
				$_SESSION['link_to_send']="inserisci_operatori.php";
				echo"<script language=javascript>";
				echo"document.location.href='../service/service_message.php'";
				echo"</script>";
			 }
		}

		if (!$errore){
			if ($objCore->getOperatoreLogin($login)){
				echo"<script language=javascript>";
				$_SESSION['message_to_show']="Utente già esistente";
				$_SESSION['link_to_send']="inserisci_operatori.php";		
				echo"document.location.href='../service/service_message.php'";
				echo"</script>";
			}else{
				if ($ruolo==$objCore->getRuoloProtocollatoreId()) $servizio=-1;
						
				//li inserisce nella tabella	
				if($objCore->insertOperatori($servizio, $ruolo, 1, $nome, $cognome, $email, $login, $password, $today)) echo "nuovo operatore inserito";
				else echo "nuovo operatore non inserito";
					
				echo"<script language=javascript>";
				echo"document.location.href='../service/service_operatori.php'";
				echo"</script>";
			}
		}
	}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<script language="JavaScript" src="../../common/script/ts_picker.js"></script>
<title>Amministrazione effedocument</title>
<script src="../../common/script/validation.js" language="JavaScript"></script>
<link href="../../common/css/effecss.css" rel="stylesheet">
  <script language="JavaScript">
  function invia(){
  	document.formData.op.value="-1";
 	document.formData.action = "inserisci_operatori.php";
    document.formData.submit();
   	}
	
 	function init(){
		define('nome','string','Nome',null,null);
		define('cognome','string','Cognome',null,null);
		define('email','email','Email',null,null);	
		define('login','string','Login',null,null);
		
		if (document.formData.password)
			define('password','string','Password',null,null);
	}  
  </script>
</head>
<body onLoad="init();">
<div id="page">
<div class="row">
  <table width="100%" border="0">
    <tr>
      <td width="38%"><img src="../../images/loghi/e- _top.png" alt="logo"></td>
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
<div id="spazio" style="padding:7px;font-size:14px;"></div>          
<div align="center">                
  <div class="row"><fieldset>
 
    <legend>
      <img src="../../common/images/layout/protocolla.png" width="60" height="60"> Inserisci un nuovo operatore</legend>
    <form action="inserisci_operatori.php" method="post" name="formData" id="formData" onSubmit="validate();return returnVal;">
      <input type="hidden" value="ins" name="op">
      <table width="100%"  border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td align="left" valign="top" class="row2"><span class="smalltext">Ruolo:</span></td>
          <td><select name="ruolo" size="1" id="ruolo" onChange="invia()">
              <?php echo "<option value=\"-1\">[seleziona ruolo]</option>";
			$array_ruoli = $objCore->getRuoliOperatori();
			$num_ruoli=count($array_ruoli);
			
			for ($i=0; $i<$num_ruoli; $i++){
				echo "<option value=\"$i\"";
				if (isset($_POST['ruolo']) && ($i==$_POST['ruolo']) && $_POST['op']==-1) echo " selected";
				echo ">$array_ruoli[$i]</option>";
				}
			?>
            </select>
              <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
        </tr>
        <?php if (isset($_POST['ruolo']) && isset($_POST['op']) && $_POST['ruolo'] != $objCore->getRuoloProtocollatoreId() && $_POST['op']==-1 && $_POST['ruolo'] != $objCore->getRuoloVisualizzatoreReportId() && $_POST['ruolo'] != $objCore->getRuoloSupervisoreId() && $_POST['ruolo'] != $objCore->getRuoloAmministratoreId()) {?>
        <tr>
          <td align="left" valign="top" class="row2"><span class="smalltext">Tipologia Servizio: </span></td>
          <td><select name="tipologia" size="1" id="tipologia" onChange="invia()">
              <?php echo "<option value=\"-1\">[seleziona tipologia]</option>";
				$result = $objCore->getTipologieAttive();
				while($array_tipologie=mysql_fetch_array($result)){
					echo "<option value=\"".$array_tipologie['id']."\"";
					if (isset($_POST['tipologia']) && ($array_tipologie['id']==$_POST['tipologia']) && $_POST['op']==-1) echo " selected";
					echo ">".$array_tipologie['nome']."</option>";
				}
				?>
          </select>
          <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
        </tr>
        <?php } ?>        
        <?php if (isset($_POST['op']) && isset($_POST['tipologia']) && $_POST['op']==-1 && $_POST['tipologia']!=-1 && $_POST['tipologia']!="" && $_POST['ruolo'] != $objCore->getRuoloProtocollatoreId()  && $_POST['ruolo'] != $objCore->getRuoloVisualizzatoreReportId() && $_POST['ruolo'] != $objCore->getRuoloSupervisoreId() && $_POST['ruolo'] != $objCore->getRuoloAmministratoreId()) {?>
        <tr>
          <td align="left" valign="top" class="row2"><span class="smalltext">Servizio: </span></td>
          <td><select name="servizio" size="1" id="servizio">
              <?php echo "<option value=\"-1\">[seleziona servizio]</option>";
				$result = $objCore->getServiziAttivi($_POST['tipologia']);
				while($array_tematiche=mysql_fetch_array($result)){
					echo "<option value=\"".$array_tematiche['id']."\">".$array_tematiche['nome']."</option>";
				}
				?>
          </select>
          <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
        </tr>
        <?php } ?>
		<?php if (isset($_POST['ruolo']) && $_POST['ruolo'] != $objCore->getRuoloVisualizzatoreReportId() && $_POST['ruolo'] != $objCore->getRuoloAmministratoreId()) {?>
        <?php } ?>
        <tr>
          <td align="left" valign="top" class="row2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="30%" align="left" valign="top" class="row2"><span class="smalltext">Nome: </span></td>
          <td width="70%"><input name="nome" type="text" size="25" class="swifttext" value="">
              <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
        </tr>
        <tr>
          <td width="30%" align="left" valign="top" class="row2"><span class="smalltext">Cognome: </span></td>
          <td width="70%"><input name="cognome" type="text" size="25" class="swifttext" value="">
              <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="row2"><span class="smalltext">Email: </span></td>
          <td><input name="email" type="text" size="25" class="swifttext" value="">
              <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="row2">&nbsp;</td>
          <td>&nbsp;</td>
        <tr>
          <td align="left" valign="top" class="row2"><span class="smalltext">Login:</span></td>
          <td><input name="login" type="text" class="swifttext" id="login" size="20">
              <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
          <?php if (!$_SESSION['LDAP']){?>
        <tr>
          <td align="left" valign="top" class="row2"><span class="smalltext">Password: </span></td>
          <td><input name="password" type="password" size="20" class="swifttext">
              <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
		  <?php } ?>
        <tr>
          <td align="left" valign="top" class="row2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <input type="submit" value="Inserisci">
    </form>
    </p>
    
    </fieldset>
                <div class="row"><br><?php include("../_include/bofooter.php");?></div>        </div>
</div>
</body>
</html>