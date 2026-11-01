<?php
	if (isset($level) && $level==2) $prefix = "../";
	else $prefix = "";
?>
<header class="sitebar">
  <div class="sitebar-in">
    <a class="home-sito" href="<?php echo $prefix ?>../index.php" title="Home page del sito" aria-label="Home page del sito"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11 12 4l9 7"/><path d="M5 10v10h5v-6h4v6h5V10"/></svg></a>
    <a class="brand" href="<?php echo $prefix ?>index.php"><span class="brand-mark" aria-hidden="true"></span>eFFe Document</a>
    <nav aria-label="Sezioni">
      <a href="<?php echo $prefix ?>index.php">Sportello</a>
      <a href="<?php echo $prefix ?>wizard/docwizard1.php">Invia un documento</a>
      <a href="<?php echo $prefix ?>extra/extra.php?tipo=<?php echo $objCore->getExtraKnowledgebaseId(); ?>">Domande frequenti</a>
      <a href="<?php echo $prefix ?>extra/extra.php?tipo=<?php echo $objCore->getExtraAvvisiId(); ?>">Avvisi</a>
    </nav>
    <form class="cerca" action="<?php echo $prefix ?>extra/extra_cerca.php" method="post" role="search">
      <label for="keyword" class="nascosto">Cerca nelle domande frequenti</label>
      <input type="text" name="keyword" id="keyword" placeholder="Cerca nelle domande frequenti">
      <input type="submit" name="button" id="button" value="Cerca">
    </form>
  </div>
</header>
