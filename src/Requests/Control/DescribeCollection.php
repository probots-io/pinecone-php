<?php

namespace Probots\Pinecone\Requests\Collections;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * @link https://docs.pinecone.io/reference/describe_collection
 *
 * @param string $name
 *
 * @response
 * object
 * name | string
 * size | integer
 * status | string
 *
 * @error_codes
 * 404 | Collection not found.
 * 500 | Internal error. Can be caused by invalid parameters.
 */
class DescribeCollection extends Request
{

    protected Method $method = Method::GET;


    public function __construct(
        protected string $name
    ) {}


    public function resolveEndpoint(): string
    {
        return '/collections/' . $this->name;
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}
