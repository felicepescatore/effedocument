<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Guida - eFFe Document</title>
<link href="../../common/css/effecss.css?v=1.5.0-5759dd" rel="stylesheet">
</head>
<body class="guida">
<header class="appbar">
  <a class="home-sito" href="../../index.php" title="Home page del sito" aria-label="Home page del sito"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11 12 4l9 7"/><path d="M5 10v10h5v-6h4v6h5V10"/></svg></a>
  <span class="brand"><span class="brand-mark" aria-hidden="true"></span>eFFe Document</span>
  <span class="guida-titolo">Guida, versione 1.5.0</span>
</header>
<div class="guida-corpo">
  <nav class="guida-indice" aria-label="Indice della guida">
    <p class="guida-indice-titolo">Indice</p>
    <ol><li><a href="#introduzione">Introduzione</a></li><li><a href="#installazione">Installazione</a><ol><li><a href="#requisiti">Requisiti</a></li><li><a href="#procedura">Procedura</a></li><li><a href="#configurazione">Configurazione</a></li></ol></li><li><a href="#workflow">I workflow</a><ol><li><a href="#wf-semplice">Workflow semplice</a></li><li><a href="#wf-avanzato">Workflow avanzato</a></li></ol></li><li><a href="#protocollo">Il numero di protocollo</a></li><li><a href="#backoffice">Back office</a><ol><li><a href="#amministratore">Amministratore</a></li><li><a href="#responsabile">Responsabile del servizio</a></li><li><a href="#protocollatore">Protocollatore</a></li><li><a href="#collaboratore">Collaboratore</a></li><li><a href="#supervisore">Supervisore</a></li><li><a href="#report">Visualizzatore report</a></li></ol></li><li><a href="#frontoffice">Front office</a><ol><li><a href="#nuovo-documento">Inviare un documento</a></li></ol></li></ol>
  </nav>
  <main class="guida-testo">
    <h1>Guida di eFFe Document</h1>
    <p class="guida-sommario">Installazione, configurazione e uso del sistema: workflow, numero di protocollo, ruoli del back office e invio dei documenti dal front office.</p>

<section id="introduzione">
<h2>Introduzione</h2>
<p>eFFe Document &egrave; un'applicazione web open source per la gestione documentale: registra i documenti in ingresso e in uscita, assegna a ciascuno un numero di protocollo con codice a barre e ne segue la lavorazione attraverso un workflow, dall'arrivo fino alla risposta.</p>
<figure class="figura">
  <a href="effedoc_file/guida-01-pagina-iniziale.png?v=1.5.0-5759dd" target="_blank" rel="noopener"><img src="effedoc_file/guida-01-pagina-iniziale.png?v=1.5.0-5759dd" alt="Pagina iniziale di eFFe Document con gli accessi a Front Office, Back Office e Guida" loading="lazy"></a>
  <figcaption>Figura 1. La pagina iniziale.</figcaption>
</figure>
<p>L'applicazione &egrave; composta da due parti:</p>
<ul>
<li><strong>Front office</strong>: lo sportello pubblico. Chi &egrave; esterno all'organizzazione invia una richiesta o un documento e riceve subito il numero di protocollo. Consulta anche avvisi e domande frequenti.</li>
<li><strong>Back office</strong>: l'area riservata agli operatori, con tutti gli strumenti per gestire i documenti e per amministrare il sistema.</li>
</ul>
<p>Entrambe si raggiungono dalla pagina iniziale, ad esempio <code>https://www.miosito.it/</code>. Il back office &egrave; anche all'indirizzo <code>https://www.miosito.it/backoffice/</code>.</p>
</section>

