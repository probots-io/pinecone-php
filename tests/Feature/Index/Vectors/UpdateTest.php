<?php

it('can update vectors', function () {

    $client = getClient(true);
    $index = $client->index(getIndexName());

    $response = $index->vectors()->update(
        id: 'vector_1',
        values: array_fill(0, 128, 0.14),
        setMetadata: [
            'meta1' => 'value1',
        ]
    );

    expect($response->status())->toBe(200);

});