<?php

namespace Probots\Pinecone\Requests\Index;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * @link https://docs.pinecone.io/reference/list_indexes
 *
 * @response
 * array of strings "$indexName"
 */
class ListIndexes extends Request
{
    /**
     * @var Method
     */
    protected Method $method = Method::GET;

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/databases';
    }

    /**
     * @param Response $response
     * @return bool|null
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}
