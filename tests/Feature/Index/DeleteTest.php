<?php

use Probots\Pinecone\Exceptions\MissingNameException;

it('can delete an index', function () {

    $client = getClient(true);

    $response = $client->index(getIndexName())->delete();

    expect($response->status())->toBe(202);

});

it('throws missing name exception', function () {

    $client = getClient(true);
    $client->index()->delete();

})->throws(MissingNameException::class);
