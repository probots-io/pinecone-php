<?php

it('can update vectors', function () {

    $client = getClient(true);
    $index = getIndexName('-pod');

    // This is not good. Since the test relies on Pinecone having the needed index.
    setIndexHost($client, $index);

    $response = $client->data()->vectors()->update(
        id: 'vector_1',
        values: array_fill(0, 128, 0.14),
        setMetadata: [
            'meta1' => 'value1',
        ]
    );

    expect($response->status())->toBe(200);

});