<?php

it('can fetch one vector', function () {

    $client = getClient(true, '-one-vector');
    $index = getIndexName('-pod');

    // This is not good. Since the test relies on Pinecone having the needed index.
    setIndexHost($client, $index);

    $response = $client->data()->vectors()->fetch([
        'vector_1'
    ]);

    expect($response->status())->toBe(200)
        ->and($response->json('vectors.vector_1.id'))->toBe('vector_1');


});

it('can fetch multiple vectors', function () {

    $client = getClient(true, '-multiple-vectors');
    $index = getIndexName('-pod');

    // This is not good. Since the test relies on Pinecone having the needed index.
    setIndexHost($client, $index);

    $response = $client->data()->vectors()->fetch([
        'vector_1', 'vector_2'
    ]);

    expect($response->status())->toBe(200)
        ->and($response->json('vectors.vector_1.id'))->toBe('vector_1')
        ->and($response->json('vectors.vector_2.id'))->toBe('vector_2');


});