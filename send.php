<?php

include('include.php');

try {
    $id     = get('id', null, 'POST');
    $entity = get('entity', null, 'POST');
    $email  = get('email', null, 'POST');

    $class = '\Rangka\Quickbooks\Services\\' . ucfirst($entity);

    $service  = new $class;
    $response = $service->send($id, $email);

    echo json_encode($response);
}
catch (\GuzzleHttp\Exception\ClientException $e) {
    echo (string) $e->getResponse()->getBody();
}
catch (\GuzzleHttp\Exception\ServerException $e) {
    echo (string) $e->getResponse()->getBody();
}
catch (\Exception $e) {
    echo (string) $e->getResponse()->getBody();
}