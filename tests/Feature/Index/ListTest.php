<?php

it('can list indices', function () {

    $client = getClient(true);

    $response = $client->index()->list();

    expect($response->status())->toBe(200)
        ->and($response->json('0'))->toBe(getIndexName());
});