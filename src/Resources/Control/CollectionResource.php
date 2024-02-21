<?php

namespace Probots\Pinecone\Resources;

use Probots\Pinecone\Client;
use Probots\Pinecone\Requests\Collections;
use Saloon\Http\Response;

class CollectionResource extends Resource
{
    public function __construct(protected Client $connector)
    {
        parent::__construct($connector);
    }

    public function create(string $name, string $source): Response
    {
        return $this->connector->send(new Collections\CreateCollection(
            name: $name,
            source: $source
        ));
    }

    public function describe(string $name): Response
    {
        return $this->connector->send(new Collections\DescribeCollection(
            name: $name
        ));
    }

    public function list(): Response
    {
        return $this->connector->send(new Collections\ListCollections());
    }

    public function delete(string $name): Response
    {
        return $this->connector->send(new Collections\DeleteCollection(
            name: $name
        ));
    }
}
