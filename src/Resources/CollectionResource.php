<?php

namespace Probots\Pinecone\Resources;

use Exception;
use Probots\Pinecone\Requests\Collections;
use Saloon\Contracts\Connector;
use Saloon\Contracts\Response;

class CollectionResource extends Resource
{
    public function __construct(protected Connector $connector, protected ?string $name)
    {
        parent::__construct($connector);
    }

    private function validateName()
    {
        if ($this->name === null) {
            throw new Exception('Collection name is required');
        }
    }

    public function create(string $name, string $source): Response
    {
        return $this->connector->send(new Collections\Create($name, $source));
    }

    public function describe(): Response
    {
        $this->validateName();

        return $this->connector->send(new Collections\Describe($this->name));
    }

    public function list(): Response
    {
        return $this->connector->send(new Collections\All());
    }

    public function delete(): Response
    {
        $this->validateName();

        return $this->connector->send(new Collections\Delete($this->name));
    }
}