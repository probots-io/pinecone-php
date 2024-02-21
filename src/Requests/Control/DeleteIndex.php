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
    /**
     * @var Method
     */
    protected Method $method = Method::POST;

    /**
     * @param string $name
     */
    public function __construct(
        protected string $name,
    ) {}

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/databases/' . $this->name;
    }

    /**
     * @param Response $response
     * @return bool|null
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 202;
    }


}
