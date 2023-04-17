<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/query
 *
 * @param array $index
 * @param array $vector
 * @param string|null $namespace
 * @param array $filter
 * @param int $topK
 * @param bool $includeMetadata
 * @param bool $includeVector
 * @param string|null $id
 *
 * @response
 * object
 * matches | array of objects
 *   id | string
 *   score | float
 *   values | array of floats
 *   sparseValues | object
 *     indices | array of integers
 *     values | array of floats
 *   metadata | object
 * namespace | string
 *
 * @error_response
 * object
 * code | integer
 * message | string
 * details | array of objects
 *   typeUrl | string
 *   value | string
 */
class Query extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * @var Method
     */
    protected Method $method = Method::POST;


    /**
     * @param array $index
     * @param array $vector
     * @param string|null $namespace
     * @param array $filter
     * @param int $topK
     * @param bool $includeMetadata
     * @param bool $includeVector
     * @param string|null $id
     */
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

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return 'https://' . $this->index['status']['host'] . '/query';
    }

    /**
     * @return array
     */
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

    /**
     * @param Response $response
     * @return bool|null
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}
