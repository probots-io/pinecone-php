<?php

namespace Probots\Pinecone\Requests\Data;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/delete_post
 */
class DeleteVectors extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array   $ids = [],
        protected ?string $namespace = null,
        protected bool    $deleteAll = false,
        protected array   $filter = []
    ) {}

    public function resolveEndpoint(): string
    {
        return '/vectors/delete';
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

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}
