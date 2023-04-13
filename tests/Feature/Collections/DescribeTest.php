<?php


it('can describe a collection', function () {

    $client = getClient(true);

    $response = $client->collections(getCollectionName())->describe();

    expect($response->status())->toBe(200)
        ->and($response->json('name'))->toBe(getCollectionName());

});
