<?php
/**
 * eFFe Document - verifica dell'installazione
 *
 * Controlla che il server abbia tutto il necessario. Non mostra password
 * o altri dati riservati. A installazione completata, CANCELLARE QUESTO FILE.
 */
if (version_compare(PHP_VERSION, '7.0.0', '<')) {
    header('Content-Type: text/plain; charset=UTF-8');
    exit('eFFe Document richiede PHP 8.1 o superiore. Questo server usa PHP ' . PHP_VERSION . ': scegli una versione piu\' recente dal pannello dell\'hosting.');
}
ob_start();
header('Content-Type: text/html; charset=UTF-8');
header('X-Robots-Tag: noindex');
error_reporting(0);

$root      = __DIR__;
$allegati  = $root . '/documenti_allegati/';
$sondaExec = $allegati . '_verifica_exec.php';
$sondaLog  = $root . '/log/_verifica_sonda.txt';
$sondaAll  = $allegati . '_verifica_allegato.txt';

// Pulizia del file sonda creato per il test degli script negli allegati
if (isset($_GET['pulisci'])) {
    @unlink($sondaExec);
    @unlink($sondaLog);
    @unlink($sondaAll);
    header('Content-Type: text/plain; charset=UTF-8');
    exit('ok');
}

$risultati = array();
function esito($gruppo, $voce, $stato, $nota = '')
{
    // $stato: ok | avviso | errore
    $GLOBALS['risultati'][$gruppo][] = array($voce, $stato, $nota);
}
function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function inByte($v)
{
    $v = trim((string)$v);
    if ($v === '') return 0;
    $n = (float)$v;
    switch (strtolower(substr($v, -1))) {
        case 'g': $n *= 1024;
        case 'm': $n *= 1024;
        case 'k': $n *= 1024;
    }
    return (int)$n;
}

// ---------------------------------------------------------------- Server web
// Le protezioni di cartelle e file sono in .htaccess (Apache, LiteSpeed), in web.config
// (IIS) oppure vanno aggiunte alla configurazione del server (nginx).
$software = isset($_SERVER['SERVER_SOFTWARE']) ? (string)$_SERVER['SERVER_SOFTWARE'] : '';
$swl = strtolower($software);
if (strpos($swl, 'nginx') !== false || strpos($swl, 'openresty') !== false) {
    $server = 'nginx';
} elseif (strpos($swl, 'microsoft-iis') !== false) {
    $server = 'iis';
} elseif (strpos($swl, 'apache') !== false || strpos($swl, 'litespeed') !== false) {
    $server = 'apache';
} elseif (PHP_SAPI === 'cli-server') {
    $server = 'php';
} else {
    $server = 'sconosciuto';
}
$g = 'Server web';
$descrServer = array(
    'apache'      => array('ok', 'Le protezioni sono nei file .htaccess inclusi nel pacchetto.'),
    'iis'         => array('ok', 'Le protezioni sono nei file web.config inclusi nel pacchetto.'),
    'nginx'       => array('avviso', 'nginx ignora .htaccess e web.config: le regole di nginx-effedocument.conf vanno aggiunte alla configurazione del sito (o chieste all\'hosting).'),
    'php'         => array('avviso', 'Server integrato di PHP: va bene solo per prove locali, non applica alcuna protezione.'),
    'sconosciuto' => array('avviso', 'Server non riconosciuto: il risultato dei controlli "Protezioni" qui sotto dice se file e cartelle sono protetti.'),
);
esito($g, $software !== '' ? $software : 'Server non dichiarato', $descrServer[$server][0], $descrServer[$server][1]);

// ---------------------------------------------------------------- PHP
$g = 'PHP';
esito($g, 'Versione PHP ' . PHP_VERSION, version_compare(PHP_VERSION, '8.1.0', '>=') ? 'ok' : 'errore',
      version_compare(PHP_VERSION, '8.1.0', '>=') ? '' : 'Serve PHP 8.1 o superiore: sceglilo dal pannello dell\'hosting.');

$estensioni = array(
    'mysqli'    => array(true,  'accesso al database'),
    'session'   => array(true,  'login degli operatori'),
    'simplexml' => array(true,  'lettura di effeconfig.xml'),
    'dom'       => array(true,  'report PDF'),
    'mbstring'  => array(true,  'report PDF'),
    'gd'        => array(true,  'immagini nei report PDF'),
    'zlib'      => array(true,  'compressione dei PDF'),
    'ldap'      => array(false, 'solo se si usa l\'accesso LDAP'),
);
foreach ($estensioni as $est => $info) {
    if (extension_loaded($est)) esito($g, "Estensione $est", 'ok', $info[1]);
    else esito($g, "Estensione $est", $info[0] ? 'errore' : 'avviso', 'Mancante: ' . $info[1]);
}

