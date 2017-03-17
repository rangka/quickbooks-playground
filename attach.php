<?php

include('include.php');

try {
    $id     = get('id', null, 'POST');
    $entity = get('entity', null, 'POST');
    $email  = get('email', null, 'POST');
    $files  = [];


    foreach ($_FILES['file']['name'] as $key=>$null) {
        $files[] = [
            'name' => $_FILES['file']['name'][$key],
            'path' => $_FILES['file']['tmp_name'][$key],
        ];
    }

    $class    = '\Rangka\Quickbooks\Services\\' . ucfirst($entity);
    $service  = new $class;
    $response = $service->attach($id, $files, true);

    echo json_encode($response);
}
catch (\GuzzleHttp\Exception\ClientException $e) {
    echo (string) $e->getResponse()->getBody();
}
catch (\GuzzleHttp\Exception\ServerException $e) {
    echo (string) $e->getResponse()->getBody();
}
catch (\Exception $e) {
    echo $e->getMessage();
}