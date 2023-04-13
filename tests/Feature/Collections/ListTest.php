<?php

it('can list collections', function () {

    $client = getClient(true);

    $response = $client->collections()->list();

    expect($response->status())->toBe(200)
        ->and($response->json('0'))->toBe(getCollectionName());

});