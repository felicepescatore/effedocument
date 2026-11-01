<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><!DOCTYPE html>
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.5.0.0 - Licenza GPL-->
<!-- Data Rilascio: 01 Novembre 2026 (prima versione: 02 Febbraio 2010)-->
<!-- Developer: ing. Felice Pescatore-->
<html lang="it">
<head>
<meta charset="ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>eFFe Document - gestione documentale, workflow e protocollo</title>
<link href="common/css/effecss.css?v=1.5.0-5759dd" rel="stylesheet">
</head>
<body class="lancio">
<main>
  <section class="lancio-hero">
    <div class="lancio-in">
      <p class="lancio-marchio"><span class="brand-mark" aria-hidden="true"></span>eFFe Document <span>versione 1.5.0</span></p>
      <h1>Gestione documentale con workflow e protocollo, interamente open source.</h1>
      <p class="lancio-testo">Benvenuti in eFFe Document: registra i documenti in ingresso e in uscita, assegna il protocollo con codice a barre e segui ogni pratica attraverso il suo workflow, dall'arrivo alla risposta.</p>
    </div>
  </section>
  <section class="lancio-in lancio-scelte" aria-label="Accesso">
    <a class="azione principale" href="frontoffice/index.php">
      <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 10 12 4l9 6M5 10v9h14v-9M10 19v-5h4v5"/></svg>
      <h2>Front Office</h2>
      <p>Per la fruizione dei servizi e la registrazione esterna di documenti.</p>
    </a>
    <a class="azione" href="backoffice/index.php">
      <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="5" y="10" width="14" height="10" rx="1"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
      <h2>Back Office</h2>
      <p>Funzionalit&agrave; complete di gestione per gli operatori: protocollo, assegnazioni, risposte e report.</p>
    </a>
    <a class="azione" href="backoffice/_help/effedoc.php">
      <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 5h6a2 2 0 0 1 2 2v12a2 2 0 0 0-2-2H4zM20 5h-6a2 2 0 0 0-2 2v12a2 2 0 0 1 2-2h6z"/></svg>
      <h2>Guida</h2>
      <p>Installazione, configurazione e uso del sistema.</p>
    </a>
  </section>
</main>
<footer class="piede">
  <span>Copyright &copy; 2010-2026 <a href="http://www.felicepescatore.it" target="_blank" rel="noopener">felicepescatore.it</a>. Rilasciato con licenza GPL.</span>
  <a href="http://www.felicepescatore.it" target="_blank" rel="noopener" title="ing. Felice Pescatore"><img src="common/images/loghi/logofp.png" width="102" height="58" alt="ing. Felice Pescatore"></a>
</footer>
</body>
</html>
