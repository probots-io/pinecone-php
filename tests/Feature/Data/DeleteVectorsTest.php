<?php

it('can delete vectors', function () {

    $client = getClient(true);
    $index = getIndexName('-pod');

    // This is not good. Since the test relies on Pinecone having the needed index.
    setIndexHost($client, $index);

    $response = $client->data()->vectors()->delete(
        deleteAll: true,
    );

    expect($response->status())->toBe(200);

});