<?php

it('can create a collection', function () {

    $client = getClient(true);
    $collection = getCollectionName();
    $index = getIndexName('-pod');

    $response = $client->control()->collection($collection)->create(
        source: $index
    );

    expect($response->status())->toBe(201);
});