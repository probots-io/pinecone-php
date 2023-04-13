<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class Query extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;


    public function __construct(
        protected array   $index,
        protected array   $vector = [],
        protected ?string $namespace = null,
        protected array   $filter = [],
        protected int     $topK = 10,
        protected bool    $includeMetadata = true,
        protected bool    $includeVector = false,
        protected ?string $id = null,
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return 'https://' . $this->index['status']['host'] . '/query';
    }

    protected function defaultBody(): array
    {
        $payload = [
            'topK' => $this->topK,
            'includeMetadata' => $this->includeMetadata,
            'includeVector' => $this->includeVector,
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
}
