<?php

namespace Probots\Pinecone\Resources;

use Exception;
use Probots\Pinecone\Requests\Index;
use Saloon\Contracts\Connector;
use Saloon\Contracts\Response;

class IndexResource extends Resource
{
    protected ?array $index = null;

    public function __construct(protected Connector $connector, protected ?string $name)
    {
        parent::__construct($connector);
    }

    public function vectors(): VectorResource
    {
        $this->validateName();
        $this->maybeDescribeIndex();

        return new VectorResource($this->connector, $this->index);
    }

    private function validateName()
    {
        if ($this->name === null) {
            throw new Exception('Index name is required');
        }
    }

    private function maybeDescribeIndex(): void
    {
        if ($this->index === null) {
            $this->index = $this->describe()->json();
        }
    }

    public function describe(): Response
    {
        $this->validateName();

        return $this->connector->send(new Index\Describe($this->name));
    }

    public function create(
        string      $name,
        int         $dimension,
        null|string $metric = null,
        null|int    $pods = null,
        null|int    $replicas = null,
        null|string $pod_type = null,
        null|array  $metadataConfig = null,
        null|string $sourceCollection = null
    ): Response
    {
        return $this->connector->send(new Index\Create(
            name: $name,
            dimension: $dimension,
            metric: $metric,
            pods: $pods,
            replicas: $replicas,
            pod_type: $pod_type,
            metadataConfig: $metadataConfig,
            sourceCollection: $sourceCollection
        ));
    }

    public function list(): Response
    {
        return $this->connector->send(new Index\All());
    }

    public function configure(string $pod_type, int $replicas): Response
    {
        $this->validateName();

        return $this->connector->send(new Index\Configure($this->name, $replicas, $pod_type));
    }

    public function delete(): Response
    {
        $this->validateName();

        return $this->connector->send(new Index\Delete($this->name));
    }
}