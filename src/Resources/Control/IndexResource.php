<?php

namespace Probots\Pinecone\Resources\Control;

use Probots\Pinecone\Client;
use Probots\Pinecone\Requests\Control;
use Probots\Pinecone\Resources\Resource;
use Saloon\Http\Response;

class IndexResource extends Resource
{
    protected ?array $index = null;

    public function __construct(protected Client $connector, protected ?string $name = null)
    {
        parent::__construct($connector);
    }

    public function list(): Response
    {
        return $this->connector->send(new Control\ListIndexes());
    }

    public function createPod(
        int         $dimension,
        null|string $metric = null,
        null|string $environment = null,
        null|int    $replicas = null,
        null|string $pod_type = null,
        null|int    $pods = null,
        null|int    $shards = null,
        null|array  $metadataConfig = null,
        null|string $sourceCollection = null
    ): Response
    {
        $request = new Control\CreateIndex(
            name: $this->name,
            dimension: $dimension,
            metric: $metric,
        );

        return $this->connector->send($request->pod(
            environment: $environment,
            replicas: $replicas,
            pod_type: $pod_type,
            pods: $pods,
            shards: $shards,
            metadataConfig: $metadataConfig,
            sourceCollection: $sourceCollection

        ));
    }

    public function createServerless(
        int         $dimension,
        null|string $metric = null,
        null|string $cloud = null,
        null|string $region = null
    ): Response
    {

        $request = new Control\CreateIndex(
            name: $this->name,
            dimension: $dimension,
            metric: $metric,
        );

        return $this->connector->send($request->serverless(
            cloud: $cloud,
            region: $region
        ));
    }

    public function describe(): Response
    {
        return $this->connector->send(new Control\DescribeIndex(
            name: $this->name
        ));
    }

    public function configure(string $pod_type, int $replicas): Response
    {
        return $this->connector->send(new Control\ConfigureIndex(
            name: $this->name,
            replicas: $replicas,
            pod_type: $pod_type));
    }

    public function delete(): Response
    {
        return $this->connector->send(new Control\DeleteIndex(
            name: $this->name
        ));
    }
}