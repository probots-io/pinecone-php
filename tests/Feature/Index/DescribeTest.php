<?php

use Probots\Pinecone\Requests\Exceptions\MissingNameException;

it('can describe an index', function () {

    $client = getClient(true);

    $response = $client->index(getIndexName())->describe();

    expect($response->status())->toBe(200)
        ->and($response->json('database.name'))->toBe(getIndexName());

});

it('throws missing name exception', function () {

    $client = getClient(true);
    $client->index()->describe();

})->throws(MissingNameException::class);