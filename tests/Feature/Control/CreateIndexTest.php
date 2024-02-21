<?php

it('can create an index (pod)', function () {

    $client = getClient(true, '.pod');
    $index = getIndexName('-pod');

    $response = $client->control()->index($index)->createPod(
        dimension: 128
    );

    expect($response->status())->toBe(201);

});

it('can create an index (serverless)', function () {

    $client = getClient(true, '.serverless');
    $index = getIndexName('-serverless');

    $response = $client->control()->index($index)->createServerless(
        dimension: 128
    );

    expect($response->status())->toBe(201);

});