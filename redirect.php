<?php

include('include.php');

// CONNECT_URL is page in Step 3. This is the landing page 
// user will be redirected to after authorizing.
try {
    $connector = new \Rangka\Quickbooks\Connect([
        'callback_url' => CONNECT_URL
    ]);

    // This will return a `url` for redirecting and `oauth_token_secret`.
    $result = $connector->requestAccess();

    // Save `oauth_token_secret` somewhere. We will use it later on. 
    // Make sure this value is used in Configuration above.
    $_SESSION['oauth_token_secret'] = $result['oauth_token_secret'];

    header("Location:" . $result['url']);
}
catch (\GuzzleHttp\Exception\ClientException $e) {
    dump((string) $e->getResponse()->getBody());
}