$disabilitate = array_map('trim', explode(',', (string)ini_get('disable_functions')));
if (!function_exists('mail') || in_array('mail', $disabilitate, true)) {
    esito($g, 'Invio email (mail)', 'avviso', 'Disabilitato dall\'hosting: le risposte via email ai cittadini non partiranno. Il resto funziona.');
} else {
    esito($g, 'Invio email (mail)', 'ok', 'Funzione disponibile (la consegna effettiva dipende dall\'hosting).');
}

$charsetOk = ini_set('default_charset', 'ISO-8859-1') !== false && ini_get('default_charset') === 'ISO-8859-1';
ini_set('default_charset', 'UTF-8');
esito($g, 'Charset ISO-8859-1 impostabile', $charsetOk ? 'ok' : 'errore',
      $charsetOk ? 'Le lettere accentate saranno mostrate correttamente.' : 'L\'hosting impedisce di cambiare default_charset.');

session_start();
$_SESSION['verifica'] = 1;
esito($g, 'Sessioni', session_status() === PHP_SESSION_ACTIVE ? 'ok' : 'errore',
      session_status() === PHP_SESSION_ACTIVE ? '' : 'Le sessioni non partono: il login non funzionerà.');

// ---------------------------------------------------------------- Upload
$g = 'Caricamento allegati';
if (!ini_get('file_uploads')) {
    esito($g, 'Upload abilitato', 'errore', 'file_uploads è disattivato sul server.');
} else {
    $max = min(inByte(ini_get('upload_max_filesize')), inByte(ini_get('post_max_size')) ?: PHP_INT_MAX);
    esito($g, 'Dimensione massima upload: ' . round($max / 1048576, 1) . ' MB', $max >= 3000000 ? 'ok' : 'avviso',
          $max >= 3000000 ? '' : 'L\'applicazione accetta fino a 3 MB: i file più grandi saranno rifiutati dal server.');
}
foreach (array('log' => $root . '/log/', 'documenti_allegati' => $allegati) as $nome => $dir) {
    if (!is_dir($dir)) {
        esito($g, "Cartella $nome", 'errore', 'Non esiste: creala dal File Manager.');
    } elseif (!is_writable($dir)) {
        esito($g, "Cartella $nome scrivibile", 'errore', 'Dai i permessi di scrittura (755 o 775) dal File Manager.');
    } else {
        esito($g, "Cartella $nome scrivibile", 'ok');
    }
}
if (ini_get('open_basedir')) {
    esito($g, 'Restrizione open_basedir attiva', 'avviso', 'Usa il test qui sotto per verificare che il caricamento funzioni davvero.');
}

$testUpload = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['prova'])) {
    $f = $_FILES['prova'];
    if ($f['error'] !== UPLOAD_ERR_OK) {
        $testUpload = array('errore', 'Upload fallito (codice errore PHP ' . (int)$f['error'] . ').');
    } else {
        $dest = $allegati . '_verifica_upload.txt';
        if (@move_uploaded_file($f['tmp_name'], $dest) && is_file($dest)) {
            $testUpload = array('ok', 'File ricevuto e salvato in documenti_allegati (' . filesize($dest) . ' byte), poi cancellato.');
            @unlink($dest);
        } else {
            $testUpload = array('errore', 'Il server ha ricevuto il file ma non è riuscito a salvarlo in documenti_allegati (permessi o open_basedir).');
        }
    }
}

