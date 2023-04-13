<?php

namespace Probots\Pinecone\Requests\Index;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/create_index
 */
class Create extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

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

    public function resolveEndpoint(): string
    {
        return '/databases';
    }

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
}

