<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\RequestProperties\HasQuery;

/**
 * @link https://docs.pinecone.io/reference/fetch
 *
 * @param array $index
 * @param array $ids
 * @param string|null $namespace
 *
 * @response
 *
 *
 * @error_response
 * object
 * code | integer
 * message | string
 * details | array of objects
 *   typeUrl | string
 *   value | string
 */
class Fetch extends Request implements HasBody
{
    use HasJsonBody, HasQuery;

    /**
     * @var Method
     */
    protected Method $method = Method::GET;

    /**
     * @param array $index
     * @param array $ids
     * @param string|null $namespace
     */
    public function __construct(
        protected array   $index,
        protected array   $ids,
        protected ?string $namespace = null,
    )
    {
    }

    /**
     * @return array|mixed[]
     */
    protected function defaultQuery(): array
    {
        $payload = [
            'ids' => implode(',', $this->ids), // 🙈
        ];

        if ($this->namespace) {
            $payload['namespace'] = $this->namespace;
        }

        return $payload;
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return 'https://' . $this->index['status']['host'] . '/vectors/fetch';
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