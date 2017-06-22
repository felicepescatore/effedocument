<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
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
          <div class="row">
          <p><b><?php echo $_SESSION['message_to_show']; 
							$_SESSION['message_to_show']="";			 
				 	?></b>  
                    <?php if (isset($_SESSION['link_to_send']) && $_SESSION['link_to_send']!=""){?>
    <p class="code"><a href="<?php echo $_SESSION['../../admin/link_to_send'] ?>">&lt;&lt;&lt; Ritorna alla pagina precedete </a>
    <?php $_SESSION['link_to_send']=""; } ?></div>
    <div class="row">&nbsp;</div>
                <div class="row"><?php include("../_include/bofooter.php");?></div>        </div>
</div>
</body>
</html>