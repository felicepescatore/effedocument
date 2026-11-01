<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.5.0.0 - Licenza GPL-->
<!-- Data Rilascio: 01 Novembre 2026 (prima versione: 02 Febbraio 2010)-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include ("../../common/core/core.php");
include("../_include/adminconfig.php");
$arr = array($objCore->getRuoloAmministratoreId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
?>

<html><head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<script language="JavaScript" src="../../common/script/ts_picker.js"></script>
<script language="JavaScript" src="../../common/script/effescript.js"></script>  
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css?v=1.5.0-5759dd" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../../common/script/effe-ui.js?v=1.5.0-5759dd" defer></script>

</head><body>
<div id="page">
<?php $menuSelezionato=1; include("../_include/bonav.php"); ?>
<div id="spazio" style="padding:7px;font-size:14px;"></div>          
<div align="center">
  <h1>Amministrazione</h1>
  <p class="smalltext">Configura l'ente, gli uffici, i servizi e chi pu&ograve; accedere al sistema.</p>
  <div class="azioni">
    <a class="azione" href="service_servizi.php"><h2>Servizi</h2><p>Tipologie di richiesta e servizi offerti, con il loro workflow.</p></a>
    <a class="azione" href="service_uffici.php"><h2>Uffici</h2><p>Gli uffici che ricevono e gestiscono i documenti.</p></a>
    <a class="azione" href="service_operatori.php"><h2>Operatori</h2><p>Account, ruoli e servizi assegnati a ogni operatore.</p></a>
    <a class="azione" href="service_utenti.php"><h2>Utenti</h2><p>I cittadini e le organizzazioni che hanno inviato documenti.</p></a>
    <a class="azione" href="service_configurazioni.php"><h2>Configurazioni</h2><p>Dati dell'ente e accesso tramite LDAP.</p></a>
  </div>
</div>
<?php include("../_include/bofooter.php"); ?>
</div>
</body>
</html>