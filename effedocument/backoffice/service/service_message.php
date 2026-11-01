<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.5.0.0 - Licenza GPL-->
<!-- Data Rilascio: 01 Novembre 2026 (prima versione: 02 Febbraio 2010)-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

	$arr = array($objCore->getRuoloCollaboratoreId(),$objCore->getRuoloResponsabileId(),$objCore->getRuoloAmministratoreId(),$objCore->getRuoloCollaboratoreId(),$objCore->getRuoloVisualizzatoreReportId());
	applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css?v=1.5.0-5759dd" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../../common/script/effe-ui.js?v=1.5.0-5759dd" defer></script>

</head>
<body>
<div id="page">
<?php $menuSelezionato=0; include("../_include/bonav.php"); ?>
<div id="spazio" style="padding:7px;font-size:14px;"></div>
<div align="center">                
          <div class="row">
          <p><b><?php echo $_SESSION['message_to_show']; 
							$_SESSION['message_to_show']="";			 
				 	?></b>  
                    <?php if (isset($_SESSION['link_to_send']) && $_SESSION['link_to_send']!=""){?>
    <p class="code"><a href="<?php echo $_SESSION['../../admin/link_to_send'] ?>">&lt;&lt;&lt; Ritorna alla pagina precedete </a>
    <?php $_SESSION['link_to_send']=""; } ?></div>
    <div class="row">&nbsp;</div>
                        </div>
<?php include("../_include/bofooter.php"); ?>
</div>
</body>
</html>