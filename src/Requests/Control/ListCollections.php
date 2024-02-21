<?php

namespace Probots\Pinecone\Requests\Control;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * @link https://docs.pinecone.io/reference/list_collections
 */
class ListCollections extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/collections';
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}
