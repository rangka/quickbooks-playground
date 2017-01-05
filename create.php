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
        $method = 'set'.$field;
        $exploded = explode('.', $field);

        if (count($exploded) > 1) {
            $method   = 'set'.$exploded[0];
            
            unset($exploded[0]);

            $reversed = array_reverse($exploded);
            foreach ($reversed as $now) {
                $value = [$now => $value];
            }
        }

        if ($value === 'true') {
            $builder->{$method}(true);
        }
        else if ($value === 'false') {
            $builder->{$method}(false);
        }
        else {
            $builder->{$method}($value);
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