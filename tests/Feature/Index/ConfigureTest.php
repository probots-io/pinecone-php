<?php

it('can do anything', function () {

    $client = getClient(true);

    $response = $client->index(getIndexName())->configure(
        pod_type: 'p1.x1',
        replicas: 1
    );

    expect($response->status())->toBe(202);

});