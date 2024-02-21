<?php

namespace Probots\Pinecone\Resources\Data;

use Probots\Pinecone\Client;
use Probots\Pinecone\Requests\Data;
use Probots\Pinecone\Resources\Resource;
use Saloon\Http\Response;

class VectorResource extends Resource
{
    public function __construct(protected Client $connector)
    {
        parent::__construct($connector);
    }

    public function stats(): Response
    {
        return $this->connector->send(new Data\GetIndexStats());
    }

    public function update(string  $id,
                           array   $values = [],
                           array   $sparseValues = [],
                           array   $setMetadata = [],
                           ?string $namespace = null): Response
    {
        return $this->connector->send(new Data\UpdateVector(
            id: $id,
            values: $values,
            sparseValues: $sparseValues,
            setMetadata: $setMetadata,
            namespace: $namespace
        ));
    }


    public function upsert(array $vectors, ?string $namespace = null): Response
    {
        return $this->connector->send(new Data\UpsertVectors($vectors, $namespace));
    }

    public function query(
        array   $vector = [],
        ?string $namespace = null,
        array   $filter = [],
        int     $topK = 3,
        bool    $includeMetadata = true,
        bool    $includeValues = false,
        ?string $id = null
    ): Response
    {
        return $this->connector->send(new Data\QueryVectors(
            vector: $vector,
            namespace: $namespace,
            filter: $filter,
            topK: $topK,
            includeMetadata: $includeMetadata,
            includeValues: $includeValues,
            id: $id
        ));
    }

    public function delete(
        array   $ids = [],
        ?string $namespace = null,
        bool    $deleteAll = false,
        array   $filter = []
    ): Response
    {
        return $this->connector->send(new Data\DeleteVectors(
            ids: $ids,
            namespace: $namespace,
            deleteAll: $deleteAll,
            filter: $filter
        ));
    }

    public function fetch(array $ids, ?string $namespace = null): Response
    {
        return $this->connector->send(new Data\FetchVectors(
            ids: $ids,
            namespace: $namespace
        ));
    }
}