<?php

namespace Probots\Pinecone\Requests\Data;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/update
 */
class UpdateVector extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string  $id,
        protected array   $values = [],
        protected array   $sparseValues = [],
        protected array   $setMetadata = [],
        protected ?string $namespace = null,
    ) {}

    protected function defaultBody(): array
    {
        $payload = [
            'id' => $this->id,
        ];

        if (count($this->values) > 0) {
            $payload['values'] = $this->values;
        }

        if (count($this->sparseValues) > 0) {
            $payload['sparse_values'] = $this->sparseValues;
        }

        if (count($this->setMetadata) > 0) {
            $payload['set_metadata'] = $this->setMetadata;
        }

        if ($this->namespace) {
            $payload['namespace'] = $this->namespace;
        }

        return $payload;
    }

    public function resolveEndpoint(): string
    {
        return '/vectors/update';
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}
