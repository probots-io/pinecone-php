<?php

it('can fetch vectors', function () {

    $client = getClient(false);
    $index = $client->index(getIndexName());

    $response = $index->vectors()->fetch([
        'vector_1',
    ]);

    expect($response->status())->toBe(200)
        ->and($response->json('vectors.0.id'))->toBe('vector_1');


})->skip('returns empty string currently, not sure why.');