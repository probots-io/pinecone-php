<?php

it('can describe index vector stats', function () {

    $client = getClient(true);
    $index = getIndexName('-pod');
    
    // This is not good. Since the test relies on Pinecone having the needed index.
    setIndexHost($client, $index);

    $response = $client->data()->vectors()->stats();

    expect($response->status())->toBe(200)
        ->and($response->json('dimension'))->toBe(128);

});