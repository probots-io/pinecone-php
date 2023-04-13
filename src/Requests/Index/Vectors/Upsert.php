<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class Upsert extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array   $index,
        protected array   $vectors = [],
        protected ?string $namespace = null,
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return 'https://' . $this->index['status']['host'] . '/vectors/upsert';
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
}
