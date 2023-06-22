<?php

it('can fetch one vector', function () {

    $client = getClient(true, 'one-vector');
    $index = $client->index(getIndexName());

    $response = $index->vectors()->fetch([
        'vector_1'
    ]);

    expect($response->status())->toBe(200)
        ->and($response->json('vectors.vector_1.id'))->toBe('vector_1');


});

it('can fetch multiple vectors', function () {

    $client = getClient(true, 'multiple-vectors');
    $index = $client->index(getIndexName());

    $response = $index->vectors()->fetch([
        'vector_1', 'vector_2'
    ]);

    expect($response->status())->toBe(200)
        ->and($response->json('vectors.vector_1.id'))->toBe('vector_1')
        ->and($response->json('vectors.vector_2.id'))->toBe('vector_2');


});