<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/upsert
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
class Upsert extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * @var Method
     */
    protected Method $method = Method::POST;

    /**
     * @param array $index
     * @param array $vectors
     * @param string|null $namespace
     */
    public function __construct(
        protected array   $index,
        protected array   $vectors = [],
        protected ?string $namespace = null,
    )
    {
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return 'https://' . $this->index['status']['host'] . '/vectors/upsert';
    }

    /**
     * @return array[]
     */
    protected function defaultBody(): array
    {

        $payload = [
            'vectors' => $this->vectors,
        ];

        if ($this->namespace) {
            $payload['namespace'] = $this->namespace;
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
