<?php

namespace Probots\Pinecone\Resources;

use Probots\Pinecone\Requests\Collections;
use Probots\Pinecone\Requests\Exceptions\MissingNameException;
use Saloon\Contracts\Connector;
use Saloon\Contracts\Response;

class CollectionResource extends Resource
{
    /**
     * @param Connector $connector
     * @param string|null $name
     */
    public function __construct(protected Connector $connector, protected ?string $name)
    {
        parent::__construct($connector);
    }

    /**
     * @return void
     * @throws MissingNameException
     */
    private function validateName()
    {
        if ($this->name === null) {
            throw new MissingNameException('Collection name is required');
        }
    }

    /**
     * @param string $name
     * @param string $source
     * @return Response
     */
    public function create(string $name, string $source): Response
    {
        return $this->connector->send(new Collections\Create($name, $source));
    }


    /**
     * @return Response
     * @throws MissingNameException
     */
    public function describe(): Response
    {
        $this->validateName();

        return $this->connector->send(new Collections\Describe($this->name));
    }

    /**
     * @return Response
     */
    public function list(): Response
    {
        return $this->connector->send(new Collections\All());
    }

    /**
     * @return Response
     * @throws MissingNameException
     */
    public function delete(): Response
    {
        $this->validateName();

        return $this->connector->send(new Collections\Delete($this->name));
    }
}