<?php

namespace Probots\Pinecone\Requests\Data;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/query
 */
class QueryVectors extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array   $vector = [],
        protected ?string $namespace = null,
        protected array   $filter = [],
        protected int     $topK = 10,
        protected bool    $includeMetadata = true,
        protected bool    $includeValues = false,
        protected ?string $id = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/query';
    }

    protected function defaultBody(): array
    {
        $payload = [
            'topK'            => $this->topK,
            'includeMetadata' => $this->includeMetadata,
            'includeValues'   => $this->includeValues,
        ];

        if (count($this->vector) > 0) {
            $payload['vector'] = $this->vector;
        }

        if ($this->namespace) {
            $payload['namespace'] = $this->namespace;
        }

        if (count($this->filter) > 0) {
            $payload['filter'] = $this->filter;
        }

        if ($this->id) {
            $payload['id'] = $this->id;
            unset($payload['vector']);
        }

        return $payload;
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}
