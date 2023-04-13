<?php

it('can delete a collection', function () {

    $client = getClient(true);

    $response = $client->collections(getCollectionName())->delete();

    expect($response->status())->toBe(202);

});
