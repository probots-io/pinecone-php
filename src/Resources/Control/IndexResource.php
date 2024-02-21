<?php

namespace Probots\Pinecone\Resources;

use Probots\Pinecone\Client;
use Probots\Pinecone\Requests\Index;
use Saloon\Http\Response;

class IndexResource extends Resource
{
    protected ?array $index = null;

    public function __construct(protected Client $connector)
    {
        parent::__construct($connector);
    }

    public function list(): Response
    {
        return $this->connector->send(new Index\ListIndexes());
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


    public function describe(string $name): Response
    {
        return $this->connector->send(new Index\DescribeIndex(
            name: $name
        ));
    }

    public function configure(string $name, string $pod_type, int $replicas): Response
    {
        return $this->connector->send(new Index\ConfigureIndex(
            name: $name,
            replicas: $replicas,
            pod_type: $pod_type));
    }

    public function delete(string $name): Response
    {
        return $this->connector->send(new Index\DeleteIndex(
            name: $name
        ));
    }
}