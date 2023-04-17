<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/delete_post
 *
 * @param array $index
 * @param array $ids
 * @param string|null $namespace
 * @param bool $deleteAll
 * @param array $filter
 *
 * @response
 * object (empty)
 *
 * @error_response
 * object
 * code | integer
 * message | string
 * details | array of objects
 *   typeUrl | string
 *   value | string
 */
class Delete extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * @var Method
     */
    protected Method $method = Method::DELETE;

    /**
     * @param array $index
     * @param array $ids
     * @param string|null $namespace
     * @param bool $deleteAll
     * @param array $filter
     */
    public function __construct(
        protected array   $index,
        protected array   $ids = [],
        protected ?string $namespace = null,
        protected bool    $deleteAll = false,
        protected array   $filter = []
    )
    {
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return 'https://' . $this->index['status']['host'] . '/vectors/delete';
    }

    /**
     * @return bool[]
     */
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

    /**
     * @param Response $response
     * @return bool|null
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}
