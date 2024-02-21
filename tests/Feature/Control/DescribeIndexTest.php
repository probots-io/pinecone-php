<?php

it('can describe an index', function () {

    $client = getClient(true);
    $index = getIndexName('-pod');

    $response = $client->control()->index($index)->describe();

    expect($response->status())->toBe(200)
        ->and($response->json('name'))->toBe($index);

});