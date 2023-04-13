<?php

it('can create a collection', function () {

    $client = getClient(true);

    $response = $client->collections()->create(
        name: getCollectionName(),
        source: getIndexName()
    );

    expect($response->status())->toBe(201);
});