<?php
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'compositor');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');
define('IP_ZMQ', 'tcp://127.0.0.1:5555');

$bd = New \SmartSolucoes\Core\Model();
$config = $bd->find('configuracao',1);

if ($config['environment'] == 'Desenvolvimento') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
} else {
    error_reporting(E_NOTICE);
    ini_set("display_errors", 0);
}

define('APP_TITLE', $config['app_title']);
define('URL_PROTOCOL', $config['protocol']);
define('URL_DOMAIN', @$_SERVER['HTTP_HOST']);
define('URL_PUBLIC', URL_PROTOCOL . URL_DOMAIN);
define('URL_ADMIN', URL_PROTOCOL . URL_DOMAIN . '/admin');
define('URL_PAGE', trim(URL_PUBLIC . @$_SERVER['REQUEST_URI'],'/'));

define('MAIL_HOST', $config['mail_host']);
define('MAIL_AUTH', $config['mail_auth']);
define('MAIL_USER', $config['mail_user']);
define('MAIL_PASS', $config['mail_pass']);
define('MAIL_SECURE', $config['mail_secure']);
define('MAIL_PORT', $config['mail_port']);
define('MAIL_SENDTYPE', $config['mail_sendtype']);
define('MAIL_CONTATO', $config['mail_contact']);