// ---------------------------------------------------------------- Database
$g = 'Database';
$cfgFile = $root . '/common/config/effeconfig.xml';
$cfg = is_readable($cfgFile) ? @simplexml_load_file($cfgFile) : false;
if (!$cfg) {
    esito($g, 'File di configurazione', 'errore', 'common/config/effeconfig.xml mancante o non valido.');
} else {
    esito($g, 'File di configurazione', 'ok');
    $db = $cfg->database[0];
    $valori = (string)$db->host . (string)$db->user . (string)$db->dbname;
    if ((string)$db->user === 'root' || stripos($valori, 'INSERISCI') !== false) {
        esito($g, 'Credenziali del database', 'errore', 'In effeconfig.xml ci sono ancora i valori di esempio: inserisci quelli del pannello dell\'hosting.');
    }
    mysqli_report(MYSQLI_REPORT_OFF);
    // "host", "host:porta" oppure "host:/percorso/socket", come accetta l'applicazione
    $host = (string)$db->host; $porta = 3306; $socket = null;
    if (strpos($host, ':') !== false) {
        list($h, $extra) = explode(':', $host, 2);
        if ($extra !== '' && $extra[0] === '/') $socket = $extra;
        elseif (ctype_digit($extra)) $porta = (int)$extra;
        $host = $h;
    }
    $link = @mysqli_connect($host, (string)$db->user, (string)$db->password, (string)$db->dbname, $porta, $socket);
    if (!$link) {
        esito($g, 'Connessione', 'errore', 'Connessione non riuscita (' . h(mysqli_connect_error()) . '). Controlla host, utente, password e nome del database.');
    } else {
        esito($g, 'Connessione', 'ok', 'Server ' . h(mysqli_get_server_info($link)));
        mysqli_set_charset($link, 'latin1');

        $tabelle = array('configurazioni','document','document_ass','document_risp','extra',
                         'operatori','servizi','servizi_operatori','uffici','utenti');
        $presenti = array();
        $r = mysqli_query($link, 'SHOW TABLES');
        while ($r && ($row = mysqli_fetch_row($r))) $presenti[] = $row[0];
        $mancanti = array_diff($tabelle, $presenti);
        if ($mancanti) {
            esito($g, 'Tabelle', 'errore', 'Mancano: ' . h(implode(', ', $mancanti)) . '. Importa effedocument.sql con phpMyAdmin.');
        } else {
            esito($g, 'Tabelle', 'ok', count($tabelle) . ' tabelle presenti');

            $r = mysqli_query($link, "SELECT CHARACTER_MAXIMUM_LENGTH FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='operatori' AND COLUMN_NAME='password'");
            $len = ($r && ($row = mysqli_fetch_row($r))) ? (int)$row[0] : 0;
            esito($g, 'Colonna password (' . $len . ' caratteri)', $len >= 255 ? 'ok' : 'avviso',
                  $len >= 255 ? 'Le password saranno salvate cifrate.' : 'Esegui aggiornamento_password.sql in phpMyAdmin.');

            // Operatori che hanno ancora password uguale alla login (credenziali di esempio)
            $deboli = array();
            $r = mysqli_query($link, 'SELECT login, password FROM operatori WHERE abilitato=1');
            while ($r && ($row = mysqli_fetch_assoc($r))) {
                $info = password_get_info($row['password']);
                $hash = $info['algo'] !== null && $info['algo'] !== 0;
                if (($hash && password_verify($row['login'], $row['password'])) || (!$hash && $row['password'] === $row['login'])) {
                    $deboli[] = $row['login'];
                }
            }
            if ($deboli) {
                esito($g, 'Password di esempio', 'errore', 'Questi operatori hanno ancora password uguale alla login: ' . h(implode(', ', $deboli)) . '. Entra con ciascuno e cambiala (menu "Modifica Password"), oppure disabilitali.');
            } else {
                esito($g, 'Password di esempio', 'ok', 'Nessun operatore attivo con password uguale alla login.');
            }
        }
        mysqli_close($link);
    }
}

// Sonda per il test (lato browser) dell'esecuzione di script negli allegati
$sondaCreata = is_dir($allegati) && is_writable($allegati) && @file_put_contents($sondaExec, "<?php echo 'SCRIPT-ESEGUITO';") !== false;
$sondaAllCreata = is_dir($allegati) && is_writable($allegati) && @file_put_contents($sondaAll, 'ALLEGATO-OK') !== false;
$sondaLogCreata = is_dir($root . '/log') && is_writable($root . '/log') && @file_put_contents($sondaLog, 'LOG-LEGGIBILE') !== false;

