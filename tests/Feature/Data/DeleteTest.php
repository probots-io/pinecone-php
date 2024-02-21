<?php

it('can delete vectors', function () {

    $client = getClient(true);
    $index = $client->index(getIndexName());

    $response = $index->vectors()->delete(
        deleteAll: true,
    );

    expect($response->status())->toBe(200);

});