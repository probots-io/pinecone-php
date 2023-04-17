<?php

namespace Probots\Pinecone\Resources;

use Probots\Pinecone\Requests\Index\Vectors;
use Saloon\Contracts\Connector;
use Saloon\Contracts\Response;

/**
 *
 */
class VectorResource extends Resource
{
    /**
     * @param Connector $connector
     * @param array $index
     */
    public function __construct(protected Connector $connector, protected array $index)
    {
        parent::__construct($connector);
    }

    /**
     * @return Response
     */
    public function stats(): Response
    {
        return $this->connector->send(new Vectors\DescribeStats($this->index));
    }

    /**
     * @param string $id
     * @param array $values
     * @param array $sparseValues
     * @param array $setMetadata
     * @param string|null $namespace
     * @return Response
     */
    public function update(string  $id,
                           array   $values = [],
                           array   $sparseValues = [],
                           array   $setMetadata = [],
                           ?string $namespace = null): Response
    {


        return $this->connector->send(new Vectors\Update($this->index, id: $id, values: $values, sparseValues: $sparseValues, setMetadata: $setMetadata, namespace: $namespace));
    }

    /**
     * @param array $vectors
     * @param string|null $namespace
     * @return Response
     */
    public function upsert(array $vectors, ?string $namespace = null): Response
    {
        return $this->connector->send(new Vectors\Upsert($this->index, $vectors, $namespace));
    }

    /**
     * @param array $vector
     * @param string|null $namespace
     * @param array $filter
     * @param int $topK
     * @param bool $includeMetadata
     * @param bool $includeVector
     * @param string|null $id
     * @return Response
     */
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
        return $this->connector->send(new Vectors\Query($this->index, vector: $vector, namespace: $namespace, filter: $filter, topK: $topK, includeMetadata: $includeMetadata, includeVector: $includeVector, id: $id));
    }

    /**
     * @param array $ids
     * @param string|null $namespace
     * @param bool $deleteAll
     * @param array $filter
     * @return Response
     */
    public function delete(
        array   $ids = [],
        ?string $namespace = null,
        bool    $deleteAll = false,
        array   $filter = []
    ): Response
    {
        return $this->connector->send(new Vectors\Delete($this->index, ids: $ids, namespace: $namespace, deleteAll: $deleteAll, filter: $filter));
    }

    /**
     * @param array $ids
     * @param string|null $namespace
     * @return Response
     */
    public function fetch(array $ids, ?string $namespace = null): Response
    {
        return $this->connector->send(new Vectors\Fetch($this->index, ids: $ids, namespace: $namespace));
    }
}