<section id="installazione">
<h2>Installazione</h2>
<h3 id="requisiti">Requisiti</h3>
<ul>
<li><strong>PHP 8.1 o superiore</strong> (provato fino a PHP 8.5) con le estensioni <code>mysqli</code>, <code>session</code>, <code>simplexml</code>, <code>dom</code>, <code>mbstring</code>, <code>gd</code> e <code>zlib</code>; <code>ldap</code> solo se si usa l'accesso tramite LDAP.</li>
<li><strong>Database</strong> MySQL 5.7 o successivo, oppure MariaDB 10 o successivo.</li>
<li><strong>Server web</strong> Apache o LiteSpeed (la maggior parte degli hosting condivisi), IIS oppure nginx.</li>
</ul>
<h3 id="procedura">Procedura</h3>
<ol class="passi">
<li>Crea un database vuoto e importa il file <code>effedocument.sql</code>, ad esempio con phpMyAdmin.</li>
<li>Inserisci i dati di accesso al database nel file <code>common/config/effeconfig.xml</code> (vedi <a href="#configurazione">Configurazione</a>).</li>
<li>Carica i file dell'applicazione sul server, compresi i file nascosti <code>.htaccess</code>, e rendi scrivibili le cartelle <code>log</code> e <code>documenti_allegati</code>.</li>
<li>Apri <code>verifica_installazione.php</code> nel browser: controlla PHP, database, cartelle, caricamento degli allegati e protezioni. Quando &egrave; tutto in ordine, cancella il file.</li>
<li>Entra nel back office e cambia subito le password degli operatori di esempio (<code>admin</code>, <code>proto1</code>, <code>report</code>, <code>felice</code>), che sono uguali al nome utente.</li>
</ol>
<div class="nota">Su nginx i file <code>.htaccess</code> non hanno effetto: le regole equivalenti sono in <code>nginx-effedocument.conf</code>. Sugli hosting Windows (IIS) valgono i file <code>web.config</code> inclusi.</div>
<h3 id="configurazione">Configurazione</h3>
<p>Le impostazioni sono nel file <code>common/config/effeconfig.xml</code>:</p>
<pre><code>&lt;effeconfig&gt;
  &lt;database&gt;
    &lt;user&gt;utente&lt;/user&gt;
    &lt;password&gt;password&lt;/password&gt;
    &lt;host&gt;localhost&lt;/host&gt;
    &lt;dbname&gt;effedocument&lt;/dbname&gt;
  &lt;/database&gt;
  &lt;ldap&gt;
    &lt;server&gt;ldap://127.0.0.1&lt;/server&gt;
    &lt;partialdn&gt;ou=myou,o=myo,dc=mydc,dc=it&lt;/partialdn&gt;
  &lt;/ldap&gt;
  &lt;other&gt;
    &lt;dirallegati&gt;../documenti_allegati/&lt;/dirallegati&gt;
    &lt;effelog active='true'&gt;effedoclog.txt&lt;/effelog&gt;
  &lt;/other&gt;
&lt;/effeconfig&gt;</code></pre>
<dl class="voci">
<dt><code>database</code></dt><dd>Utente, password, server e nome del database. Il server pu&ograve; includere la porta, ad esempio <code>sql.miosito.it:3307</code>.</dd>
<dt><code>ldap</code></dt><dd>Indirizzo del server LDAP e parte finale del DN di autenticazione, escluso il <code>cn</code> dell'utente. L'accesso tramite LDAP si attiva dal back office, in <strong>Configurazioni</strong>.</dd>
<dt><code>dirallegati</code></dt><dd>La cartella in cui vengono salvati gli allegati.</dd>
<dt><code>effelog</code></dt><dd>Attiva il registro delle operazioni e indica il nome del file, salvato nella cartella <code>log</code>.</dd>
</dl>
</section>

