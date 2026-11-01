<?php
// Intestazione del backoffice: barra con marchio, operatore collegato e menu.
// Prima di includerla impostare $menuSelezionato con la voce di menu attiva.
if (!isset($menuSelezionato)) $menuSelezionato = 0;
$ruoloCorrente = $objCore->getLoggedOperatoreRole();
?>
<header class="appbar">
  <a class="home-sito" href="../../index.php" title="Home page del sito" aria-label="Home page del sito"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11 12 4l9 7"/><path d="M5 10v10h5v-6h4v6h5V10"/></svg></a>
  <a class="brand" href="<?php echo paginaIniziale($objCore, $ruoloCorrente); ?>"><span class="brand-mark" aria-hidden="true"></span>eFFe Document</a>
  <button type="button" class="nav-toggle" aria-expanded="false" aria-controls="menu">Menu</button>
  <div class="utente">
    <span><strong><?php echo htmlspecialchars($objCore->getLoggedOperatore(), ENT_QUOTES, 'ISO-8859-1'); ?></strong>, <?php echo htmlspecialchars($objCore->getRuoloNome($ruoloCorrente), ENT_QUOTES, 'ISO-8859-1'); ?></span>
    <?php if (empty($_SESSION['LDAP'])) { ?><a href="../modifica/modifica_password.php">Modifica password</a><?php } ?>
    <a href="javascript:apri('Help','../_help/effedoc.php',500,600);">Guida</a>
    <a href="../_security/logout.php?private=true">Esci</a>
  </div>
</header>
<?php createMenu($objCore, $menuSelezionato, $ruoloCorrente); ?>
