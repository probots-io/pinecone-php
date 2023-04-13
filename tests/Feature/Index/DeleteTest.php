<?php

it('can delete an index', function () {

    $client = getClient(true);

    $response = $client->index(getIndexName())->delete();

    expect($response->status())->toBe(202);

});
