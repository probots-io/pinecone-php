<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class Delete extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    public function __construct(
        protected array   $index,
        protected array   $ids = [],
        protected ?string $namespace = null,
        protected bool    $deleteAll = false,
        protected array   $filter = []
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return 'https://' . $this->index['status']['host'] . '/vectors/delete';
    }

    protected function defaultBody(): array
    {
        $payload = [
            'deleteAll' => $this->deleteAll,
        ];

        if ($this->namespace) {
            $payload['namespace'] = $this->namespace;
        }

        if (count($this->ids) > 0) {
            $payload['ids'] = $this->ids;
        }

        if (count($this->filter) > 0) {
            $payload['filter'] = $this->filter;
        }

        return $payload;
    }
}
