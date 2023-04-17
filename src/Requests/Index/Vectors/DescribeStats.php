<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * @link https://docs.pinecone.io/reference/describe_index_stats_post
 *
 * @param array $index
 * @param array $filter
 *
 * @response
 * object
 * namespaces | object
 *   namespace | object
 *    vectorCount | integer
 * dimension | integer
 * indexFullness | float
 * totalVectorCount | integer
 *
 * @error_response
 * object
 * code | integer
 * message | string
 * details | array of objects
 *   typeUrl | string
 *   value | string
 */
class DescribeStats extends Request
{
    /**
     * @var Method
     */
    protected Method $method = Method::POST;

    /**
     * @param array $index
     * @param array $filter
     */
    public function __construct(
        protected array $index,
        protected array $filter = []
    )
    {
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return 'https://' . $this->index['status']['host'] . '/describe_index_stats';
    }

    /**
     * @return array
     */
    protected function defaultBody(): array
    {
        $payload = [];

        if (count($this->filter) > 0) {
            $payload['filter'] = $this->filter;
        }
        return $payload;
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
