<?php
session_start();

include('vendor/autoload.php');

define('REDIRECT_URL', 'http://local.app/rangka/quickbooks-dev/redirect.php');
define('CONNECT_URL', 'http://local.app/rangka/quickbooks-dev/connect.php');

function get($key, $default = null, $source = 'GET') {
    global $_SESSION;

    switch ($source) {
        case 'SESSION':
            return isset($_SESSION[$key]) ? $_SESSION[$key] : null;  
            break;
        case 'GET':
            return isset($_GET[$key]) ? $_GET[$key] : null;  
            break;
        case 'POST':
            return isset($_POST[$key]) ? $_POST[$key] : null;  
            break;
    }

    return $default;
}

\Rangka\Quickbooks\Client::configure([
    'consumer_key'       => '',
    'consumer_secret'    => '',
    'sandbox'            => 'sandbox',
    'oauth_token'        => get('oauth_token', null, 'SESSION'),
    'oauth_token_secret' => get('oauth_token_secret', null, 'SESSION'),
    'company_id'         => get('company_id', null, 'SESSION'),
]);