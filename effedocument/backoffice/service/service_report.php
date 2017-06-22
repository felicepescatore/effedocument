<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include ("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloVisualizzatoreReportId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);

if (isset($_GET['id_servizio_padre'])) $id_servizio_padre=$_GET['id_servizio_padre'];
else $id_servizio_padre="";

if (isset($_GET['id_servizio'])) $id_servizio=$_GET['id_servizio'];
else $id_servizio="";

if (isset($_GET['prior'])) $prior=$_GET['prior'];
else $prior="";
?>
<?php
if (isset($_POST['hiddenPDF']) && ($_POST['hiddenPDF']!="")) {
require_once("dompdf_config.inc.php");

  //if ( get_magic_quotes_gpc() )
    //$_POST['hiddenPDF'] = stripslashes($_POST['hiddenPDF']);
  
  $old_limit = ini_set("memory_limit", "32M");
  
  $dompdf = new DOMPDF();
  $dompdf->load_html($_POST['hiddenPDF']);
  //$dompdf->set_paper($_POST["paper"], $_POST["orientation"]);
  $dompdf->set_paper('letter','landscape');
  $dompdf->render();

  $dompdf->stream("gestione_reclami_report_".date("j_n_Y").".pdf");

  exit(0);
}

?>
<html>
<head>
<style>
.BOTTONEImmagine{
width: 40px;
height: 40px;
background-color: #FFFFFF;
background-repeat: no-repeat;
background-position: center center;
}

TEXTAREA{
visibility: hidden;
}
</style>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<script language="JavaScript" src="../../common/script/ts_picker.js"></script>
<script language="JavaScript" src="../../common/script/effescript.js"></script>  
<link href="../../common/css/effecss.css" rel="stylesheet">
  <script language="JavaScript">
  function invia(){
  	document.reportForm.op.value="";
 	document.reportForm.action = "service_report.php";
    document.reportForm.submit();
   	}
  function resett(){
  	document.reportForm.op.value="";
    document.reportForm.idx_report.value="";
	document.reportForm.ufficio.value="";
	document.reportForm.idx_modalita_ricezione.value="";
	document.reportForm.tipologia.value="";
	document.reportForm.servizio="";	
	document.reportForm.data_inizio.value="";
	document.reportForm.data_fine.value="";		
	
	document.location.href="service_report.php";
   	}	
  </script>
  <style type="text/css">
<!--
.Stile1 {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Stile2 {
	font-size: 16px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
  </style>
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
  <div></div>
  <div class="Stile2" id="bar1">
  <?php 
createMenu($objCore,'', $objCore->getLoggedOperatoreRole());
?>
  &nbsp;&nbsp;<?php if (isset($_POST['idx_report']) && $_POST['idx_report']!="" && $_POST['idx_report']!="-1") echo "<i>".$objCore->reportGetNomeTipologia($_POST['idx_report'], $_POST['relativi_a']);?></i>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"></div>
<div align="center">
    <div class="row">
      <p><?php if (isset($_POST['op']) && ($_POST['op']=="gen"))
				 { 
				 	$id_report=$_POST['idx_report'];
					$id_ufficio=$_POST['ufficio'];
					$tipologia=$_POST['tipologia'];
					$ingressouscita=$_POST['ingressouscita'];

					if (isset($_POST['servizio'])) $servizio=$_POST['servizio'];				
					else $servizio="";
					$id_modalita_ricezione=$_POST['idx_modalita_ricezione'];
					$data_inizio=$_POST['data_inizio'];
					$data_fine=$_POST['data_fine'];					
					$realativi_a=$_POST['relativi_a'];
						
					$hidden_field_for_pdf="";
					$hidden_field_for_pdf.="<table width=\"80%\" border=\"0\" align=\"center\">";
					$hidden_field_for_pdf.="<tr bgcolor=\"#666666\" >";
					$hidden_field_for_pdf.="<td width=\"10%\"><span class=\"Stile1\"></span></td>";
				
					if ($id_report==0 && $realativi_a==0)
					{	//STORICO
						if ($id_ufficio==-1) $result = $objCore->getUfficiAttivi();
						else $result = $objCore->getUfficioDati($id_ufficio);
									
						//$index=0;
						
						$hidden_field_for_pdf.="<td align=\"center\"><span class=\"Stile1\">Protocollo</span></td>";
						$hidden_field_for_pdf.="<td align=\"center\"><span class=\"Stile1\">Nome Utente</span></td>";
						$hidden_field_for_pdf.="<td align=\"center\"><span class=\"Stile1\">Tipologia</span></td>";
						$hidden_field_for_pdf.="<td align=\"center\"><span class=\"Stile1\">Servizio</span></td>";
						$hidden_field_for_pdf.="<td align=\"center\"><span class=\"Stile1\">Modalità di Ricezione</span></td>";
						$hidden_field_for_pdf.="<td align=\"center\"><span class=\"Stile1\">Pervenimento</span></td>";
						$hidden_field_for_pdf.="<td align=\"center\"><span class=\"Stile1\">Presa in Carico</span></td>";
						$hidden_field_for_pdf.="<td align=\"center\"><span class=\"Stile1\">Predisposizione</span></td>";	
						$hidden_field_for_pdf.="<td align=\"center\"><span class=\"Stile1\">Validazione</span></td>";
						$hidden_field_for_pdf.="<td align=\"center\"><span class=\"Stile1\">Evasione</span></td>";	
						$hidden_field_for_pdf.="</tr>";
																				
						$color_select=0;
						$index=0;
						while($array_ufficio=mysql_fetch_array($result)){
							//seleziono il colore delle righe
							if ($color_select==0)
							{  $color_row="bgcolor=\"#CCCC99\"";
								$color_select=1;						
							}else{
								$color_row="bgcolor=\"#CCCCCC\"";
								$color_select=0;
							}
							
   							$array_res=$objCore->reportDocumentsHistory($array_ufficio['id'],$id_modalita_ricezione,$ingressouscita,$tipologia, $servizio,$data_inizio,$data_fine,-1);
							
							$index=$index+1;
							
							$hidden_field_for_pdf.="<tr ".$color_row.">";
							$hidden_field_for_pdf.="<td><span class=\"Stile1\" align=\"right\">".$array_ufficio['nome']."</span></td>";
							//td necessari per la generazione del pdf
							$hidden_field_for_pdf.="<td></td>";
							$hidden_field_for_pdf.="<td></td>";
							$hidden_field_for_pdf.="<td></td>";
							$hidden_field_for_pdf.="<td></td>";
							$hidden_field_for_pdf.="<td></td>";
							$hidden_field_for_pdf.="<td></td>";
							$hidden_field_for_pdf.="<td></td>";
							$hidden_field_for_pdf.="<td></td>";
							$hidden_field_for_pdf.="<td></td>";
							$hidden_field_for_pdf.="<td></td>";
							$hidden_field_for_pdf.="</tr>";
								
								$index_document=0;
								while($index_document<count($array_res))
								{
								  $hidden_field_for_pdf.="<tr ".$color_row." >";
								  //$hidden_field_for_pdf.="<tr bgcolor=\"#FFCC33\">";
								  if ($array_res[$index_document])
								  {
										$hidden_field_for_pdf.="<td bgcolor=\"#FFFFFF\" ></td>";								  
										$hidden_field_for_pdf.="<td align=\"center\"><b>".$array_res[$index_document][0]."</b></td>";
										$hidden_field_for_pdf.="<td align=\"center\"><b>".$array_res[$index_document][1]."</b></td>";
										$hidden_field_for_pdf.="<td align=\"center\"><b>".$array_res[$index_document][2]."</b></td>";
										$hidden_field_for_pdf.="<td align=\"center\"><b>".$array_res[$index_document][3]."</b></td>";
										$hidden_field_for_pdf.="<td align=\"center\"><b>".$array_res[$index_document][4]."</b></td>";
										$hidden_field_for_pdf.="<td align=\"center\"><b>".$array_res[$index_document][5]."</b></td>";
										$hidden_field_for_pdf.="<td align=\"center\"><b>".$array_res[$index_document][6]."</b></td>";
										$hidden_field_for_pdf.="<td align=\"center\"><b>".$array_res[$index_document][7]."</b></td>";
										$hidden_field_for_pdf.="<td align=\"center\"><b>".$array_res[$index_document][8]."</b></td>";
										$hidden_field_for_pdf.="<td align=\"center\"><b>".$array_res[$index_document][9]."</b></td>";
									}
																			
								  $index_document=$index_document+1;	 
								  $hidden_field_for_pdf.="</tr>"; 
								}							
								
						}
						$hidden_field_for_pdf.="</tr>";		
					}if ($id_report==1 && $realativi_a==0)
					{	//RICHIESTE EVASE/INEVASE
						if ($id_ufficio==-1) $result = $objCore->getUfficiAttivi();
						else $result = $objCore->getUfficioDati($id_ufficio);
										
						$index=0;
						while($array_ufficio=mysql_fetch_array($result)){
   							  $array_res[$index]=$objCore->reportRichiesteEvaseInevase($array_ufficio['id'],$id_modalita_ricezione, $ingressouscita, $tipologia, $servizio,$data_inizio,$data_fine,-1);
							  $index=$index+1;

							  $hidden_field_for_pdf.="<td><span class=\"Stile1\" align=\"right\">".$array_ufficio['nome']."</span></td>";
							  $hidden_field_for_pdf.="<td><span class=\"Stile1\" align=\"right\">".$array_ufficio['nome']." (%)</span></td>";
						}
						$hidden_field_for_pdf.="</tr>";
				 			
						$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">Evase</span></td>";				
						
					 	$index=0;
						while($index<count($array_res)){
   						  if ($array_res[$index]){
								$hidden_field_for_pdf.="<td><b>".$array_res[$index][0]."</b></td>";
								$hidden_field_for_pdf.="<td>".$array_res[$index][3]."%</td>";
						  }else{						  
							  $hidden_field_for_pdf.="<td>0</td>";
							  $hidden_field_for_pdf.="<td>0%</td>";
						  }
						  $index=$index+1;	  
						}
					
						$hidden_field_for_pdf.="</tr>";
						$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">Inevase</span></td>";					
					 	$index=0;
						while($index<count($array_res)){
						  if ($array_res[$index]){
								$hidden_field_for_pdf.="<td><b>".$array_res[$index][1]."</b></td>";
								$hidden_field_for_pdf.="<td>".$array_res[$index][4]."%</td>";
						 }else{
						 	$hidden_field_for_pdf.="<td>0</td>";
							$hidden_field_for_pdf.="<td>0%</td>";
						 }
						  $index=$index+1;						  
						}
						$hidden_field_for_pdf.="</tr>";	
						$hidden_field_for_pdf.="<tr bgcolor=\"#FFCC33\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#FFCC33\" width=\"25%\"><span class=\"Stile1\">Totale</span></td>";							
						
					 	$index=0;
						while($index<count($array_res))
						{
   						  if ($array_res[$index])
						  {
							$hidden_field_for_pdf.="<td><b>".$array_res[$index][2]."</b></td>";
							$hidden_field_for_pdf.="<td><b>100%</td>";
						  }else {
							$hidden_field_for_pdf.="<td>0</td>";
							$hidden_field_for_pdf.="<td>0%</td>";
						  }
						  $index=$index+1;
						}
						$hidden_field_for_pdf.="</tr>";		
					}else if ($id_report==2 && $realativi_a==0)
					{	//RICHIESTE ASSEGNATE/NON ASSEGNATE
						if ($id_ufficio==-1) $result = $objCore->getUfficiAttivi();
						else $result = $objCore->getUfficioDati($id_ufficio);
													
						$index=0;
						while($array_ufficio=mysql_fetch_array($result)){
							$array_res[$index]=$objCore->reportComposizioneEvaseInevase($array_ufficio['id'],$id_modalita_ricezione,$ingressouscita,$tipologia, $servizio,$data_inizio,$data_fine);
   							$hidden_field_for_pdf.="<td><span class=\"Stile1\">".$array_ufficio['nome']."</span></td>";
							$hidden_field_for_pdf.="<td><span class=\"Stile1\">".$array_ufficio['nome']." (%)</span></td>";
							$index=$index+1;
						}
						$hidden_field_for_pdf.="</tr>";
				 			
						$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">Assegnate</span></td>";							
					 	$index=0;
						while($index<count($array_res)){
   						  if ($array_res[$index])
						  { 
						  	$hidden_field_for_pdf.="<td><b>".$array_res[$index][0]."</b></td>";
							$hidden_field_for_pdf.="<td>".$array_res[$index][3]."%</td>";							
						  }else{  
						  	$hidden_field_for_pdf.="<td>0</td>";
						  	$hidden_field_for_pdf.="<td>0%</td>";							
						  }
						  $index=$index+1;
						}
						$hidden_field_for_pdf.="</tr>";
							
						$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">Non Assegnate</span></td>";							
					 	$index=0;
						while($index<count($array_res)){
						  if ($array_res[$index])
						  { 
						  	$hidden_field_for_pdf.="<td><b>".$array_res[$index][1]."</b></td>";
							$hidden_field_for_pdf.="<td>".$array_res[$index][4]."%</td>";
						  }else{ 
						  	$hidden_field_for_pdf.="<td>0</td>";
							$hidden_field_for_pdf.="<td>0%</td>";
							}
						  $index=$index+1;						  
						}
						$hidden_field_for_pdf.="</tr>";	
							
						$hidden_field_for_pdf.="<tr bgcolor=\"#FFCC33\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#FFCC33\" width=\"25%\"><span class=\"Stile1\">Totale</span></td>";							
					 	$index=0;
						while($index<count($array_res)){
   						  if ($array_res[$index]){
						  		$hidden_field_for_pdf.="<td><b>".$array_res[$index][2]."</b></td>";
								$hidden_field_for_pdf.="<td>100%</td>";
						  }else{
						  		$hidden_field_for_pdf.="<td>0</td>";
								$hidden_field_for_pdf.="<td>100%</td>";
							}
						  $index=$index+1;
						}
						$hidden_field_for_pdf.="</tr>";													
					}else if (($id_report==3 && $realativi_a==0) || ($id_report==1 && $realativi_a==1) || ($id_report==1 && $realativi_a==2))
					{//SERVIZI - SERVIZI RICHIESTE EVASE - SERVIZI RICHIESTE INEVASE
						if ($id_report==3 && $realativi_a==0) $stato="";
						else if ($id_report==1 && $realativi_a==1) $stato=$objCore->getStatoFinale();
						else $stato=-1;
						
						if ($id_ufficio==-1) $result = $objCore->getUfficiAttivi();
						else $result = $objCore->getUfficioDati($id_ufficio);
													
						$index=0;
						while($array_ufficio=mysql_fetch_array($result)){
						  	$array_res[$index]=$objCore->reportServizi($array_ufficio['id'],$id_modalita_ricezione,$ingressouscita,$tipologia, $servizio,$data_inizio,$data_fine, $stato);
						  	$index=$index+1;						
   							$hidden_field_for_pdf.="<td><span class=\"Stile1\">".$array_ufficio['nome']."</span></td>";
							$hidden_field_for_pdf.="<td><span class=\"Stile1\">".$array_ufficio['nome']." (%)</span></td>";
						}
						$hidden_field_for_pdf.="</tr>";
				 			
						$result_tem=$objCore->getServiziAttiveTutte();
						//creo le posizioni per i servizi
						$color="#99FF66";
						while($array_tem=mysql_fetch_array($result_tem))
						{		
							$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
							$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">".$array_tem['nome']."</span></td>";
							$index=0;
							while($index< count($array_res))
							{
								$hidden_field_for_pdf.="<td>".$array_res[$index][0][$array_tem['id']]."</td>";
								$hidden_field_for_pdf.="<td>".$array_res[$index][1][$array_tem['id']]."%</td>";

								$index=$index+1;
							}
						$hidden_field_for_pdf.="</tr>";
						}
												
						$hidden_field_for_pdf.="<tr bgcolor=\"#FFCC33\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#FFCC33\" width=\"25%\"><span class=\"Stile1\">Totale</span></td>";								
						$index=0;
						while($index<count($array_res))
						{	
							$hidden_field_for_pdf.="<td>".$array_res[$index][2]."</td>";
							$hidden_field_for_pdf.="<td>100%</td>";
							$index=$index+1;
						}
						$hidden_field_for_pdf.="</tr>";	
					}else if (($id_report==0 && $realativi_a==1) || ($id_report==0 && $realativi_a==2))
					{	//Tempistica RICHIESTE EVASE e Tempistica RICHIESTE INEVASE
						if ($id_report==0 && $realativi_a==1) $chiuse=1;
						else if ($id_report==0 && $realativi_a==2) $chiuse=0;
						
						if ($id_ufficio==-1) $result = $objCore->getUfficiAttivi();
						else $result = $objCore->getUfficioDati($id_ufficio);

						$index=0;
						while($array_ufficio=mysql_fetch_array($result)){
							$array_res[$index]=$objCore->reportTempisticaRichieste($array_ufficio['id'],$id_modalita_ricezione,$ingressouscita,$tipologia, $servizio,$data_inizio,$data_fine, $chiuse);
							$index=$index+1;
   							$hidden_field_for_pdf.="<td><span class=\"Stile1\">".$array_ufficio['nome']."</span></td>";
							$hidden_field_for_pdf.="<td><span class=\"Stile1\">".$array_ufficio['nome']." (%)</span></td>";
						}
						$hidden_field_for_pdf.="</tr>";
				 			
						$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">> 15gg</span></td>";							
					 	$index=0;
						while($index<count($array_res)){;
   						  if ($array_res[$index])
						  { 
							  	$hidden_field_for_pdf.="<td><b>".$array_res[$index][0]."</b></td>";
								$hidden_field_for_pdf.="<td>".$array_res[$index][5]."%</td>";
						  }else{  
						  	$hidden_field_for_pdf.="<td>0 (0%)</td>";
						  	$hidden_field_for_pdf.="<td>0%</td>";							
						  }
						  $index=$index+1;
						}
						$hidden_field_for_pdf.="</tr>";
							
						$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">11 - 15gg</span></td>";							
					 	$index=0;
						while($index<count($array_res)){
						  if ($array_res[$index])
						  {	$hidden_field_for_pdf.="<td><b>".$array_res[$index][1]."</b></td>";
						  	$hidden_field_for_pdf.="<td>".$array_res[$index][6]."%</td>";
						  } else{
						  	$hidden_field_for_pdf.="<td>0</td>";
							$hidden_field_for_pdf.="<td>0%</td>";
						  }
						  $index=$index+1;
						}
						$hidden_field_for_pdf.="</tr>";	

						$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">6 - 10gg</span></td>";							
					 	$index=0;
						while($index<count($array_res)){
   						  if ($array_res[$index]){
						  	$hidden_field_for_pdf.="<td><b>".$array_res[$index][2]."</b></td>";
							$hidden_field_for_pdf.="<td>".$array_res[$index][7]."%</td>";
						  }else{
						  	$hidden_field_for_pdf.="<td>0 (0%)</td>";
							$hidden_field_for_pdf.="<td>0%</td>";					  
						  }
						  $index=$index+1;						  
						}
						$hidden_field_for_pdf.="</tr>";
							
						$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\"><= 5gg</span></td>";							
					 	$index=0;
						while($index<count($array_res)){
						  if ($array_res[$index]){
						  	$hidden_field_for_pdf.="<td><b>".$array_res[$index][3]."</b></td>";
							$hidden_field_for_pdf.="<td>".$array_res[$index][8]."%</td>";
						  }else{
						  	$hidden_field_for_pdf.="<td>0</td>";
							$hidden_field_for_pdf.="<td>0%</td>";
						  }
  						  $index=$index+1;
						}
						$hidden_field_for_pdf.="</tr>";	
							
						$hidden_field_for_pdf.="<tr bgcolor=\"#FFCC33\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#FFCC33\" width=\"25%\"><span class=\"Stile1\">Totale</span></td>";							
					 	$index=0;
						while($index<count($array_res)){
   						  if ($array_res[$index]){
						  	$hidden_field_for_pdf.="<td><b>".$array_res[$index][4]."</b></td>";
							$hidden_field_for_pdf.="<td>100%</td>";
						  }else{
						  	$hidden_field_for_pdf.="<td>0</td>";
							$hidden_field_for_pdf.="<td>100%</td>";
						   }
						  $index=$index+1;
						}
						$hidden_field_for_pdf.="</tr>";													
					} else if (($id_report==2 && $realativi_a==1) || ($id_report==2 && $realativi_a==2))
					{ //SERVIZI TEMPISTICA
						if ($id_report==2 && $realativi_a==1) $chiuse=1;
						else if ($id_report==2 && $realativi_a==2) $chiuse=0;
						
						if ($id_ufficio==-1) $result_uffici = $objCore->getUfficiAttivi();
						else $result_uffici = $objCore->getUfficioDati($id_ufficio);
													
						while($array_ageenzie=mysql_fetch_array($result_uffici)){
   							$hidden_field_for_pdf.="<td><span class=\"Stile1\">".$array_uffici['nome']."</span></td>";
							$hidden_field_for_pdf.="<td><span class=\"Stile1\">".$array_uffici['nome']." (%)</span></td>";
						}
						$hidden_field_for_pdf.="</tr>";


					if ($servizio=="" || $servizio==-1)
							$result_servizi=$objCore->getServiziAttiviTutti();
					else $result_servizi = $objCore->getServizioDati($servizio);
						
						while($array_servizi=mysql_fetch_array($result_servizi))
						{
							$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
							$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">(".$array_servizi['nome'].") >15gg</span></td>";			

							mysql_data_seek($result_uffici,0);
							while ($array_uffici=mysql_fetch_array($result_uffici))
							{	
								$array_report=$objCore->reportTempisticaRichieste($array_uffici['id'],$id_modalita_ricezione,$ingressouscita,$tipologia, (int)$array_servizi['id'],$data_inizio,$data_fine, $chiuse);

						  		if ($array_report)
								{
									$hidden_field_for_pdf.="<td><b>".$array_report[0]."</b></td>";
									$hidden_field_for_pdf.="<td>".$array_report[5]."%</td>";
							  	}else{
									$hidden_field_for_pdf.="<td>0</td>";
									$hidden_field_for_pdf.="<td>0%</td>";
								}
							}
							$hidden_field_for_pdf.= "</tr>";
														
							$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
							$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">(".$array_servizi['nome'].") 11-15gg</span></td>";					
							mysql_data_seek($result_uffici,0);
							while ($array_uffici=mysql_fetch_array($result_uffici))
							{	
								$array_report=$objCore->reportTempisticaRichieste($array_ufficii['id'],$id_modalita_ricezione,$ingressouscita,$tipologia, (int)$array_servizi['id'],$data_inizio,$data_fine, $chiuse);

						  		if ($array_report){
									$hidden_field_for_pdf.="<td><b>".$array_report[1]."</b></td>";
									$hidden_field_for_pdf.="<td>".$array_report[6]."%</td>";
							  	}else{
									$hidden_field_for_pdf.="<td>0</td>";
									$hidden_field_for_pdf.="<td>0%</td>";
								}
							}
							$hidden_field_for_pdf.= "</tr>";	
							
							$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
							$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">(".$array_servizi['nome'].") 6-10gg</span></td>";					
							mysql_data_seek($result_uffici,0);
							while ($array_uffici=mysql_fetch_array($result_uffici))
							{	
								$array_report=$objCore->reportTempisticaRichieste($array_uffici['id'],$id_modalita_ricezione,$ingressouscita,$tipologia, (int)$array_servizi['id'],$data_inizio,$data_fine, $chiuse);

						  		if ($array_report){
									$hidden_field_for_pdf.="<td><b>".$array_report[2]."</b></td>";
									$hidden_field_for_pdf.="<td>".$array_report[7]."%</td>";
							  	}else{
									$hidden_field_for_pdf.="<td>0</td>";
									$hidden_field_for_pdf.="<td>0%</td>";
								}
							}
							$hidden_field_for_pdf.= "</tr>";
							
							$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
							$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">(".$array_servizi['nome'].") <=5gg</span></td>";					
							mysql_data_seek($result_uffici,0);
							while ($array_uffici=mysql_fetch_array($result_uffici))
							{	
								$array_report=$objCore->reportTempisticaRichieste($array_uffici['id'],$id_modalita_ricezione,$ingressouscita,$tipologia, (int)$array_servizi['id'],$data_inizio,$data_fine, $chiuse);

						  		if ($array_report){
									$hidden_field_for_pdf.="<td><b>".$array_report[3]."</b></td>";
									$hidden_field_for_pdf.="<td>".$array_report[8]."%</td>";								
							  	}else{
									$hidden_field_for_pdf.="<td>0</td>";
									$hidden_field_for_pdf.="<td>0%</td>";									
								}
							}
							$hidden_field_for_pdf.= "</tr>";
														
							$hidden_field_for_pdf.="<tr bgcolor=\"#FFCC33\">";
							$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">(".$array_servizi['nome'].") Totale Parziale</span></td>";					
							mysql_data_seek($result_uffici,0);
							$index_totale_document=0;
							while ($array_uffici=mysql_fetch_array($result_uffici))
							{	
								$array_report=$objCore->reportTempisticaRichieste($array_uffici['id'],$id_modalita_ricezione,$ingressouscita,$tipologia, (int)$array_servizi['id'],$data_inizio,$data_fine, $chiuse);

								$totale_document[$index_totale_document]=$totale_document[$index_totale_document]+$array_report[4];
								$index_totale_document=$index_totale_document+1;
								
						  		if ($array_report){
									$hidden_field_for_pdf.="<td><b>".$array_report[4]."</b></td>";
									$hidden_field_for_pdf.="<td>100%</td>";
								}else{
									$hidden_field_for_pdf.="<td>0</td>";
									$hidden_field_for_pdf.="<td>0%</td>";
								}
							}
							$hidden_field_for_pdf.= "</tr>";
						}	
						$hidden_field_for_pdf.="<tr bgcolor=\"#FFCC33\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#FFCC33\" width=\"25%\"><span class=\"Stile1\">Totale</span></td>";
						mysql_data_seek($result_uffici,0);
						$index=0;
						while ($array_uffici=mysql_fetch_array($result_uffici))
							{	
						  		$hidden_field_for_pdf.="<td><b>".$totale_document[$index]."</b></td>";
								$hidden_field_for_pdf.="<td>100%</td>";
								$index=$index+1;
							  	
							}	
						
					}else if (($id_report==4 && $realativi_a==0) || ($id_report==3 && $realativi_a==1) || ($id_report==3 && $realativi_a==2))
					{ //MODALITA' DI RICEZIONE (Entrambe - Evase - Inevase)
						if ($id_report==4 && $realativi_a==0) $chiuse=-1;
						else if ($id_report==3 && $realativi_a==1) $chiuse=1;
						else if ($id_report==3 && $realativi_a==2) $chiuse=0;						
						
						if ($id_ufficio==-1) $result_uffici = $objCore->getUfficiAttivi();
						else $result_uffici = $objCore->getUfficioDati($id_ufficio);
													
						while($array_uffici=mysql_fetch_array($result_uffici)){
   							$hidden_field_for_pdf.="<td><span class=\"Stile1\">".$array_uffici['nome']."</span></td>";
							$hidden_field_for_pdf.="<td><span class=\"Stile1\">".$array_uffici['nome']." (%)</span></td>";							
						}
						$hidden_field_for_pdf.="</tr>";


					if (!is_integer($id_modalita_ricezione) || ($id_modalita_ricezione==-1))
							$array_modalita_ricezione=$objCore->getModalitaRicezione();
					else $array_modalita_ricezione[0] = $objCore->getModalitaRicezioneNome($id_modalita_ricezione);

						for ($index_ricezione=0; $index_ricezione<count($array_modalita_ricezione); $index_ricezione++){
							$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
							$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">(".$array_modalita_ricezione[$index_ricezione].") Aperte</span></td>";			

							mysql_data_seek($result_uffici,0);
							while ($array_uffici=mysql_fetch_array($result_uffici))
							{	
								$array_report=$objCore->reportRichiesteEvaseInevase($array_uffici['id'],$index_ricezione,$ingressouscita,$tipologia, $servizio,$data_inizio,$data_fine,$chiuse);

						  		if ($array_report){
									$hidden_field_for_pdf.="<td><b>".$array_report[0]."</b></td>";
									$hidden_field_for_pdf.="<td>".$array_report[3]."%</td>";
								}else{
									$hidden_field_for_pdf.="<td>0</td>";
									$hidden_field_for_pdf.="<td>0%</td>";
								}
							}
							$hidden_field_for_pdf.= "</tr>";
														
							$hidden_field_for_pdf.="<tr bgcolor=\"#CCCC99\">";
							$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">(".$array_modalita_ricezione[$index_ricezione].") Chiuse</span></td>";					
							mysql_data_seek($result_uffici,0);
							while ($array_uffici=mysql_fetch_array($result_uffici))
							{	
								$array_report=$objCore->reportRichiesteEvaseInevase($array_uffici['id'],$index_ricezione,$ingressouscita,$tipologia, $servizio,$data_inizio,$data_fine,$chiuse);

						  		if ($array_report){
									$hidden_field_for_pdf.="<td><b>".$array_report[1]."</b></td>";
									$hidden_field_for_pdf.="<td>".$array_report[4]."%</td>";
							  	}else{
									$hidden_field_for_pdf.="<td>0</td>";
									$hidden_field_for_pdf.="<td>0%</td>";
								}
							}
							$hidden_field_for_pdf.= "</tr>";	
														
							$hidden_field_for_pdf.="<tr bgcolor=\"#FFCC33\">";
							$hidden_field_for_pdf.="<td bgcolor=\"#666666\" width=\"25%\"><span class=\"Stile1\">(".$array_modalita_ricezione[$index_ricezione].") Totale Parziale</span></td>";					
							mysql_data_seek($result_uffici,0);
							$index_totale_document=0;
							while ($array_uffici=mysql_fetch_array($result_uffici))
							{	
								$array_report=$objCore->reportRichiesteEvaseInevase($array_uffici['id'],$index_ricezione,$ingressouscita,$tipologia, $servizio,$data_inizio,$data_fine,$chiuse);

								$totale_document[$index_totale_document]=$totale_document[$index_totale_document]+$array_report[2];
								$index_totale_document=$index_totale_document+1;

						  		if ($array_report){
									$hidden_field_for_pdf.="<td><b>".$array_report[2]."</b></td>";
									$hidden_field_for_pdf.="<td>100%</td>";
									
								}else{
									$hidden_field_for_pdf.="<td>0</td>";
									$hidden_field_for_pdf.="<td>0%</td>";
								}
							}
							$hidden_field_for_pdf.= "</tr>";
						}
						$hidden_field_for_pdf.="<tr bgcolor=\"#FFCC33\">";
						$hidden_field_for_pdf.="<td bgcolor=\"#FFCC33\" width=\"25%\"><span class=\"Stile1\">Totale</span></td>";
						mysql_data_seek($result_uffici,0);
						$index=0;
						while ($array_uffici=mysql_fetch_array($result_uffici))
							{	
						  		$hidden_field_for_pdf.="<td><b>".$totale_document[$index]."</b></td>";
								$hidden_field_for_pdf.="<td>100%</td>";
								$index=$index+1;
							  	
							}	
						
					}
					echo $hidden_field_for_pdf;
					echo "</table>";
					
					$hidden_field_for_xls=$hidden_field_for_pdf;
					
					$hidden_field_for_pdf="<p align=\"center\"><img src=\"..\images\loghi\gestione_reclami.gif\" width=\"400\" height=\"110\"/></p><br><br>"."<p align=\"center\"><b>".$objCore->reportGetNomeTipologia($_POST['idx_report'], $_POST['relativi_a'])."</b></p><br><br>".$hidden_field_for_pdf;

					$hidden_field_for_pdf.="</table>";
					$hidden_field_for_pdf.="<br><br><p align=\"center\"> Generato in data:".date("j/n/Y")."</p>";
					
					$hidden_field_for_xls.="</table>";
					$hidden_field_for_xls.="<br><br><p align=\"center\"> Generato in data:".date("j/n/Y")."</p>";
					
					if ($_POST['idx_report']!=-1)
					{	echo "<table align=\"center\">";
					 	echo "<tr>";
						echo "<td width=\"50%\">";

						echo "<form action=\"service_report.php\" method=\"post\">";	
						echo "<textarea name=\"hiddenPDF\" cols=\"45\" id=\"textarea\">".$hidden_field_for_pdf."</textarea>"	;
						echo "<div align=\"right\">";
						echo "<input type=\"submit\" class=\"BOTTONEImmagine\" name=\"button\" id=\"buttonpdf\" value=\"\" style=\"background-image: url('images/icon/pdf_ico.jpg')\"/>";
						echo "</div>";
						echo "</form>";
						echo "</td>";
						echo "<td>";
						
						echo "<form action=\"xls/report2xls.php\" method=\"post\">";
						echo "<textarea name=\"hiddenXLS\" cols=\"45\" id=\"textarea\">".$hidden_field_for_xls."</textarea>";
						echo "<div align=\"left\">";
						echo "<input type=\"submit\" class=\"BOTTONEImmagine\" name=\"button\" id=\"buttonxls\" value=\"\" style=\"background-image: url('images/icon/excel_ico.jpg')\" />";
						echo "</div>";
						echo "</form>";

						echo "</td>";
						echo "</tr>";
						echo "</table>";
					}
				 }
				?>

                </p>
<fieldset>
      <legend><img src="../../common/images/layout/filtra.png" width="70" height="70"> Filtri </legend>
      <p><img src="../../common/images/extra/longmenu_right.gif" width="455"></p>
      <legend></legend>
                 <legend></legend>
                 <legend></legend>
<form name="reportForm" method="post" action="service_report.php">
  <table width="100%" border="0">
                     <tr>
                       <td width="18%">Ufficio</td>
                       <td width="64%"><select name="ufficio" size="1" id="ufficio">
                         <?php echo "<option value=\"-1\">Tutte</option>";
							$result = $objCore->getUfficiAttivi();
							while($array_ufficio=mysql_fetch_array($result)){
								echo "<option value=\"".$array_ufficio['id']."\"";
									if (isset($_POST['ufficio']) && $_POST['ufficio']==$array_ufficio['id']) echo " selected";
								echo">".$array_ufficio['nome']."</option>";
							}
							?>
                       </select></td>
                       <td width="18%"><input type="submit" name="button" id="button" value="Report">
                         <label>
                         <input type="submit" name="reset" id="reset" value="Reset" onClick="resett()">
                         <input name="op" type="hidden" id="op" value="gen">
                         </label></td>
                     </tr>
                     <tr>
                       <td>Ingresso/Uscita</td>
                       <td colspan="2"><select name="ingressouscita" size="1" id="ingressouscita" onChange="invia()">
                           <option value="-1" <?php if (isset($_POST['ingressouscita']) && $_POST['ingressouscita']==-1) echo " selected" ?>>Tutti</option>
                           <option value="0" <?php if (isset($_POST['ingressouscita']) && $_POST['ingressouscita']==0) echo " selected" ?>>Ingresso</option>
                           <option value="1" <?php if (isset($_POST['ingressouscita']) && $_POST['ingressouscita']==1) echo " selected" ?>>Uscita</option>
                       </select></td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="2">&nbsp;</td>
                     </tr>
                     <tr>
                       <td>Report Relativi a:</td>
                       <td colspan="2"><select name="relativi_a" size="1" id="relativi_a" onChange="invia()">
                           <option value="0" <?php if (isset($_POST['relativi_a']) && $_POST['relativi_a']==0) echo " selected" ?>>Tutti</option>
                           <option value="1" <?php if (isset($_POST['relativi_a']) && $_POST['relativi_a']==1) echo " selected" ?>>Evasi</option>
                           <option value="2" <?php if (isset($_POST['relativi_a']) && $_POST['relativi_a']==2) echo " selected" ?>>Inevasi</option>
                       </select></td>
                     </tr>
                     <tr>
                       <td>Tipologia Report:</td>
                       <td colspan="2"><select name="idx_report" size="1" id="idx_report">
                           <?php echo "<option value=\"0\">[seleziona una tipologia di report]</option>";
							if ($_POST['relativi_a']==0) 
								$result_tipo_report = $objCore->getReport($objCore->getIDreportDocumentEvasiInevasi());
						else if ($_POST['relativi_a']==1) 
								$result_tipo_report = $objCore->getReport($objCore->getIDreportDocumentEvasi());	
						else if ($_POST['relativi_a']==2) 
								$result_tipo_report = $objCore->getReport($objCore->getIDreportDocumentInevasi());															
							for ($i=0; $i<count($result_tipo_report); $i++){
								echo "<option value=\"$i\"";
								if (isset($_POST['idx_report']) && $_POST['idx_report']!="" && $_POST['idx_report']==$i) echo " selected";
								echo ">$result_tipo_report[$i]</option>";
							}
						?>
                       </select>                         <label></label></td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="2">&nbsp;</td>
                     </tr>
                     <tr>
                       <td>Modalit&agrave; di Ricezione</td>
                       <td colspan="2"><select name="idx_modalita_ricezione" size="1" id="idx_modalita_ricezione">
                           <?php echo "<option value=\"-1\">Tutte</option>";
							$result_modalita_ricezione = $objCore->getModalitaRicezione();
							for ($i=0; $i<count($result_modalita_ricezione); $i++){
								echo "<option value=\"$i\"";
								if (isset($_POST['idx_modalita_ricezione']) && $_POST['idx_modalita_ricezione']!="" && $_POST['idx_modalita_ricezione']==$i) echo " selected";
								echo ">$result_modalita_ricezione[$i]</option>";
							}
							?>
                       </select></td>
                     </tr>
                     <tr>
                       <td>Tipologia di Richiesta</td>
                       <td colspan="2"><select name="tipologia" size="1" id="tipologia" onChange="invia()">
                           <?php
							echo "<option value=\"-1\">Tutte</option>"; 
							$result=$objCore->getTipologieAttive();
							while($array_tipologie=mysql_fetch_array($result)){
								echo "<option value=\"".$array_tipologie['id']."\"";
									if (isset($_POST['tipologia']) && $_POST['tipologia']==$array_tipologie['id']) echo " selected";
								echo">".$array_tipologie['nome']."</option>";
							}
						?>
                       </select></td>
                     </tr>
                       <?php if (isset($_POST['tipologia']) && $_POST['tipologia']!=-1 && $_POST['tipologia'] !="") { ?> 
					  <tr>
                       <td>Servizio:</td>
                       <td colspan="2"><select name="servizio" size="1" id="servizio">
                           <?php 
							echo "<option value=\"-1\">[seleziona servizio]</option>"; 
							$result=$objCore->getServiziAttivi($_POST['tipologia']);
							while($array_servizi=mysql_fetch_array($result)){
								echo "<option value=\"".$array_servizi['id']."\"";
									if (isset($_POST['servizio']) && $_POST['servizio']!="" && $_POST['servizio']==$array_servizi['id']) echo " selected";
								echo">".$array_servizi['nome']."</option>";
							}
							?>
                            </select></td>
                     </tr>
                          <?php } ?>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="2">&nbsp;</td>
                     </tr>
                     <tr>
                       <td>Data inizio intervallo:</td>
                       <td colspan="2"><input name="data_inizio" type="Text" id="data_inizio" value="<?php 
					   	if (isset($_POST['data_inizio']))
							echo $_POST['data_inizio'];
						else echo "";
						?>">
                         <a href="javascript:show_calendar('document.reportForm.data_inizio', document.reportForm.data_inizio.value);"><img src="../../common/images/icon/cal.gif" alt="Seleziona la data" width="30" border="0"></a></td>
                     </tr>
                     <tr>
                       <td>Data fine intervallo:</td>
                       <td colspan="2"><input name="data_fine" type="Text" id="data_fine" value="<?php 
					   	if (isset($_POST['data_fine']))
							echo $_POST['data_fine'];
						else echo "";
						?>">
                         <a href="javascript:show_calendar('document.reportForm.data_fine', document.reportForm.data_fine.value);"><img src="../../common/images/icon/cal.gif" alt="Seleziona la data" width="30" border="0"></a></td>
                     </tr>
                   </table>
      </form>
      </fieldset>                 
</div>
    <div class="row">
      <?php include("../_include/bofooter.php");?></div>        </div>
</div>
</body>
</html>