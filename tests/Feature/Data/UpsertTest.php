<?php

it('can upsert vectors', function () {

    $client = getClient(true);
    $index = $client->index(getIndexName());

    $response = $index->vectors()->upsert(vectors: [
        'id' => 'vector_1',
        'values' => array_fill(0, 128, 0.12),
        'metadata' => [
            'meta1' => 'value1',
        ]
    ]);

    expect($response->status())->toBe(200)
        ->and($response->json('upsertedCount'))->toBe(1);

});