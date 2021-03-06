<?php

include('include.php');

try {
    $id   = get('id', null, 'POST');
    $entity = get('entity', null, 'POST');

    $class = '\Rangka\Quickbooks\Services\\' . ucfirst($entity);

    $service = new $class;
    $response = $service->delete($id);

    echo json_encode($response);
}
catch (\GuzzleHttp\Exception\ClientException $e) {
    echo (string) $e->getResponse()->getBody();
}
catch (\GuzzleHttp\Exception\ServerException $e) {
    echo (string) $e->getResponse()->getBody();
}