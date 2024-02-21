<?php
it('can describe a collection', function () {

    $client = getClient(true);
    $collection = getCollectionName();

    $response = $client->control()->collection($collection)->describe();

    expect($response->status())->toBe(200)
        ->and($response->json('name'))->toBe($collection);

});
