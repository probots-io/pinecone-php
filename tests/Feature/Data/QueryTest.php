<?php

it('can query vectors', function () {

    $client = getClient(true);
    $index = $client->index(getIndexName());

    $response = $index->vectors()->query(
        vector: array_fill(0, 128, 0.12),
        topK: 1,
    );

    expect($response->status())->toBe(200)
        ->and($response->json('matches'))->toBeArray()
        ->and(count($response->json('matches')))->toBeGreaterThanOrEqual(1);

});