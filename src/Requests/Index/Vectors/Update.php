<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/update
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
class Update extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * @var Method
     */
    protected Method $method = Method::POST;

    /**
     * @param array $index
     * @param string $id
     * @param array $values
     * @param array $sparseValues
     * @param array $setMetadata
     * @param string|null $namespace
     */
    public function __construct(
        protected array   $index,
        protected string  $id,
        protected array   $values = [],
        protected array   $sparseValues = [],
        protected array   $setMetadata = [],
        protected ?string $namespace = null,
    )
    {
    }

    /**
     * @return string[]
     */
    protected function defaultBody(): array
    {
        $payload = [
            'id' => $this->id,
        ];

        if (count($this->values) > 0) {
            $payload['values'] = $this->values;
        }

        if (count($this->sparseValues) > 0) {
            $payload['sparse_values'] = $this->sparseValues;
        }

        if (count($this->setMetadata) > 0) {
            $payload['set_metadata'] = $this->setMetadata;
        }

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
        return 'https://' . $this->index['status']['host'] . '/vectors/update';
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
