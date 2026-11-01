<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("../common/core/core.php");

?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Effe Document</title>
	<link rel="stylesheet" type="text/css" media="all" href="../common/css/effecss.css?v=1.5.0-5759dd" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../common/script/effe-ui.js?v=1.5.0-5759dd" defer></script>        
</head>
<body>
<?php include("include/foheader.php"); ?>
<div id="wrapper" class="fo-main">
    	<div id="secWrapper">
       	  <div id="container" class="clearfix">
       	    <div class="fo-intro">
  <h1>Sportello documenti</h1>
  <p>Invia una richiesta o un documento agli uffici: ricevi subito un numero di protocollo. Prima di scrivere, controlla se la tua domanda ha gi&agrave; una risposta tra le domande frequenti.</p>
</div>
<div class="azioni">
  <a class="azione principale" href="wizard/docwizard1.php">
    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4M9 13h6M12 10v6"/></svg>
    <h2>Invia un documento</h2>
    <p>Compila il modulo, allega un file e ricevi il numero di protocollo.</p>
  </a>
  <a class="azione" href="extra/extra.php?tipo=<?php echo $objCore->getExtraKnowledgebaseId() ?>">
    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M9.5 9.5a2.5 2.5 0 1 1 3.5 2.3c-.6.3-1 .8-1 1.5V14M12 17h.01"/></svg>
    <h2>Domande frequenti</h2>
    <p>Le risposte alle domande pi&ugrave; comuni, divise per argomento.</p>
  </a>
  <a class="azione" href="extra/extra.php?tipo=<?php echo $objCore->getExtraAvvisiId() ?>">
    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 10v4h3l6 4V6L7 10z"/><path d="M16.5 9a4 4 0 0 1 0 6"/></svg>
    <h2>Avvisi</h2>
    <p>Comunicazioni e annunci pubblicati dagli uffici.</p>
  </a>
</div>
<div class="elenchi">
  <section>
    <div class="qbtitle">Ultimi avvisi</div>
    <?php
	$trovati=0;
	$result = $objCore->getAvvisiHomePage();
	while($array=mysql_fetch_array($result)){
		$trovati++;
		echo "<div class=\"navitem\"><a href=\"extra/extra_leggi.php?tipo=".$objCore->getExtraAvvisiId()."&id=".$array['id']."\">".$array['titolo_domanda']."</a> <small>".visualizzaDataEuro($array['data'])."</small></div>";
	}
	if ($trovati==0) echo "<p class=\"smalltext\">Nessun avviso pubblicato.</p>";
    ?>
  </section>
  <section>
    <div class="qbtitle">Ultime domande frequenti</div>
    <?php
	$trovati=0;
	$result = $objCore->getKnowledgebaseHomePage();
	while($array=mysql_fetch_array($result)){
		$trovati++;
		echo "<div class=\"navitem\"><a href=\"extra/extra_leggi.php?tipo=".$objCore->getExtraKnowledgebaseId()."&id=".$array['id']."\">".$array['titolo_domanda']."</a> <small>".visualizzaDataEuro($array['data'])."</small></div>";
	}
	if ($trovati==0) echo "<p class=\"smalltext\">Nessuna domanda pubblicata.</p>";
    ?>
  </section>
</div>
       	  </div>
  </div>
</div>
<?php include("include/folfooter.php"); ?>
</body>
</html>
