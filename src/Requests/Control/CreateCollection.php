<?php

namespace Probots\Pinecone\Requests\Collections;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/create_collection
 *
 * @param string $name
 * @param string $source
 *
 * @response
 * string ""
 *
 * @error_codes
 * 400 | Bad request. Request exceeds quota or collection name is invalid.
 * 409 | A collection with the name provided already exists.
 * 500 | Internal error. Can be caused by invalid parameters.
 */
class CreateCollection extends Request
{
    use HasJsonBody;

    /**
     * @var Method
     */
    protected Method $method = Method::POST;


    public function __construct(
        protected string $name,
        protected string $source,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/collections';
    }

    protected function defaultBody(): array
    {
        return [
            'name'   => $this->name,
            'source' => $this->source,
        ];
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 201;
    }
}

