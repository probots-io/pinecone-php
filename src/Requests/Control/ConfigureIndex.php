<?php

namespace Probots\Pinecone\Requests\Index;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/configure_index
 *
 * @param string $name
 * @param int $replicas
 * @param string $pod_type
 *
 * @response
 * string ""
 *
 * @error_codes
 * 400 | Bad request,not enough quota.
 * 404 | Index not found.
 * 500 | Internal error. Can be caused by invalid parameters.
 */
class ConfigureIndex extends Request
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;


    public function __construct(
        protected string $name,
        protected int    $replicas,
        protected string $pod_type
    ) {}


    public function resolveEndpoint(): string
    {
        return '/indexes/' . $this->name;
    }

    protected function defaultBody(): array
    {
        return [
            'spec' => [
                'pod' => [
                    'replicas' => $this->replicas,
                    'pod_type' => $this->pod_type,
                ],
            ]
        ];
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 202;
    }
}