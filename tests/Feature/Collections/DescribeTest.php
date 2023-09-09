<?php

use Probots\Pinecone\Exceptions\MissingNameException;

it('can describe a collection', function () {

    $client = getClient(true);

    $response = $client->collections(getCollectionName())->describe();

    expect($response->status())->toBe(200)
        ->and($response->json('name'))->toBe(getCollectionName());

});

it('throws missing name exception', function () {

    $client = getClient(true);
    $client->collections()->describe();

})->throws(MissingNameException::class);
