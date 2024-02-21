<?php

namespace Probots\Pinecone\Requests\Collections;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * @link https://docs.pinecone.io/reference/list_collections
 *
 * @response
 * array of strings "$collectionName"
 */
class ListCollections extends Request
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
        return '/collections';
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
