<?php

it('can describe index vector stats', function () {

    $client = getClient(true);
    $index = $client->index(getIndexName());

    $response = $index->vectors()->stats();

    expect($response->status())->toBe(200)
        ->and($response->json('dimension'))->toBe(128);

});