<section id="workflow">
<h2>I workflow</h2>
<p>Ogni servizio segue uno di due workflow, scelto dall'amministratore: <strong>semplice</strong> o <strong>avanzato</strong>. In ogni stato il documento &egrave; nelle mani di un operatore, indicato sotto il nome dello stato.</p>
<h3 id="wf-semplice">Workflow semplice</h3>
<ol class="wf"><li class="wf-stato wf-opz"><span class="wf-nome">assegnazione</span><span class="wf-chi">protocollatore, solo se il servizio non ha un responsabile</span></li><li class="wf-stato"><span class="wf-nome">assegnato</span><span class="wf-chi">responsabile del servizio</span></li><li class="wf-stato"><span class="wf-nome">lavorazione</span><span class="wf-chi">collaboratore</span></li><li class="wf-stato"><span class="wf-nome">predisposto</span><span class="wf-chi">responsabile del servizio</span></li><li class="wf-stato"><span class="wf-nome">validato</span><span class="wf-chi">collaboratore</span></li><li class="wf-stato wf-fine"><span class="wf-nome">evaso</span><span class="wf-chi">collaboratore</span></li></ol><ul class="wf-ritorni"><li><strong>assegnato &rarr; assegnato</strong>: il responsabile smista la richiesta a un altro servizio, se non &egrave; di sua competenza.</li><li><strong>predisposto &rarr; lavorazione</strong>: la risposta va corretta e torna al collaboratore con le note del responsabile.</li></ul>
<p>Il documento parte di norma dallo stato <strong>assegnato</strong>: arriva direttamente al responsabile del servizio. Se il servizio non ha un responsabile, parte invece da <strong>assegnazione</strong> ed &egrave; il protocollatore ad assegnarlo.</p>
<p>In <strong>lavorazione</strong> il collaboratore svolge le attivit&agrave; richieste e prepara la risposta. Passando a <strong>predisposto</strong> il documento torna al responsabile, che valuta la risposta: se va bene la porta a <strong>validato</strong> e la rimanda al collaboratore, altrimenti la riporta in lavorazione con le note sulle modifiche.</p>
<p>Nello stato validato il collaboratore invia la risposta e chiude la richiesta portandola a <strong>evaso</strong>.</p>
<h3 id="wf-avanzato">Workflow avanzato</h3>
<ol class="wf"><li class="wf-stato wf-opz"><span class="wf-nome">assegnazione</span><span class="wf-chi">protocollatore, solo se il servizio non ha un responsabile</span></li><li class="wf-stato"><span class="wf-nome">assegnato</span><span class="wf-chi">responsabile del servizio</span></li><li class="wf-stato"><span class="wf-nome">lavorazione</span><span class="wf-chi">collaboratore</span></li><li class="wf-stato"><span class="wf-nome">predisposto</span><span class="wf-chi">responsabile del servizio</span></li><li class="wf-stato"><span class="wf-nome">validato</span><span class="wf-chi">supervisore</span></li><li class="wf-stato"><span class="wf-nome">autorizzato</span><span class="wf-chi">collaboratore</span></li><li class="wf-stato wf-fine"><span class="wf-nome">evaso</span><span class="wf-chi">collaboratore</span></li></ol><ul class="wf-ritorni"><li><strong>assegnato &rarr; assegnato</strong>: il responsabile smista la richiesta a un altro servizio.</li><li><strong>predisposto &rarr; lavorazione</strong>: la risposta va corretta e torna al collaboratore.</li><li><strong>validato &rarr; predisposto</strong>: il supervisore non autorizza e rimanda il documento al responsabile del servizio.</li></ul>
<p>Fino a <strong>predisposto</strong> funziona come il workflow semplice. Quando il responsabile del servizio approva la risposta, il documento passa a <strong>validato</strong> e arriva al <strong>supervisore</strong> per la verifica finale.</p>
<p>Il supervisore pu&ograve; portarlo ad <strong>autorizzato</strong>, rimandandolo al collaboratore, oppure riportarlo a predisposto per il responsabile. Nello stato autorizzato il collaboratore invia la risposta e porta la richiesta a <strong>evaso</strong>.</p>
</section>

<section id="protocollo">
<h2>Il numero di protocollo</h2>
<p>Ogni nuovo documento riceve un numero di protocollo univoco, ad esempio <span class="protocollo">CM 35</span>, composto da due parti:</p>
<ol>
<li>la sigla dell'ente, in questo esempio <strong>CM</strong> (Comune), impostata dall'amministratore in Configurazioni;</li>
<li>un numero progressivo, in questo esempio <strong>35</strong>.</li>
</ol>
<p>La numerazione &egrave; separata per ingresso e uscita: possono esistere sia il protocollo 25 in ingresso sia il protocollo 25 in uscita. Per ogni protocollo &egrave; disponibile il codice a barre da stampare.</p>
</section>

<section id="backoffice">
<h2>Back office</h2>
<figure class="figura figura-stretta">
  <a href="effedoc_file/guida-02-accesso.png?v=1.5.0-5759dd" target="_blank" rel="noopener"><img src="effedoc_file/guida-02-accesso.png?v=1.5.0-5759dd" alt="Schermata di accesso degli operatori" loading="lazy"></a>
  <figcaption>Figura 2. Accesso degli operatori.</figcaption>