// ---------------------------------------------------------------- Pagina
$conteggio = array('ok' => 0, 'avviso' => 0, 'errore' => 0);
foreach ($risultati as $voci) foreach ($voci as $v) $conteggio[$v[1]]++;
?><!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>eFFe Document – verifica installazione</title>
<style>
:root { --bg:#f6f7f9; --card:#fff; --text:#1d2433; --muted:#5b6475; --line:#e3e6ec;
        --ok:#1e7d4f; --ok-bg:#e6f4ec; --warn:#8a5a00; --warn-bg:#fdf2dc; --err:#b42318; --err-bg:#fdeceb; }
@media (prefers-color-scheme: dark) {
  :root { --bg:#14171c; --card:#1d2128; --text:#e7eaf0; --muted:#9aa3b2; --line:#2c323c;
          --ok:#5fd39a; --ok-bg:#16301f; --warn:#f2c46b; --warn-bg:#33290f; --err:#ff8a80; --err-bg:#3a1a18; }
}
* { box-sizing:border-box; }
body { margin:0; font:15px/1.5 system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; background:var(--bg); color:var(--text); }
main { max-width:760px; margin:0 auto; padding:24px 16px 48px; }
h1 { font-size:1.4rem; margin:0 0 4px; }
.sub { color:var(--muted); margin:0 0 20px; }
.riepilogo { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px; }
.pill { padding:6px 12px; border-radius:999px; font-weight:600; font-size:.9rem; }
.p-ok { background:var(--ok-bg); color:var(--ok); } .p-avviso { background:var(--warn-bg); color:var(--warn); } .p-errore { background:var(--err-bg); color:var(--err); }
section { background:var(--card); border:1px solid var(--line); border-radius:12px; margin-bottom:16px; overflow:hidden; }
section h2 { font-size:1rem; margin:0; padding:12px 16px; border-bottom:1px solid var(--line); }
.riga { display:flex; gap:12px; padding:10px 16px; border-bottom:1px solid var(--line); }
.riga:last-child { border-bottom:0; }
.icona { flex:0 0 22px; height:22px; border-radius:50%; display:grid; place-items:center; font-weight:700; font-size:13px; }
.i-ok { background:var(--ok-bg); color:var(--ok); } .i-avviso { background:var(--warn-bg); color:var(--warn); } .i-errore { background:var(--err-bg); color:var(--err); }
.voce { font-weight:600; } .nota { color:var(--muted); font-size:.92rem; }
form { padding:12px 16px; display:flex; gap:8px; flex-wrap:wrap; align-items:center; }
button { font:inherit; padding:8px 14px; border-radius:8px; border:1px solid var(--line); background:var(--text); color:var(--card); cursor:pointer; }
.finale { background:var(--err-bg); color:var(--err); border-radius:12px; padding:14px 16px; font-weight:600; }
</style>
</head>
<body>
<main>
<h1>eFFe Document – verifica installazione</h1>
<p class="sub">Controlli eseguiti sul server il <?php echo date('d/m/Y \a\l\l\e H:i'); ?>.</p>

<div class="riepilogo">
  <span class="pill p-ok"><?php echo $conteggio['ok']; ?> ok</span>
  <span class="pill p-avviso" id="n-avvisi"><?php echo $conteggio['avviso']; ?> avvisi</span>
  <span class="pill p-errore" id="n-errori"><?php echo $conteggio['errore']; ?> errori</span>
</div>

<?php foreach ($risultati as $gruppo => $voci): ?>
<section>
  <h2><?php echo h($gruppo); ?></h2>
  <?php foreach ($voci as $v): ?>
  <div class="riga">
    <span class="icona i-<?php echo $v[1]; ?>"><?php echo $v[1] === 'ok' ? '✓' : ($v[1] === 'avviso' ? '!' : '✕'); ?></span>
    <div><div class="voce"><?php echo h($v[0]); ?></div><?php if ($v[2] !== ''): ?><div class="nota"><?php echo $v[2]; ?></div><?php endif; ?></div>
  </div>
  <?php endforeach; ?>
  <?php if ($gruppo === 'Caricamento allegati'): ?>
    <?php if ($testUpload): ?>
    <div class="riga"><span class="icona i-<?php echo $testUpload[0]; ?>"><?php echo $testUpload[0] === 'ok' ? '✓' : '✕'; ?></span>
      <div><div class="voce">Test di caricamento</div><div class="nota"><?php echo h($testUpload[1]); ?></div></div></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <input type="file" name="prova" required>
      <button type="submit">Prova un caricamento</button>
    </form>
  <?php endif; ?>
</section>
<?php endforeach; ?>

<section>
  <h2>Protezioni (verificate dal browser)</h2>
  <div class="riga" id="t-config"><span class="icona">…</span><div><div class="voce">File di configurazione non scaricabile</div><div class="nota">In verifica…</div></div></div>
  <div class="riga" id="t-log"><span class="icona">…</span><div><div class="voce">Cartella dei log non accessibile</div><div class="nota">In verifica…</div></div></div>
  <div class="riga" id="t-scarica"><span class="icona">…</span><div><div class="voce">Allegati scaricabili</div><div class="nota">In verifica…</div></div></div>
  <div class="riga" id="t-exec"><span class="icona">…</span><div><div class="voce">Script non eseguibili negli allegati</div><div class="nota">In verifica…</div></div></div>
</section>

<p class="finale">A installazione completata, cancella questo file (verifica_installazione.php) dal File Manager.</p>
</main>

<script>
(function () {
  var avvisi = <?php echo (int)$conteggio['avviso']; ?>, errori = <?php echo (int)$conteggio['errore']; ?>;
  var server = <?php echo json_encode($server); ?>;
  function rimedio(cartella) {
    if (server === 'nginx') return 'Aggiungi le regole di nginx-effedocument.conf alla configurazione di nginx.';
    if (server === 'iis') return 'Controlla che il file web.config' + (cartella ? ' nella cartella ' + cartella : ' nella cartella principale') + ' sia stato caricato.';
    return 'Controlla che il file .htaccess' + (cartella ? ' nella cartella ' + cartella : ' nella cartella principale') + ' sia stato caricato.';
  }
  function esito(id, stato, nota) {
    var riga = document.getElementById(id), ic = riga.querySelector('.icona');
    ic.className = 'icona i-' + stato;
    ic.textContent = stato === 'ok' ? '✓' : (stato === 'avviso' ? '!' : '✕');
    riga.querySelector('.nota').textContent = nota;
    if (stato === 'avviso') avvisi++;
    if (stato === 'errore') errori++;
    document.getElementById('n-avvisi').textContent = avvisi + ' avvisi';
    document.getElementById('n-errori').textContent = errori + ' errori';
  }
  function prova(url) {
    return fetch(url, { cache: 'no-store', credentials: 'omit' })
      .then(function (r) { return r.text().then(function (t) { return { status: r.status, text: t }; }); })
      .catch(function () { return { status: 0, text: '' }; });
  }
  prova('common/config/effeconfig.xml').then(function (r) {
    if (r.status === 200 && r.text.indexOf('<effeconfig') !== -1)
      esito('t-config', 'errore', 'Il file con le credenziali del database è scaricabile da chiunque. ' + rimedio(''));
    else esito('t-config', 'ok', 'Accesso bloccato (risposta ' + r.status + ').');
  });
  <?php if ($sondaLogCreata): ?>
  prova('log/_verifica_sonda.txt').then(function (r) {
    if (r.text.indexOf('LOG-LEGGIBILE') !== -1) esito('t-log', 'errore', 'I file di log si possono leggere dal web. ' + rimedio('log'));
    else esito('t-log', 'ok', 'Accesso bloccato (risposta ' + r.status + ').');
  });
  <?php else: ?>
  esito('t-log', 'avviso', 'Test non eseguibile: la cartella log non è scrivibile.');
  <?php endif; ?>
  <?php if ($sondaAllCreata): ?>
  prova('documenti_allegati/_verifica_allegato.txt').then(function (r) {
    if (r.text.indexOf('ALLEGATO-OK') !== -1) esito('t-scarica', 'ok', 'Un file di prova nella cartella allegati si scarica correttamente.');
    else if (r.status >= 500) esito('t-scarica', 'errore', 'La cartella degli allegati risponde con un errore del server (' + r.status + '). Di solito è una direttiva del file .htaccess di documenti_allegati che l\'hosting non permette, come "Options": usa la versione del pacchetto, che non la contiene.');
    else esito('t-scarica', 'errore', 'Gli allegati non si possono scaricare (risposta ' + r.status + '). Controlla il file di protezione della cartella documenti_allegati.');
  });
  <?php else: ?>
  esito('t-scarica', 'avviso', 'Test non eseguibile: la cartella documenti_allegati non è scrivibile.');
  <?php endif; ?>
  <?php if ($sondaCreata): ?>
  prova('documenti_allegati/_verifica_exec.php').then(function (r) {
    if (r.text.indexOf('SCRIPT-ESEGUITO') !== -1 && r.text.indexOf('<' + '?php') === -1)
      esito('t-exec', 'errore', 'Un file PHP negli allegati viene eseguito. ' + rimedio('documenti_allegati'));
    else esito('t-exec', 'ok', 'Gli script nella cartella allegati non vengono eseguiti (risposta ' + r.status + ').');
  });
  <?php else: ?>
  esito('t-exec', 'avviso', 'Test non eseguibile: la cartella documenti_allegati non è scrivibile.');
  <?php endif; ?>
  // rimuove i file sonda dopo che i test hanno avuto il tempo di leggerli
  setTimeout(function () { fetch('verifica_installazione.php?pulisci=1', { cache: 'no-store' }); }, 3000);
})();
</script>
</body>
</html>
