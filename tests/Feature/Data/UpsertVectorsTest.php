<?php

it('can upsert vectors', function () {

    $client = getClient(true);
    $index = getIndexName('-pod');

    // This is not good. Since the test relies on Pinecone having the needed index.
    setIndexHost($client, $index);

    $response = $client->data()->vectors()->upsert(
        vectors: [
            [
                'id'       => 'vector_1',
                'values'   => array_fill(0, 128, 0.12),
                'metadata' => [
                    'meta1' => 'value1',
                ]
            ],
            [
                'id'       => 'vector_2',
                'values'   => array_fill(0, 128, 0.12),
                'metadata' => [
                    'meta1' => 'value2',
                ]
            ]
        ]
    );

    expect($response->status())->toBe(200)
        ->and($response->json('upsertedCount'))->toBe(2);

});