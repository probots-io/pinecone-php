<?php

namespace Probots\Pinecone\Requests\Collections;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * @link https://docs.pinecone.io/reference/list_collections
 */
class All extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/collections';
    }
}
