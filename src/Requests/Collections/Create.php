<?php

namespace Probots\Pinecone\Requests\Collections;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/create_collection
 */
class Create extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $name,
        protected string $source,
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return '/collections';
    }

    protected function defaultBody(): array
    {
        return [
            'name' => $this->name,
            'source' => $this->source,
        ];
    }
}
