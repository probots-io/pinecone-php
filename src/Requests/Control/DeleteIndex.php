<?php

namespace Probots\Pinecone\Requests\Index;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * @link https://docs.pinecone.io/reference/delete_index
 *
 * @param string $name
 *
 * @response
 * string ""
 *
 * @error_codes
 * 404 | Index not found.
 * 500 | Internal error. Can be caused by invalid parameters.
 */
class DeleteIndex extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $name,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/indexes/' . $this->name;
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 202;
    }


}
