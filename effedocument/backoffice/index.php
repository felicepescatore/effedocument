<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><!DOCTYPE html>
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.5.0.0 - Licenza GPL-->
<!-- Data Rilascio: 01 Novembre 2026 (prima versione: 02 Febbraio 2010)-->
<!-- Developer: ing. Felice Pescatore-->
<html lang="it">
<head>
<meta charset="ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Accesso operatori - eFFe Document</title>
<link href="../common/css/effecss.css?v=1.5.0-5759dd" rel="stylesheet">
</head>
<body>
<main class="accesso">
  <div class="accesso-box">
    <div class="accesso-testa">
      <div class="accesso-riga"><a class="home-sito" href="../index.php" title="Home page del sito" aria-label="Home page del sito"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11 12 4l9 7"/><path d="M5 10v10h5v-6h4v6h5V10"/></svg></a><span class="brand"><span class="brand-mark" aria-hidden="true"></span>eFFe Document</span></div>
      <p>Accesso riservato agli operatori</p>
    </div>
    <form name="login" action="_security/valida.php" method="post">
      <?php if (isset($_GET['errore'])) { ?>
      <p class="errore" role="alert">Nome utente o password non corretti.</p>
      <?php } ?>
      <div class="campo">
        <label for="login">Nome utente</label>
        <input name="login" id="login" autocomplete="username" required autofocus>
      </div>
      <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" autocomplete="current-password" required>
      </div>
      <input class="primario" type="submit" value="Accedi" name="Submit">
    </form>
    <div class="piede">
      <span>Versione 1.5.0</span>
      <a href="http://www.felicepescatore.it" target="_blank" rel="noopener" title="ing. Felice Pescatore"><img src="../common/images/loghi/logofp.png" width="102" height="58" alt="ing. Felice Pescatore"></a>
    </div>
  </div>
</main>
</body>
</html>
