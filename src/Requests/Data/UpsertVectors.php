<?php

namespace Probots\Pinecone\Requests\Data;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/upsert
 */
class UpsertVectors extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array   $vectors = [],
        protected ?string $namespace = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/vectors/upsert';
    }

    protected function defaultBody(): array
    {
        $payload = [
            'vectors' => $this->vectors,
        ];

        if ($this->namespace) {
            $payload['namespace'] = $this->namespace;
        }
        return $payload;
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}
