<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.5.0.0 - Licenza GPL-->
<!-- Data Rilascio: 01 Novembre 2026 (prima versione: 02 Febbraio 2010)-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloCollaboratoreId(),$objCore->getRuoloResponsabileId(),$objCore->getRuoloProtocollatoreId(), $objCore->getRuoloSupervisoreId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
	
	if (isset($_POST['op'])) $op=$_POST['op'];
	else $op="";
	if (isset($_POST['protocollo'])) $protocollo=$_POST['protocollo'];
	else $protocollo="";
	if (isset($_POST['protocollo_data'])) $protocollo_data=$_POST['protocollo_data'];
	else $protocollo_data="";
	if (isset($_POST['utente'])) $utente=$_POST['utente'];	
	else $utente="";
	if (isset($_POST['idx_utente'])) $idx_utente=$_POST['idx_utente'];
	else $idx_utente="";
	
	$_ricerca=true;
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css?v=1.5.0-5759dd" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../../common/script/effe-ui.js?v=1.5.0-5759dd" defer></script>

<script language="JavaScript" src="../../common/script/ts_picker.js"></script> 
<script language="JavaScript" src="../../common/script/effescript.js"></script> 
</head>
<body>
<div id="page">
<?php $menuSelezionato=2; include("../_include/bonav.php"); ?>
<div id="spazio" style="padding:7px;font-size:14px;"></div>          
<div align="center">                
<div class="row">
<p> 
	<fieldset>
	<legend>   <img src="../../common/images/layout/cerca.png" width="60" height="60"> Ricerca per
    <?php if ($protocollo!=="") echo " protocollo: <b>".$protocollo."</b>";
		else if ($protocollo_data!=="") echo " data di protocollo: <b>".$protocollo_data."</b>";
		else if ($utente!=="" && $idx_utente!=="") echo " utente: <b>".$utente."</b>";
	?>
    </legend>
	<p><img src="../../common/images/extra/longmenu_right.gif" width="455"></p>
	<div class="row"><br>    <table class="dati" width="100%">
    <?php //Ricerca
		if ($op=="search"){
			
			if ($protocollo!="" && strlen($protocollo)>2)
			{
				$protocollo_numerico=$objCore->getProtocolloNumerico($protocollo);
				$result=$objCore->cercaPerProtocollo($protocollo_numerico);

			}else if ($protocollo=="" && $protocollo_data!="")
			{
				$result=$objCore->cercaPerData($protocollo_data);
			
			}else if ($protocollo=="" && $protocollo_data=="" && $idx_utente!="")
			{
				$result=$objCore->cercaPerUtente($idx_utente);
			
			} 
	?>	
    <?php include("../_include/generavista.php"); ?>
    <?php }  ?>	</table>
    <form name="formData" id="formData" method="post">
    <input name="op" type="hidden" value="search">
      <input name="idx_utente" type="hidden" id="idx_utente" value="-1">
      <table width="100%">
        <tr>
          <td width="32%"><div align="left">Protocollo:</div></td>
          <td width="68%"><div align="left">
              <input name="protocollo" type="text" id="protocollo">
          </div></td>
        </tr>
        <tr>
          <td><div align="left">Data di Invio:</div></td>
          <td><div align="left">
              <input name="protocollo_data" type="Text" id="protocollo_data" value="">
          <a href="javascript:show_calendar('document.formData.protocollo_data', document.formData.protocollo_data.value);"><img src="../../common/images/icon/cal.gif" width="16" height="16" border="0" alt="Seleziona la data"></a></div></td>
        </tr>
        <tr>
          <td><div align="left">Utente:</div></td>
          <td><div align="left">
              <input name="utente" type="text" id="utente" disabled>
              <a href="javascript:apri('dettagli','service_vedi_utenti.php',200,250);"><img src="../../common/images/icon/faq.gif" width="14" height="16" border="0" alt="Seleziona Utente"></a></div></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <p>
        <label>
        <input type="submit" name="Cerca" id="Cerca" value="Cerca">
        </label>
      </p>
    </form>
    </div>
    </fieldset>
                        </div>
<?php include("../_include/bofooter.php"); ?>
</div>
</body>
</html>