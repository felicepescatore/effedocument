# eFFe Document 1.5.0 – aggiornamento a PHP 8.5 e nuova interfaccia

La versione 1.5.0 (novembre 2026) porta eFFe Document 1.0 (2010) a funzionare su PHP 8.5, corregge i principali problemi di sicurezza e introduce un'interfaccia moderna e responsive. Database e flussi di lavoro restano invariati.

## Requisiti

- PHP 8.1 o superiore (testato su PHP 8.5) con le estensioni `mysqli`, `simplexml`, `session`, `mbstring`, `gd`, `zlib` e `dom`; `ldap` solo se si usa l'autenticazione LDAP.
- MySQL 5.7/8.x o MariaDB 10.x.
- `output_buffering` attivo e `default_charset = ISO-8859-1`. I file `.user.ini` (PHP-FPM/CGI) e `.htaccess` (Apache con mod_php) inclusi li impostano già.

## Server web supportati

L'applicazione funziona con qualsiasi server web che esegua PHP. Cambia solo il modo in cui sono protetti tre punti: il file con le credenziali del database, la cartella dei log e la cartella degli allegati, dove nessuno script deve poter essere eseguito.

| Server | Protezioni | Cosa fare |
|---|---|---|
| Apache, LiteSpeed (la maggior parte degli hosting condivisi) | file `.htaccess` inclusi | nulla, basta caricarli |
| IIS (hosting Windows) | file `web.config` inclusi | nulla, basta caricarli |
| nginx | regole in `nginx-effedocument.conf` | aggiungerle alla configurazione del sito o chiederlo all'hosting |

I file `.htaccess` e `web.config` convivono senza problemi: ogni server legge i propri e ignora gli altri.

## Verifica dell'installazione

Dopo aver caricato i file, apri nel browser `verifica_installazione.php`. La pagina controlla:
- tipo di server web;
- versione di PHP ed estensioni;
- connessione al database, anche con host nel formato `server:porta`;
- tabelle e cartelle scrivibili;
- caricamento di un file di prova;
- password di esempio ancora attive;
- protezioni reali di credenziali, log e allegati. Queste le verifica il browser, provando a leggere i file come farebbe un visitatore qualunque.

Non mostra password né altri dati riservati, ma **va cancellata a installazione completata**.

Per InfinityFree c'è una guida passo passo in `GUIDA-INFINITYFREE.md`.

## Installazione

1. Importare `effedocument.sql` nel database (es. `mysql effedocument < effedocument.sql`).
2. Inserire le credenziali in `effedocument/common/config/effeconfig.xml`.
3. Rendere scrivibili dal web server le cartelle `effedocument/log` e `effedocument/documenti_allegati`.

## Nuova interfaccia

Il template grafico del 2010, a larghezza fissa e pensato per schermi desktop, è stato sostituito da uno moderno e responsive.

- **Identità visiva:** nero `#202020` e ocra `#C9A22A` del marchio FP. Il taglio obliquo del logo è l'unico elemento decorativo e compare nel marchio, nella voce di menu attiva e nella pagina iniziale.
- **Carattere:** Atkinson Hyperlegible, progettato per la leggibilità, incluso nel pacchetto (`common/fonts`, licenza SIL OFL). Non viene caricato da servizi esterni.
- **Backoffice:** un'unica intestazione (`backoffice/_include/bonav.php`) con operatore collegato e menu a schede, al posto di quella copiata in ogni pagina. Nel pannello le priorità sono indicate da una striscia laterale e da un'etichetta, con una legenda; i documenti chiusi sono in grigio.
- **Pagine nuove:** pagina iniziale, accesso operatori, home dell'amministrazione e home del front office.
- **Smartphone:** menu a scomparsa, form su una colonna, tabelle di dati che scorrono in orizzontale (`common/script/effe-ui.js`).
- **Contrasto e tastiera:** contrasti adeguati, focus visibile da tastiera, stampa senza menu.

Il vecchio foglio di stile resta consultabile nella storia del repository.

## Modifiche principali

**Database.** L'estensione `mysql` non esiste più da PHP 7. Il nuovo file `common/core/mysql_compat.php` ridefinisce le funzioni `mysql_*` su mysqli, quindi le query esistenti funzionano senza modifiche. Il file imposta inoltre la connessione in latin1, come le tabelle, e disattiva per la sessione lo strict mode di MySQL 8, che rifiuterebbe le date `0000-00-00` e altri valori usati dall'applicazione.

**Report PDF.** dompdf 0.5 (2006) è stato rimosso e sostituito da dompdf 3.1.4 in `backoffice/_lib/dompdf`. Il logo nei report puntava a un'immagine inesistente e ora usa quello di eFFe Document.

**Barcode del protocollo.** La libreria ezpdf è stata adeguata a PHP 8: costruttori, `magic_quotes`, `each()` e sintassi `{}` sugli array.

