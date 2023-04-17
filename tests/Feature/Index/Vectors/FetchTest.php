<?php

it('can fetch vectors', function () {

    $client = getClient(true);
    $index = $client->index(getIndexName());

    $response = $index->vectors()->fetch([
        'vector_1',
    ]);

    expect($response->status())->toBe(200)
        ->and($response->json('vectors.vector_1.id'))->toBe('vector_1');


});