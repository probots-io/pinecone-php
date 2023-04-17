<?php

namespace Probots\Pinecone\Requests\Index;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/create_index
 *
 * @param string $name
 * @param int $dimension
 * @param string|null $metric
 * @param int|null $pods
 * @param int|null $replicas
 * @param string|null $pod_type
 * @param array|null $metadataConfig
 * @param string|null $sourceCollection
 *
 * @response
 * string ""
 *
 * @error_codes
 * 400 | Bad request. Encountered when request exceeds quota or an invalid index name.
 * 409 | Index of given name already exists.
 * 500 | Internal error. Can be caused by invalid parameters.
 */
class Create extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * @var Method
     */
    protected Method $method = Method::POST;

    /**
     * @param string $name
     * @param int $dimension
     * @param string|null $metric
     * @param int|null $pods
     * @param int|null $replicas
     * @param string|null $pod_type
     * @param array|null $metadataConfig
     * @param string|null $sourceCollection
     */
    public function __construct(
        protected string  $name,
        protected int     $dimension,
        protected ?string $metric = 'cosine',
        protected ?int    $pods = 1,
        protected ?int    $replicas = 1,
        protected ?string $pod_type = 'p1.x1',
        protected ?array  $metadataConfig = null,
        protected ?string $sourceCollection = null,
    )
    {

    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/databases';
    }

    /**
     * @return array
     */
    protected function defaultBody(): array
    {
        $payload = [
            'name' => $this->name,
            'dimension' => $this->dimension,
            'metric' => $this->metric,
            'pods' => $this->pods,
            'replicas' => $this->replicas,
            'pod_type' => $this->pod_type,
        ];

        if ($this->metadataConfig !== null) {
            $payload['metadata_config'] = $this->metadataConfig;
        }

        if ($this->sourceCollection !== null) {
            $payload['source_collection'] = $this->sourceCollection;
        }
        return $payload;
    }

    /**
     * @param Response $response
     * @return bool|null
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 201;
    }
}

