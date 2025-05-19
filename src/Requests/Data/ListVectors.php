<?php

namespace Probots\Pinecone\Requests\Data;

use GuzzleHttp\Psr7\Query;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\RequestProperties\HasQuery;

/**
 * @link https://docs.pinecone.io/reference/api/2025-01/data-plane/list
 */
class ListVectors extends Request
{
    use HasQuery;

    protected Method $method = Method::GET;

    public function __construct(
        protected string  $prefix,
        protected ?string $namespace = null,
    ) {}

    protected function defaultQuery(): array
    {
        $payload = [
            'prefix' => $this->prefix
        ];

        if ($this->namespace) {
            $payload['namespace'] = $this->namespace;
        }

        return $payload;
    }

    public function resolveEndpoint(): string
    {
        return '/vectors/list';
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}