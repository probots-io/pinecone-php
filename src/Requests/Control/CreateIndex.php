<?php

namespace Probots\Pinecone\Requests\Index;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/create_index
 *
 * @response
 * string ""
 *
 * @error_codes
 * 400 | Bad request. Encountered when request exceeds quota or an invalid index name.
 * 409 | Index of given name already exists.
 * 500 | Internal error. Can be caused by invalid parameters.
 */
class CreateIndex extends Request
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    protected string $mode = 'pod';

    protected string $cloud;
    private string $region;
    protected ?string $environment;
    private ?int $replicas;
    private ?string $pod_type;
    private ?int $pods;
    private ?int $shards;
    private ?array $metadataConfig;
    private ?string $sourceCollection;


    public function __construct(
        protected string  $name,
        protected int     $dimension,
        protected ?string $metric = 'cosine',
    ) {}

    public function serverless(
        ?string $cloud = 'gcp',
        ?string $region = 'us-west-2'
    ): self
    {

        $this->mode = 'serverless';

        $this->cloud = $cloud;
        $this->region = $region;

        return $this;
    }

    public function pod(
        ?string $environment = 'us-east1-gcp',
        ?int    $replicas = 1,
        ?string $pod_type = 'p1.x1',
        ?int    $pods = 1,
        ?int    $shards = 1,
        ?array  $metadataConfig = null,
        ?string $sourceCollection = null,
    ): self
    {
        $this->mode = 'pod';

        $this->environment = $environment;
        $this->replicas = $replicas;
        $this->pod_type = $pod_type;
        $this->pods = $pods;
        $this->shards = $shards;
        $this->metadataConfig = $metadataConfig;
        $this->sourceCollection = $sourceCollection;

        return $this;

    }


    public function resolveEndpoint(): string
    {
        return '/indexes';
    }

    protected function defaultBody(): array
    {
        $payload = [
            'name'      => $this->name,
            'dimension' => $this->dimension,
            'metric'    => $this->metric,
            'spec'      => [],
        ];

        if ($this->mode === 'serverless') {
            $payload['spec'] = [
                'cloud'  => $this->cloud,
                'region' => $this->region,
            ];
        }

        if ($this->mode === 'pod') {
            $payload['spec'] = [
                'environment' => $this->environment,
                'replicas'    => $this->replicas,
                'pod_type'    => $this->pod_type,
                'pods'        => $this->pods,
                'shards'      => $this->shards,
            ];

            if ($this->metadataConfig !== null) {
                $payload['spec']['metadata_config'] = $this->metadataConfig;
            }

            if ($this->sourceCollection !== null) {
                $payload['spec']['source_collection'] = $this->sourceCollection;
            }
        }

        return $payload;
    }

    public function hasRequestFailed(Response|\Saloon\Contracts\Response $response): ?bool
    {
        return $response->status() !== 201;
    }
}

