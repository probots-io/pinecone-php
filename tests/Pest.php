<?php


/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Probots\Pinecone\Client;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

uses(Tests\TestCase::class)->in('Feature');

if (!function_exists('dd')) {
    function dd()
    {
        $args = func_get_args();
        call_user_func_array('dump', $args);
        die();
    }
}

function getIndexName(): string
{
    return $_ENV['PINECONE_INDEX_NAME'];
}

function getCollectionName(): string
{
    return $_ENV['PINECONE_COLLECTION_NAME'];
}

function getClient(bool $mocked = false, string $fixtureSuffix = ''): Client
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $mock = new MockClient([
        '*' => function (PendingRequest $request) use ($fixtureSuffix) {
            $reflection = new ReflectionClass($request->getRequest());

            $name = strtolower(str_replace(['Probots\\Pinecone\\Requests\\', '\\'], ['', '.'], $reflection->getName()));

            return MockResponse::fixture($name . $fixtureSuffix);
        },
    ]);

    $client = new Probots\Pinecone\Client($_ENV['PINECONE_API_KEY'], $_ENV['PINECONE_ENVIRONMENT']);

    if ($mocked) {
        $client->withMockClient($mock);
    }


    return $client;
}