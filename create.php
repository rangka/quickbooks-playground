<?php

include('include.php');

try {
    $id   = get('id', null, 'POST');
    $entity = get('entity', null, 'POST');
    $fields = get('fields', null, 'POST');

    $class = '\Rangka\Quickbooks\Services\\' . ucfirst($entity);

    $service = new $class;
    $builder = $service->getBuilder();

    foreach ($fields as $field=>$value) {
        if ($value === 'true') {
            $builder->{'set'.$field}(true);
        }
        else if ($value === 'false') {
            $builder->{'set'.$field}(false);
        }
        else {
            $builder->{'set'.$field}($value);
        }
    }

    $response = $builder->create();

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