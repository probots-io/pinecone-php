<?php
it('can list indexes', function () {

    $client = getClient(true);
    $index = getIndexName('-pod');

    $response = $client->control()->index()->list();

    expect($response->status())->toBe(200)
        ->and($response->json('indexes.0.name'))->toBe($index);
});