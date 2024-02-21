<?php

it('can query vectors', function () {

    $client = getClient(true);
    $index = getIndexName('-pod');

    // This is not good. Since the test relies on Pinecone having the needed index.
    setIndexHost($client, $index);

    $response = $client->data()->vectors()->query(
        vector: array_fill(0, 128, 0.12),
        topK: 1,
    );

    expect($response->status())->toBe(200)
        ->and($response->json('matches'))->toBeArray()
        ->and(count($response->json('matches')))->toBeGreaterThanOrEqual(1);

});