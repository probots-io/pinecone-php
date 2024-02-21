<?php

namespace Probots\Pinecone\Resources\Control;

use Probots\Pinecone\Client;
use Probots\Pinecone\Requests\Control;
use Probots\Pinecone\Resources\Resource;
use Saloon\Http\Response;

class CollectionResource extends Resource
{
    public function __construct(protected Client $connector, protected ?string $name = null)
    {
        parent::__construct($connector);
    }

    public function create(string $source): Response
    {
        return $this->connector->send(new Control\CreateCollection(
            name: $this->name,
            source: $source
        ));
    }

    public function describe(): Response
    {
        return $this->connector->send(new Control\DescribeCollection(
            name: $this->name
        ));
    }

    public function list(): Response
    {
        return $this->connector->send(new Control\ListCollections());
    }

    public function delete(): Response
    {
        return $this->connector->send(new Control\DeleteCollection(
            name: $this->name
        ));
    }
}
