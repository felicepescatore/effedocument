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

<?php
	if(isset($_GET['op'])){
		if ($_GET['op']=="modaut")
		{
			if($objCore->abilitaDisabilitaLDAP()) $objCore->logWrite("modifica modalità di autenticazione effettuata");
			else $objCore->logWrite("modifica modalità di autenticazione non effettuata");

			echo"<script language=javascript>";
			echo"document.location.href='service_configurazioni.php'";
			echo"</script>";
		} else if ($_GET['op']=="updEnte")
		{
	
			if($objCore->updateEnte($_POST['nomeente'], $_POST['siglaente']))echo $objCore->logWrite("modifica della configurazione effettuata");
			else $objCore->logWrite("modifica della configurazione non effettuata");

			echo"<script language=javascript>";
			echo"document.location.href='service_configurazioni.php'";
			echo"</script>";		
		}
	}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css" rel="stylesheet">

</head><body>
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
createMenu($objCore,4, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"></div>          
<div align="center">
    <div class="row"><fieldset>
      <legend><img src="../../common/images/layout/extra.png" width="60" height="60">Servizi aggiuntivi del Sistema</legend>
      <p><img src="../../common/images/extra/longmenu_right.gif" width="455"></p>
    <blockquote>
          <form name="form1" method="post" action="service_configurazioni.php?op=updEnte">
            <p><img src="../../common/images/icon/ente.gif" width="14" height="16"> </p>
            <p>Nome dell'ente
  <label>
    <input name="nomeente" type="text" value="<?php echo $objCore->getNomeEnte(); ?>" id="nomeente" size="80">
  </label>
            </p>
            <p>
              Sigla Ente
              <input name="siglaente" type="text" id="siglaente" value="<?php echo $objCore->getSiglaEnte(); ?>" size="2" maxlength="2">
            </p>
            <p>
              <label>
                <input type="submit" name="button" id="button" value="Invia">
              </label>
            </p>
          </form>
          <p>&nbsp;</p>
          <p><img src="../../common/images/icon/0.gif" width="22" height="16"> Autenticazione tramite LDAP 
            <?php if ($_SESSION['LDAP']) echo "<b>attivata</b>";
		  		else echo "<b>disattivata</b>";
		   ?>
            <a href="service_configurazioni.php?op=modaut" onclick="return(confirm('Sicuro di voler modificare la modalità di autenticazione ??'))">[attiva/disattiva]</a></p>
          <p><img src="../../common/images/icon/icon_error.gif" width="16" height="16"> <a href="service_extra.php?tipo=<?php echo $objCore->getExtraAvvisiId(); ?>">Avvisi</a></p>
        <p><img src="../../common/images/icon/faq.gif" width="14" height="16"> <a href="service_extra.php?tipo=<?php echo $objCore->getExtraKnowledgebaseId(); ?>">FAQ, frequently asked question</a></p>
        <p>&nbsp;</p>
      </blockquote>
    </fieldset>
    </div>
  <div class="row"><?php include("../_include/bofooter.php");?></div>        </div>
</div>
</body>
</html>