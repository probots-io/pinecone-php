<?php

it('can describe an index', function () {

    $client = getClient(true);

    $response = $client->index(getIndexName())->describe();

    expect($response->status())->toBe(200)
        ->and($response->json('database.name'))->toBe(getIndexName());

});
