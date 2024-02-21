<?php

namespace Probots\Pinecone\Resources;

use Probots\Pinecone\Requests\Index;
use Saloon\Contracts\Connector;
use Saloon\Contracts\Response;

class IndexResource extends Resource
{
    protected ?array $index = null;

    public function __construct(protected Connector $connector)
    {
        parent::__construct($connector);
    }


    public function describe(): Response
    {
        return $this->connector->send(new Index\DescribeIndex());
    }

    public function createPod(
        string      $name,
        int         $dimension,
        null|string $metric = null,
        null|string $environment = null,
        null|int    $replicas = null,
        null|string $pod_type = null,
        null|int    $pods = null,
        null|int    $shards = null,
        null|array  $metadataConfig = null,
        null|string $sourceCollection = null
    )
    {
        $request = new Index\CreateIndex(
            name: $name,
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
        string      $name,
        int         $dimension,
        null|string $metric = null,
        null|string $cloud = null,
        null|string $region = null
    )
    {

        $request = new Index\CreateIndex(
            name: $name,
            dimension: $dimension,
            metric: $metric,
        );

        return $this->connector->send($request->serverless(
            cloud: $cloud,
            region: $region
        ));

    }

    public function list(): Response
    {
        return $this->connector->send(new Index\ListIndexes());
    }

    public function configure(string $pod_type, int $replicas): Response
    {
        return $this->connector->send(new Index\ConfigureIndex($replicas, $pod_type));
    }

    public function delete(): Response
    {
        return $this->connector->send(new Index\DeleteIndex());
    }
}