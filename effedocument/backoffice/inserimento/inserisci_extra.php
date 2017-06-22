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

if (isset($_GET['tipo'])) $tipo=$_GET['tipo'];
else $tipo="";

if($tipo==$objCore->getExtraAvvisiId()){ 
	$result = $objCore->getExtraVisibili($objCore->getExtraAvvisiId());
	$image_page="avvisi.png";
}
else if($tipo==$objCore->getExtraKnowledgebaseId()){ 
	$array = $objCore->getExtraVisibili($objCore->getExtraKnowledgebaseId());
	$image_page="knowledge.png";
}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css" rel="stylesheet">

<script src="../../common/script/validation.js" language="JavaScript"></script> 
 <script language="JavaScript">	
 	function init(){
		if (<?php echo $tipo?>==0){
			define('titolo','string','Titolo',null,null);
			define('breve','string','Descrizione Breve',null,null);
			define('descrizione','string','Descrizione',null,null);		
		}else{
			define('titolo','string','Domanda',null,null);
			define('breve','string','Descrizione Breve',null,null);
			define('descrizione','string','Risposta',null,null);	
		}
	}
  </script>
  <script language="JavaScript">
  function invia(){
  	document.formData.op.value="";
 	document.formData.action = "inserisci_extra.php?tipo="+<?php echo $tipo?>;
    document.formData.submit();
   	}
  </script>  
  
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
createMenu($objCore,4, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;">
<?php 	echo "<a href=\"..\service\service_extra.php?tipo=".$tipo."\">";
	if ($tipo==$objCore->getExtraAvvisiId()) echo"Vedi gli Avvisi</a>";
	else echo"Vedi le Faq</a>";
?>          
 <div align="center">
 <div class="row">
   <fieldset>
   <legend><strong><img src="../../common/images/layout/extra.png" width="60" height="60">Inserisci un <?php if ($tipo==$objCore->getExtraAvvisiId())echo"Avviso"; else echo "Faq";?></strong>   </legend>
   <form action="<?php $PHP_SELF?>" method="post" name="formData" id="formData" onSubmit="validate();return returnVal;">
     <input type="hidden" name="op" value="ins">
     <table width="100%">
       <tr>
         <td>Tipologia di Riferimento</td>
         <td><select name="tipologia" size="1" id="tipologia" onChange="invia()">
             <?php
		echo "<option value=\"-1\">[seleziona la tipologia di richiesta]</option>"; 
		$result=$objCore->getTipologieAttive();
		while($array_tipologie=mysql_fetch_array($result)){
			echo "<option value=\"".$array_tipologie['id']."\"";
				if (isset($_POST['tipologia']) && $_POST['tipologia']==$array_tipologie['id']) echo " selected=true";
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
		echo "<option value=\"-1\">[seleziona il servizio]</option>"; 
		$result=$objCore->getServiziAttivi($_POST['tipologia']);
		while($array_servizi=mysql_fetch_array($result)){
			echo "<option value=\"".$array_servizi['id']."\"";
				if (isset($_POST['servizio']) && $_POST['servizio']==$array_servizi['id']) echo " selected=true";
			echo">".$array_servizi['nome']."</option>";
		}
	?>
         </select></td>
       </tr>
         <?php } ?>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td><?php if ($tipo==$objCore->getExtraAvvisiId()) echo "Titolo:"; else echo "Domanda:";?></td>
         <td><input type="text" name="titolo" size="70">
             <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
       </tr>
       <tr>
         <td>Descrizione Breve:</td>
         <td><input type="text" name="breve" size="70">
             <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
       </tr>
       <tr>
         <td valign="top"><?php if ($tipo==$objCore->getExtraAvvisiId()) echo "Descrizione Completa:"; else echo "Risposta:";?></td>
         <td><textarea rows=8 cols=70 wrap="off" name="descrizione"></textarea>
             <img src="../../common/images/icon/star.gif" width="16" height="16"></td>
       </tr>
       <!--<tr><td>data</td><td> <input type="text" name="data"></td></tr>-->
       <tr>
         <td></td>
         <td>&nbsp;</td>
       </tr
>
     </table>
     
       <div align="center">
  <?php if (isset($_POST['servizio']) && $_POST['servizio'] !=-1 && $_POST['servizio'] !="" && $_POST['servizio'] !=-1 && $_POST['tipologia'] !="")
		echo "<input type=\"submit\" value=\"Inserisci\">";
	else echo "<input type=\"submit\" value=\"Inserisci\" disabled>";
?>  
       </div>
   </form>
   <br>
   <br>
   <?php
   if(isset($_POST['op']) && $_POST['op']=="ins"){
		//cattura i dati dal modulo
		$servizio =$_POST['servizio'];
		$titolo =checkText($_POST['titolo']);
		$breve =checkText($_POST['breve']);
		$descrizione =checkText($_POST['descrizione']);
		$data= date("j/n/Y");
		
		//li inserisce nella tabella
		if($objCore->insertExtra($titolo, $tipo,$servizio,1, $breve, $descrizione, $data)) echo"inserimento corretto<br><br>";
		else echo"inserimento fallito<br><br>";
		
		echo"<script language=javascript>";
		echo"document.location.href='../service/service_extra.php?tipo=".$tipo."'";
		echo"</script>";
}
?>
   </p>
   </fieldset>
 </div>
<div class="row">&nbsp;</div>
	<div class="row"><?php include("../_include/bofooter.php");?></div>        
</div>
</div>
</body>
</html>