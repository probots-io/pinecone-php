<?php

namespace Probots\Pinecone\Requests\Control;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * @link https://docs.pinecone.io/reference/create_index
 */
class CreateIndex extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    protected string $mode = 'pod';

    protected ?string $cloud;
    private ?string $region;
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
        protected ?string $metric,
    ) {}

    public function serverless(
        ?string $cloud,
        ?string $region
    ): self
    {

        $this->mode = 'serverless';

        $this->cloud = $cloud;
        $this->region = $region;

        return $this;
    }

    public function pod(
        ?string $environment,
        ?int    $replicas,
        ?string $pod_type,
        ?int    $pods,
        ?int    $shards,
        ?array  $metadataConfig,
        ?string $sourceCollection,
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
            'metric'    => $this->metric ?? 'cosine',
        ];

        $spec = [];

        if ($this->mode === 'serverless') {
            $spec = [
                'serverless' => [
                    'cloud'  => $this->cloud ?? 'aws',
                    'region' => $this->region ?? 'us-west-2',
                ]
            ];
        }

        if ($this->mode === 'pod') {
            $spec = [
                'pod' => [
                    'environment' => $this->environment ?? 'us-east1-gcp',
                    'replicas'    => $this->replicas ?? 1,
                    'pod_type'    => $this->pod_type ?? 'p1.x1',
                    'pods'        => $this->pods ?? 1,
                    'shards'      => $this->shards ?? 1,
                ]
            ];

            if ($this->metadataConfig !== null) {
                $spec['pod']['metadata_config'] = $this->metadataConfig;
            }

            if ($this->sourceCollection !== null) {
                $spec['pod']['source_collection'] = $this->sourceCollection;
            }
        }

        $payload['spec'] = $spec;

        return $payload;
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 201;
    }
}