</figure>
<p>Ogni operatore entra con il proprio nome utente e la propria password. Dopo l'accesso vede solo le funzioni del suo ruolo.</p>
<div class="scroll-tabella"><table class="dati">
<tr><td>Ruolo</td><td>Cosa fa</td><td>Ambito</td></tr>
<tr><td><strong>Amministratore</strong></td><td>Configura il sistema; non accede ai documenti</td><td>Tutto il sistema</td></tr>
<tr><td><strong>Responsabile del servizio</strong></td><td>Controlla le richieste del servizio di cui &egrave; responsabile</td><td>Servizio</td></tr>
<tr><td><strong>Protocollatore</strong></td><td>Vede tutti i documenti e protocolla quelli arrivati per email, fax, posta, raccomandata o telefono</td><td>Servizio</td></tr>
<tr><td><strong>Collaboratore</strong></td><td>Lavora il documento fino alla risposta</td><td>Servizio</td></tr>
<tr><td><strong>Supervisore</strong></td><td>Autorizza la risposta nel workflow avanzato</td><td>Ente</td></tr>
<tr><td><strong>Visualizzatore report</strong></td><td>Consulta i report di attivit&agrave;</td><td>Tutto il sistema</td></tr>
</table></div>

<h3 id="amministratore">Amministratore</h3>
<ul>
<li>gestisce i servizi e le loro tipologie: aggiunta, modifica, attivazione e disattivazione, scelta del workflow;</li>
<li>gestisce gli uffici;</li>
<li>pubblica ed elimina avvisi e domande frequenti;</li>
<li>consulta gli utenti che hanno inviato almeno un documento;</li>
<li>gestisce gli operatori: aggiunta, modifica, attivazione e disattivazione, ruolo e servizi assegnati;</li>
<li>imposta i dati dell'ente e l'accesso tramite LDAP, in Configurazioni.</li>
</ul>
<figure class="figura">
  <a href="effedoc_file/guida-03-amministrazione.png?v=1.5.0-5759dd" target="_blank" rel="noopener"><img src="effedoc_file/guida-03-amministrazione.png?v=1.5.0-5759dd" alt="Home dell&rsquo;amministrazione con gli accessi a servizi, uffici, operatori, utenti e configurazioni" loading="lazy"></a>
  <figcaption>Figura 3. La home dell&rsquo;amministrazione.</figcaption>
</figure>

<h3 id="responsabile">Responsabile del servizio</h3>
<ul>
<li>vede i documenti del proprio servizio;</li>
<li>cambia il servizio di un documento finch&eacute; &egrave; nello stato assegnato, cio&egrave; prima che inizi la lavorazione;</li>
<li>cambia lo stato dei documenti e ne consulta lo storico;</li>
<li>assegna i documenti ai collaboratori;</li>
<li>consulta gli allegati e invia la risposta quando prevista;</li>
<li>filtra e cerca tra i documenti.</li>
</ul>
<figure class="figura">
  <a href="effedoc_file/guida-04-pannello-responsabile.png?v=1.5.0-5759dd" target="_blank" rel="noopener"><img src="effedoc_file/guida-04-pannello-responsabile.png?v=1.5.0-5759dd" alt="Pannello del responsabile con i documenti del servizio" loading="lazy"></a>
  <figcaption>Figura 4. Il pannello del responsabile: la striscia colorata e l&rsquo;etichetta indicano la priorit&agrave;, in grigio i documenti chiusi.</figcaption>
</figure>

<h3 id="protocollatore">Protocollatore</h3>
<ul>
<li>vede tutti i documenti e ne consulta lo storico e gli allegati;</li>
<li>protocolla le richieste arrivate al di fuori del sito, in ingresso e in uscita;</li>
<li>assegna i documenti dei servizi senza responsabile;</li>
<li>filtra e cerca tra i documenti.</li>
</ul>
<figure class="figura">
  <a href="effedoc_file/guida-05-pannello-protocollatore.png?v=1.5.0-5759dd" target="_blank" rel="noopener"><img src="effedoc_file/guida-05-pannello-protocollatore.png?v=1.5.0-5759dd" alt="Pannello del protocollatore con tutti i documenti" loading="lazy"></a>
  <figcaption>Figura 5. Il pannello del protocollatore, con i filtri per tipo, tipologia, priorit&agrave; e operatore.</figcaption>
