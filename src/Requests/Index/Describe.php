<?php

namespace Probots\Pinecone\Requests\Index;

use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * @link https://docs.pinecone.io/reference/describe_index
 *
 * @param string $name
 *
 * @response
 * object
 * database | object
 *   name | string
 *   dimension | string
 *   metric | string
 *   pods | integer
 *   replicas | integer
 *   shards | integer
 *   pod_type | string
 *   index_config | object
 *     k_bits | integer
 *     hybrid | boolean
 *   metadata_config | object
 *   status | object
 *     ready | boolean
 *     state | string | Initializing ScalingUp ScalingDown Terminating Ready
 *
 * @error_codes
 * 404 | Index not found.
 * 500 | Internal error. Can be caused by invalid parameters.
 */
class Describe extends Request
{
    /**
     * @var Method
     */
    protected Method $method = Method::GET;

    /**
     * @param string $name
     */
    public function __construct(
        protected string $name,
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
     * @param Response $response
     * @return bool|null
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}
