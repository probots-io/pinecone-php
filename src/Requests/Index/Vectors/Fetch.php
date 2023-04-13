<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class Fetch extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected array   $index,
        protected array   $ids,
        protected ?string $namespace = null,
    )
    {
    }

    protected function defaultQuery(): array
    {
        $payload = [
            'ids' => $this->ids,
        ];

        if ($this->namespace) {
            $payload['namespace'] = $this->namespace;
        }

        return $payload;
    }

    public function resolveEndpoint(): string
    {
        return 'https://' . $this->index['status']['host'] . '/vectors/fetch';
    }
}