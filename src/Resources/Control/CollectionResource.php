<?php

namespace Probots\Pinecone\Resources;

use Probots\Pinecone\Requests\Collections;
use Saloon\Contracts\Connector;
use Saloon\Contracts\Response;

class CollectionResource extends Resource
{
    public function __construct(protected Connector $connector)
    {
        parent::__construct($connector);
    }

    public function create(string $name, string $source): Response
    {
        return $this->connector->send(new Collections\CreateCollection($name, $source));
    }

    public function describe(): Response
    {
        return $this->connector->send(new Collections\DescribeCollection());
    }

    public function list(): Response
    {
        return $this->connector->send(new Collections\ListCollections());
    }

    public function delete(): Response
    {
        return $this->connector->send(new Collections\DeleteCollection());
    }
}
