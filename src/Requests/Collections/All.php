<?php

namespace Probots\Pinecone\Requests\Collections;

use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * @link https://docs.pinecone.io/reference/list_collections
 *
 * @response
 * array of strings "$collectionName"
 */
class All extends Request
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
