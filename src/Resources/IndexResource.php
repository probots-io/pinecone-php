<?php

namespace Probots\Pinecone\Resources;

use Probots\Pinecone\Requests\Exceptions\MissingNameException;
use Probots\Pinecone\Requests\Index;
use Saloon\Contracts\Connector;
use Saloon\Contracts\Response;

class IndexResource extends Resource
{
    /**
     * @var array|null
     */
    protected ?array $index = null;

    /**
     * @param Connector $connector
     * @param string|null $name
     */
    public function __construct(protected Connector $connector, protected ?string $name)
    {
        parent::__construct($connector);
    }

    /**
     * @return VectorResource
     *
     * @throws MissingNameException
     */
    public function vectors(): VectorResource
    {
        $this->validateName();
        $this->maybeDescribeIndex();

        return new VectorResource($this->connector, $this->index);
    }

    /**
     * @throws MissingNameException
     */
    private function validateName()
    {
        if ($this->name === null) {
            throw new MissingNameException('Index name is required');
        }
    }

    /**
     * @return void
     * @throws MissingNameException
     */
    private function maybeDescribeIndex(): void
    {
        if ($this->index === null) {
            $this->index = $this->describe()->json();
        }
    }

    /**
     * @throws MissingNameException
     */
    public function describe(): Response
    {
        $this->validateName();

        return $this->connector->send(new Index\Describe($this->name));
    }

    /**
     * @param string $name
     * @param int $dimension
     * @param string|null $metric
     * @param int|null $pods
     * @param int|null $replicas
     * @param string|null $pod_type
     * @param array|null $metadataConfig
     * @param string|null $sourceCollection
     * @return Response
     */
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

    /**
     * @return Response
     */
    public function list(): Response
    {
        return $this->connector->send(new Index\All());
    }

    /**
     * @param string $pod_type
     * @param int $replicas
     * @return Response
     *
     * @throws MissingNameException
     */
    public function configure(string $pod_type, int $replicas): Response
    {
        $this->validateName();

        return $this->connector->send(new Index\Configure($this->name, $replicas, $pod_type));
    }

    /**
     * @return Response
     * @throws MissingNameException
     */
    public function delete(): Response
    {
        $this->validateName();

        return $this->connector->send(new Index\Delete($this->name));
    }
}