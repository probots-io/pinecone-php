<?php

namespace Probots\Pinecone\Requests\Collections;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * @link https://docs.pinecone.io/reference/delete_collection
 *
 * @param string $name
 *
 * @response
 * string ""
 *
 * @error_codes
 * 404 | Collection not found.
 * 500 | Internal error. Can be caused by invalid parameters.
 */
class DeleteCollection extends Request
{

    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $name
    ) {}

    public function resolveEndpoint(): string
    {
        return '/collections/' . $this->name;
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 202;
    }
}
