<?php

it('can list collections', function () {

    $client = getClient(true);
    $collection = getCollectionName();

    $response = $client->control()->collection()->list();

    expect($response->status())->toBe(200)
        ->and($response->json('collections.0.name'))->toBe($collection);

});