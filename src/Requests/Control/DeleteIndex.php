<?php

namespace Probots\Pinecone\Requests\Control;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * @link https://docs.pinecone.io/reference/delete_index
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
