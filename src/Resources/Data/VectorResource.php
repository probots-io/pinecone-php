<?php

namespace Probots\Pinecone\Resources;

use Probots\Pinecone\Requests\Index\Vectors;
use Saloon\Contracts\Connector;
use Saloon\Contracts\Response;

class VectorResource extends Resource
{
    public function __construct(protected Connector $connector)
    {
        parent::__construct($connector);
    }

    public function stats(): Response
    {
        return $this->connector->send(new Vectors\DescribeIndexStats($this->index));
    }

    public function update(string  $id,
                           array   $values = [],
                           array   $sparseValues = [],
                           array   $setMetadata = [],
                           ?string $namespace = null): Response
    {
        return $this->connector->send(new Vectors\UpdateVector($this->index, id: $id, values: $values, sparseValues: $sparseValues, setMetadata: $setMetadata, namespace: $namespace));
    }


    public function upsert(array $vectors, ?string $namespace = null): Response
    {
        return $this->connector->send(new Vectors\UpsertVectors($this->index, $vectors, $namespace));
    }

    public function query(
        array   $vector = [],
        ?string $namespace = null,
        array   $filter = [],
        int     $topK = 3,
        bool    $includeMetadata = true,
        bool    $includeVector = false,
        ?string $id = null
    ): Response
    {
        return $this->connector->send(new Vectors\QueryVectors($this->index, vector: $vector, namespace: $namespace, filter: $filter, topK: $topK, includeMetadata: $includeMetadata, includeVector: $includeVector, id: $id));
    }

    public function delete(
        array   $ids = [],
        ?string $namespace = null,
        bool    $deleteAll = false,
        array   $filter = []
    ): Response
    {
        return $this->connector->send(new Vectors\DeleteVectors($this->index, ids: $ids, namespace: $namespace, deleteAll: $deleteAll, filter: $filter));
    }

    public function fetch(array $ids, ?string $namespace = null): Response
    {
        return $this->connector->send(new Vectors\FetchVectors($this->index, ids: $ids, namespace: $namespace));
    }
}