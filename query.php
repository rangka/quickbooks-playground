<?php

include('include.php');

try {
    $max_results = get('max_results', null, 'POST', 1000);
    $entity      = get('entity', null, 'POST');

    $class = '\Rangka\Quickbooks\Services\\' . ucfirst($entity);

    $service = new $class;
    $response = $service
                ->query()
                ->paginate(1, $max_results)
                ->get();

    echo json_encode($response);
}
catch (\GuzzleHttp\Exception\ClientException $e) {
    echo (string) $e->getResponse()->getBody();
}
catch (\GuzzleHttp\Exception\ServerException $e) {
    echo (string) $e->getResponse()->getBody();
}
catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}