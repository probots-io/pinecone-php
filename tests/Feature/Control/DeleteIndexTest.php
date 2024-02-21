<?php

it('can delete an index (pod)', function () {

    $client = getClient(true, '.pod');
    $index = getIndexName('-pod');

    $response = $client->control()->index($index)->delete();

    expect($response->status())->toBe(202);

});

it('can delete an index (serverless)', function () {

    $client = getClient(true, '.serverless');
    $index = getIndexName('-serverless');

    $response = $client->control()->index($index)->delete();

    expect($response->status())->toBe(202);

});