</figure>
<figure class="figura">
  <a href="effedoc_file/guida-06-protocollazione.png?v=1.5.0-5759dd" target="_blank" rel="noopener"><img src="effedoc_file/guida-06-protocollazione.png?v=1.5.0-5759dd" alt="Modulo di protocollazione di un documento in ingresso" loading="lazy"></a>
  <figcaption>Figura 6. Protocollazione di un documento in ingresso.</figcaption>
</figure>

<h3 id="collaboratore">Collaboratore</h3>
<ul>
<li>vede i documenti assegnati a lui e ne consulta storico e allegati;</li>
<li>prepara la risposta;</li>
<li>invia la risposta quando &egrave; stata validata o, nel workflow avanzato, autorizzata;</li>
<li>filtra e cerca tra i documenti.</li>
</ul>

<h3 id="supervisore">Supervisore</h3>
<p>Interviene solo nel workflow avanzato: autorizza l'invio della risposta oppure la rimanda al responsabile del servizio.</p>

<h3 id="report">Visualizzatore report</h3>
<p>Consulta e filtra i report statistici sui documenti, per ufficio, tipologia, modalit&agrave; di ricezione e periodo, e li esporta in PDF o Excel.</p>
<figure class="figura">
  <a href="effedoc_file/guida-07-report.png?v=1.5.0-5759dd" target="_blank" rel="noopener"><img src="effedoc_file/guida-07-report.png?v=1.5.0-5759dd" alt="Esempio di report con i documenti e gli stati di lavorazione" loading="lazy"></a>
  <figcaption>Figura 7. Un report.</figcaption>
</figure>
</section>

<section id="frontoffice">
<h2>Front office</h2>
<figure class="figura">
  <a href="effedoc_file/guida-08-front-office.png?v=1.5.0-5759dd" target="_blank" rel="noopener"><img src="effedoc_file/guida-08-front-office.png?v=1.5.0-5759dd" alt="Home del front office con le azioni principali" loading="lazy"></a>
  <figcaption>Figura 8. La home del front office.</figcaption>
</figure>
<p>Dal front office chi visita il sito pu&ograve;:</p>
<ul>
<li>inviare un nuovo documento;</li>
<li>consultare le domande frequenti;</li>
<li>leggere gli avvisi;</li>
<li>cercare tra le domande frequenti.</li>
</ul>
<h3 id="nuovo-documento">Inviare un documento</h3>
<ol class="passi">
<li>Dalla home scegli <strong>Invia un documento</strong>.</li>
<li>Scegli il servizio a cui &egrave; rivolta la richiesta.
<figure class="figura">
  <a href="effedoc_file/guida-09-scelta-servizio.png?v=1.5.0-5759dd" target="_blank" rel="noopener"><img src="effedoc_file/guida-09-scelta-servizio.png?v=1.5.0-5759dd" alt="Elenco dei servizi tra cui scegliere" loading="lazy"></a>
  <figcaption>Figura 9. Scelta del servizio.</figcaption>
</figure></li>
<li>Compila il modulo con i tuoi dati e l'oggetto; se serve, allega un file (fino a 3 MB).
<figure class="figura">
  <a href="effedoc_file/guida-10-modulo.png?v=1.5.0-5759dd" target="_blank" rel="noopener"><img src="effedoc_file/guida-10-modulo.png?v=1.5.0-5759dd" alt="Modulo con i dati del richiedente" loading="lazy"></a>
  <figcaption>Figura 10. Il modulo della richiesta.</figcaption>
</figure></li>
<li>Annota il numero di protocollo assegnato o stampa il codice a barre: serve per seguire la richiesta.
<figure class="figura">
  <a href="effedoc_file/guida-11-conferma.png?v=1.5.0-5759dd" target="_blank" rel="noopener"><img src="effedoc_file/guida-11-conferma.png?v=1.5.0-5759dd" alt="Conferma con il numero di protocollo e il codice a barre" loading="lazy"></a>
  <figcaption>Figura 11. La conferma con il numero di protocollo.</figcaption>
</figure></li>
</ol>
</section>

  </main>
</div>
<footer class="piede">
  <span>eFFe Document versione 1.5.0</span>
  <a href="http://www.felicepescatore.it" target="_blank" rel="noopener" title="ing. Felice Pescatore"><img src="../../common/images/loghi/logofp.png" width="102" height="58" alt="ing. Felice Pescatore"></a>
</footer>
</body>
</html>
