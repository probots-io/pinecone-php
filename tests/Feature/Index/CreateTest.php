<?php

it('can create an index', function () {

    $client = getClient(true);

    $response = $client->index()->create(
        name: getIndexName(),
        dimension: 128
    );

    expect($response->status())->toBe(201);

});