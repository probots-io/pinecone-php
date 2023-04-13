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

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/


expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/


if (!function_exists('dd')) {
    function dd()
    {
        $args = func_get_args();
        call_user_func_array('dump', $args);
        die();
    }
}

function getIndexName()
{
    return $_ENV['PINECONE_INDEX_NAME'];
}

function getCollectionName()
{
    return $_ENV['PINECONE_COLLECTION_NAME'];
}

function getClient(bool $mocked = false)
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $mock = new MockClient([
        '*' => function (PendingRequest $request) {
            $reflection = new ReflectionClass($request->getRequest());

            $name = strtolower(str_replace(['Probots\\Pinecone\\Requests\\', '\\'], ['', '.'], $reflection->getName()));

            return MockResponse::fixture($name);
        },
    ]);

    $client = new Probots\Pinecone\Client($_ENV['PINECONE_API_KEY'], $_ENV['PINECONE_ENVIRONMENT']);

    if ($mocked) {
        $client->withMockClient($mock);
    }


    return $client;
}