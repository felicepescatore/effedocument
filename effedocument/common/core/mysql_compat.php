<?php
/**
 * eFFe Document - strato di compatibilita' mysql_* -> mysqli
 *
 * L'estensione "mysql" e' stata rimossa in PHP 7.0. Questo file ridefinisce
 * le funzioni mysql_* usate dall'applicazione appoggiandosi a mysqli, cosi'
 * il resto del codice continua a funzionare senza modifiche su PHP 8.x.
 *
 * Il comportamento replica quello storico: in caso di errore le funzioni
 * restituiscono false (niente eccezioni) e una fetch su un risultato non
 * valido restituisce false invece di generare un TypeError.
 */

if (!function_exists('mysql_connect')) {

    // PHP 8.1+ fa lanciare eccezioni a mysqli per default: il codice storico
    // si aspetta invece valori di ritorno false.
    mysqli_report(MYSQLI_REPORT_OFF);

    if (!defined('MYSQL_ASSOC')) {
        define('MYSQL_ASSOC', MYSQLI_ASSOC);
        define('MYSQL_NUM', MYSQLI_NUM);
        define('MYSQL_BOTH', MYSQLI_BOTH);
    }

    /** Connessione corrente (equivalente del "link implicito" di ext/mysql). */
    $GLOBALS['__effe_mysqli_link'] = null;

    function __effe_mysql_link($link = null)
    {
        if ($link instanceof mysqli) {
            return $link;
        }
        return $GLOBALS['__effe_mysqli_link'];
    }

    function mysql_connect($host = null, $user = null, $password = null)
    {
        $port = null;
        $socket = null;
        if ($host !== null && $host !== '') {
            // ext/mysql accettava "host:porta" e "host:/percorso/socket"
            if (strpos($host, ':') !== false) {
                list($h, $extra) = explode(':', $host, 2);
                if ($extra !== '' && $extra[0] === '/') {
                    $socket = $extra;
                } elseif (ctype_digit($extra)) {
                    $port = (int)$extra;
                }
                $host = $h;
            }
        }

        $link = @mysqli_connect($host, $user, $password, '', $port ?? 3306, $socket);
        if (!$link) {
            return false;
        }

        // Le tabelle sono latin1 e le pagine sono servite in ISO-8859-1:
        // ext/mysql usava latin1 come charset di connessione predefinito.
        mysqli_set_charset($link, 'latin1');

        // MySQL 5.7+/8.x attivano lo strict mode, che rifiuta date
        // '0000-00-00', stringhe vuote in colonne numeriche e GROUP BY non
        // aggregati usati dall'applicazione. Si ripristina il comportamento
        // di MySQL 5.1, per cui il codice e' stato scritto.
        mysqli_query($link, "SET SESSION sql_mode = ''");

        $GLOBALS['__effe_mysqli_link'] = $link;
        return $link;
    }

    function mysql_select_db($database, $link = null)
    {
        $link = __effe_mysql_link($link);
        return $link ? mysqli_select_db($link, $database) : false;
    }

    function mysql_query($query, $link = null)
    {
        $link = __effe_mysql_link($link);
        if (!$link) {
            return false;
        }
        try {
            return mysqli_query($link, $query);
        } catch (Throwable $e) {
            return false;
        }
    }

    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH)
    {
        if (!($result instanceof mysqli_result)) {
            return false;
        }
        $row = mysqli_fetch_array($result, $result_type);
        return $row === null ? false : $row;
    }

    function mysql_fetch_assoc($result)
    {
        return mysql_fetch_array($result, MYSQLI_ASSOC);
    }

    function mysql_fetch_row($result)
    {
        return mysql_fetch_array($result, MYSQLI_NUM);
    }

    function mysql_num_rows($result)
    {
        return ($result instanceof mysqli_result) ? mysqli_num_rows($result) : false;
    }

    function mysql_data_seek($result, $row_number)
    {
        if (!($result instanceof mysqli_result)) {
            return false;
        }
        $rows = mysqli_num_rows($result);
        if ($row_number < 0 || ($rows > 0 && $row_number >= $rows) || $rows === 0) {
            return false;
        }
        return mysqli_data_seek($result, $row_number);
    }

    function mysql_insert_id($link = null)
    {
        $link = __effe_mysql_link($link);
        return $link ? mysqli_insert_id($link) : false;
    }

    function mysql_affected_rows($link = null)
    {
        $link = __effe_mysql_link($link);
        return $link ? mysqli_affected_rows($link) : -1;
    }

    function mysql_error($link = null)
    {
        $link = __effe_mysql_link($link);
        return $link ? mysqli_error($link) : (string)mysqli_connect_error();
    }

    function mysql_errno($link = null)
    {
        $link = __effe_mysql_link($link);
        return $link ? mysqli_errno($link) : mysqli_connect_errno();
    }

    function mysql_real_escape_string($string, $link = null)
    {
        $link = __effe_mysql_link($link);
        $string = (string)$string;
        return $link ? mysqli_real_escape_string($link, $string) : addslashes($string);
    }

    function mysql_escape_string($string)
    {
        return mysql_real_escape_string($string);
    }

    function mysql_free_result($result)
    {
        if ($result instanceof mysqli_result) {
            mysqli_free_result($result);
            return true;
        }
        return false;
    }

    function mysql_close($link = null)
    {
        $link = __effe_mysql_link($link);
        if (!$link) {
            return false;
        }
        $ok = mysqli_close($link);
        if ($link === $GLOBALS['__effe_mysqli_link']) {
            $GLOBALS['__effe_mysqli_link'] = null;
        }
        return $ok;
    }
}
