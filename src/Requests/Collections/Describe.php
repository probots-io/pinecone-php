<?php

namespace Probots\Pinecone\Requests\Collections;

use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

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
class Describe extends Request
{
    /**
     * @var Method
     */
    protected Method $method = Method::GET;

    /**
     * @param string $name
     */
    public function __construct(
        protected string $name
    )
    {
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/collections/' . $this->name;
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
