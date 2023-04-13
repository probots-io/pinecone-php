<?php

namespace Probots\Pinecone\Requests\Index;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * @link https://docs.pinecone.io/reference/delete_index
 */
class Delete extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $name,
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return '/databases/' . $this->name;
    }


}
