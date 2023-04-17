<?php

namespace Probots\Pinecone\Requests\Index;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
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
class Configure extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * @var Method
     */
    protected Method $method = Method::PATCH;

    /**
     * @param string $name
     * @param int $replicas
     * @param string $pod_type
     */
    public function __construct(
        protected string $name,
        protected int    $replicas,
        protected string $pod_type
    )
    {

    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/databases/' . $this->name;
    }

    /**
     * @return array
     */
    protected function defaultBody(): array
    {
        return [
            'replicas' => $this->replicas,
            'pod_type' => $this->pod_type,
        ];
    }

    /**
     * @param Response $response
     * @return bool|null
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 202;
    }
}