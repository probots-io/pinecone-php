<?php

namespace Probots\Pinecone\Requests\Index;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/configure_index
 */
class Configure extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $name,
        protected int    $replicas,
        protected string $pod_type
    )
    {

    }

    public function resolveEndpoint(): string
    {
        return '/databases/' . $this->name;
    }

    protected function defaultBody(): array
    {
        return [
            'replicas' => $this->replicas,
            'pod_type' => $this->pod_type,
        ];
    }
}