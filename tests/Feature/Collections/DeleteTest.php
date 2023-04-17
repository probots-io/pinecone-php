<?php

use Probots\Pinecone\Requests\Exceptions\MissingNameException;

it('can delete a collection', function () {

    $client = getClient(true);

    $response = $client->collections(getCollectionName())->delete();

    expect($response->status())->toBe(202);

});

it('throws missing name exception', function () {

    $client = getClient(true);
    $client->collections()->delete();

})->throws(MissingNameException::class);
