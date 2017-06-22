<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloProtocollatoreId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);

if (isset($_GET['tipo'])) $tipo=$_GET['tipo'];
else $tipo=0;

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<script language="JavaScript" src="../../common/script/ts_picker.js"></script>
<title>Amministrazione effedocument</title>
<script src="../../common/script/validation.js" language="JavaScript"></script>
<script src="../../common/script/effescript.js" language="JavaScript"></script>
<link href="../../common/css/effecss.css" rel="stylesheet">

  <script language="JavaScript">
  function invia(){
 	document.formData.action = "service_protocolla.php?tipo=<?php echo $tipo ?>";
    document.formData.submit();
   	}
  </script>
 <script language="JavaScript">	
 	function init(){
		define('cognome','string','Cognome',null,null);
		define('nome','string','Nome',null,null);		
		define('oggetto','string','Oggetto',10,300);		
		define('cf_pi','cf_pi','Codice Fiscale',null,null);	
		define('email','email','Email',null,null);					
	}
  </script>
  
 <style type="text/css">
<!--
.Stile1 {color: #267DDC}
-->
 </style>
</head>
<body onLoad="init();">
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

if ($tipo==0)
	createMenu($objCore,3, $objCore->getLoggedOperatoreRole());
else
	createMenu($objCore,31, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"></div>          
<div align="center">                
  <div class="row"><fieldset>
 
    <legend>
      <img src="../../common/images/layout/protocolla.png" width="60" height="60"></legend>
    <p><img src="../../common/images/extra/longmenu_right.gif" width="455"></p>
    <form action="service_protocolla_conferma.php?tipo=<?php echo $tipo ?>" method="post" name="formData" id="formData" onSubmit="validate();return returnVal;" enctype="multipart/form-data">
<input type="hidden" name="op" value="ins"><table width="100%">
  <tr>
    <td>Tipologia:</td>
    <td><select name="tipologia" size="1" id="tipologia" onChange="invia()">
        <?php
		echo "<option value=\"-1\">[seleziona la tipologia di richiesta]</option>"; 
		$result=$objCore->getTipologieAttive();
		while($array_tipologie=mysql_fetch_array($result)){
			echo "<option value=\"".$array_tipologie['id']."\"";
				if (isset($_POST['tipologia']) && ($_POST['tipologia']==$array_tipologie['id'])) echo " selected=true";
			echo">".$array_tipologie['nome']."</option>";
		}
	?>
        </select></td>
  </tr>
  <?php if (isset($_POST['tipologia']) && $_POST['tipologia'] !=-1 && $_POST['tipologia'] !="") { ?> 
  <tr>
    <td>Servizio:</td>
    <td><select name="servizio" size="1" id="servizio" onChange="invia()">
        <?php 
		echo "<option value=\"-1\">[seleziona servizio]</option>"; 
		$result=$objCore->getServiziAttivi($_POST['tipologia']);
		while($array_servizi=mysql_fetch_array($result)){
			echo "<option value=\"".$array_servizi['id']."\"";
				if (isset($_POST['servizio']) && ($_POST['servizio']==$array_servizi['id'])) echo " selected=true";
			echo">".$array_servizi['nome']."</option>";
		}
	?>
    </select></td>
  </tr>
  <?php } ?>
<tr>
  <td width="34%">&nbsp;</td>
  <td width="66%">&nbsp;</td>
</tr>
<tr>
  <td>Ufficio di Riferimento:</td>
  <td><select name="ufficio" size="1" id="ufficio">
    <?php 
		echo "<option value=\"-1\">[seleziona l'ufficio]</option>"; 
		$result=$objCore->getUfficiAttivi();
		while($array_uffici=mysql_fetch_array($result)){
			echo "<option value=\"".$array_uffici['id']."\"";
			echo">".$array_uffici['nome']."</option>";
		}
	?>
  </select></td>
</tr>
<tr>
  <td>Modalit&agrave; di 
  <?php if ($tipo==0)
  			echo "Ricezione:";
		else
			echo "Invio:";
	?></td><td><label>
  <select name="idx_modalita_ricezione" size="1" id="idx_modalita_ricezione">
    <option value="-1">[seleziona la modalità di recezione]</option>
    <?php 
	$result_modalita_ricezione = $objCore->getModalitaRicezione();
	for ($i=1; $i<count($result_modalita_ricezione); $i++){
		echo "<option value=\"$i\">$result_modalita_ricezione[$i]</option>";
	}
	?>
  </select>
  </label></td>
</tr>
<?php if ($tipo==0) {?>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2"><fieldset class="swiftfieldset">
    <legend>Dati presenti sull'eventuale documento ricevuto (opzionali)</legend>
    </fieldset></td>
  </tr>
<tr>
  <td>Numero Protocollo Generale:</td><td> <input name="numero_protocollo_esterno" type="text" id="numero_protocollo_esterno"></td></tr>
<tr>
  <td>Data ricezione:</td>
  <td><input name="data_invio" type="Text" id="data_invio" value="">
    <a href="javascript:show_calendar('document.formData.data_invio', document.formData.data_invio.value);"><img src="../../common/images/icon/cal.gif" alt="Seleziona la data" width="30" border="0"></a></td>
</tr>
<?php }?>
<tr>
  <td colspan="2">&nbsp;</td>
  </tr>
<tr>
  <td colspan="2"><fieldset class="swiftfieldset">
    <legend>Dati relativi alla richiesta</legend>
    </fieldset></td>
  </tr>
<tr>
  <td>Cognome Richiedente / Ragione Sociale:</td>
  <td><input name="cognome" type="text" id="cognome">
    <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
</tr>
<tr>
  <td>Nome Richiedente / Ragione Sociale:</td>
  <td><input name="nome" type="text" id="nome">
    <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
</tr>
<tr>
  <td>Email:</td>
  <td><input name="email" type="text" id="email">
    <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
</tr>
<tr>
  <td>Telefono:</td>
  <td><input name="telefono" type="text" id="telefono"></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Oggetto:</td><td><label>
    <textarea name="oggetto" id="oggetto" cols="45" rows="5"></textarea>
    <img src="../../common/images/icon/star.gif" width="16" height="16"></label></td></tr>
<tr>
  <td>&nbsp;</td><td><label></label></td></tr>
<tr>
  <td><div align="left">Allega File:</div></td>
  <td><div align="left">
    <input name="file1" type="file" id="file1" />
  </div></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>

  <div align="center">
  <?php if (isset($_POST['servizio']) && $_POST['servizio'] !=-1 && $_POST['servizio'] !="" && $_POST['tipologia'] !=-1 && $_POST['tipologia'] !="")
		echo "<input type=\"submit\" value=\"Inserisci\">";
	else echo "<input type=\"submit\" value=\"Inserisci\" disabled>";
?>  
  </div>
  </form>
</p>
    
    </fieldset>
                <div class="row"><br><?php include("../_include/bofooter.php");?></div>        </div>
</div>
</body>
</html>