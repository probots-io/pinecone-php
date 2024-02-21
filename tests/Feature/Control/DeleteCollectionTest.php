<?php

it('can delete a collection', function () {

    $client = getClient(true);
    $collection = getCollectionName();

    $response = $client->control()->collection($collection)->delete();

    expect($response->status())->toBe(202);

});