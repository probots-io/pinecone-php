<?php

it('can configure a pod index', function () {

    $client = getClient(true);
    $index = getIndexName('-pod');

    $response = $client->control()->index($index)->configure(
        pod_type: 'p1.x1',
        replicas: 1
    );

    expect($response->status())->toBe(200);

});