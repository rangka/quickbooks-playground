<?php

include('include.php');

// CONNECT_URL is page in Step 3. This is the landing page 
// user will be redirected to after authorizing.
try {
    $connector = new \Rangka\Quickbooks\Connect();
    $result = $connector->connect($_GET);

    // Save `oauth_token_secret` somewhere. We will use it later on. 
    // Make sure this value is used in Configuration above.
    $_SESSION['oauth_token']        = $result['oauth_token'];
    $_SESSION['oauth_token_secret'] = $result['oauth_token_secret'];
    $_SESSION['oauth_expiry']       = $result['oauth_expiry'];
    $_SESSION['company_id']         = $result['company_id'];
}
catch (\GuzzleHttp\Exception\ClientException $e) {
    dump((string) $e->getResponse()->getBody());
}