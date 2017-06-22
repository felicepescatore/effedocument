<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
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
createMenu($objCore,1, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"></div>          
<div align="center">                <div class="row">
                 <p><img src="../../common/images/layout/pannello.png" width="128" height="128"> Amministratore                 
                 <p><img src="../../common/images/extra/longmenu_right.gif" width="455">
</div>
    <div class="row">&nbsp;</div>
                <div class="row">
                  <?php include("../_include/bofooter.php");?>
                </div>        
  </div>
</div>
</body>
</html>