**Errori bloccanti corretti:**
- tre errori di sintassi;
- 18 chiavi di array senza apici, come `$array[email]`;
- il costruttore in stile PHP 4 della classe di log;
- `implode` con gli argomenti invertiti;
- `count()` su valori nulli;
- accesso a indice su stringa in `getDocumentWorkflow`;
- il metodo inesistente `getServiziAttiveTutte` nei report.

**Compatibilità Linux.** Il percorso del file di configurazione e quelli degli allegati usavano `\` e funzionavano solo su Windows.

**Allegati.** Il frontoffice e la protocollazione salvavano i file in cartelle diverse da quella usata dal backoffice per i link, quindi gli allegati risultavano irraggiungibili. Ora tutti usano `effedocument/documenti_allegati`.

**LDAP.** `ldap_set_option` usava una variabile mai definita.

## Verifiche effettuate

Su PHP 8.5 con MariaDB in strict mode sono stati verificati:
- login di tutti i ruoli;
- apertura di tutte le pagine;
- inserimento di una richiesta dal frontoffice, con allegato e lettere accentate;
- protocollazione in ingresso;
- avanzamento del workflow fino allo stato "evaso";
- generazione di tutti i report;
- esportazione PDF;
- barcode del protocollo.

## Da sapere

Restano avvisi (warning) per variabili o indici non definiti. Sono innocui, ma in produzione è bene tenere `display_errors = Off`.

## Sicurezza: SQL injection

Tutte le query dell'applicazione sono costruite in `common/core/core.php`. Ogni valore inserito in una query ora passa da un controllo:

- I valori tra apici passano da `sqlEsc()`, che usa `mysqli_real_escape_string` sulla connessione latin1 (169 punti).
- Nelle ricerche con `LIKE` si usa `sqlLike()`, che neutralizza anche i caratteri jolly `%` e `_`.
- I valori numerici senza apici sono convertiti in intero con `(int)`.
- I nomi di tabella e colonna non si possono escapare, quindi sono ammessi solo da un elenco di valori consentiti (`abilitaDisabilita`, `updateSet`).
- Lo username usato nel DN LDAP passa da `ldap_escape()`.

`checkText()` raddoppiava gli apici e `valida.php` faceva un escape proprio. Con l'escape centralizzato questi passaggi avrebbero salvato gli apici due volte, quindi `checkText()` ora restituisce il testo invariato e `valida.php` passa i valori così come arrivano.

Verifiche eseguite, con il confronto tra prima e dopo:

| Attacco | Prima | Dopo |
|---|---|---|
| `UNION SELECT` con `sleep()` su `extra_leggi.php?id=` (accessibile senza login) | eseguito | bloccato |
| `UNION SELECT` nella ricerca FAQ del frontoffice | login e password degli operatori visibili | bloccato |
| id malevolo (`1 or 1=1`) su abilita/disabilita | — | modifica una sola riga |
| nomi, email e oggetti con apostrofi (`D'Angelo`, `o'neil@…`) | la query si rompeva | salvati correttamente |

## Sicurezza: password

Le password degli operatori ora sono salvate come hash con `password_hash()` (bcrypt) e verificate con `password_verify()`.

**Conversione automatica.** Le password esistenti restano valide. Al primo accesso di ogni operatore la password in chiaro viene confrontata a tempo costante e subito sostituita dal suo hash, quindi nessuno deve reimpostarla. Con `password_needs_rehash()` gli hash vengono aggiornati anche se in futuro PHP cambierà algoritmo.

**Colonna `operatori.password`.** Era `varchar(20)`, mentre un hash richiede fino a 255 caratteri.
- Al primo accesso l'applicazione prova ad allargarla da sola.
- Se l'utente del database non ha il permesso `ALTER`, le password continuano a essere salvate in chiaro, perché un hash troncato bloccherebbe l'accesso. Nel log compare un avviso: in quel caso eseguire una volta `aggiornamento_password.sql`.
- Il dump `effedocument.sql` crea già la colonna della lunghezza giusta.

**Altre modifiche:**
- La pagina "Modifica password" verifica la password attuale con l'hash, senza più leggere la password dal database, e il campo non la mostra più in chiaro mentre si digita.
- Dopo l'accesso viene generato un nuovo id di sessione, come protezione dalla session fixation.

**Verifiche eseguite:**
- conversione al primo accesso, con la colonna allargata automaticamente;
- accessi successivi con l'hash;
- password errata rifiutata;
- l'hash stesso usato come password è rifiutato;
- cambio password, sia con password attuale errata sia corretta;
- creazione di un nuovo operatore;
- funzionamento senza permesso `ALTER`.

**Importante.** Il dump contiene gli operatori di esempio con password uguale alla login (`admin`/`admin`, ecc.). In produzione vanno cambiate subito.
