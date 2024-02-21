<?php

namespace Probots\Pinecone\Resources;

use Probots\Pinecone\Client;

class ControlResource extends Resource
{
    public function __construct(protected Client $connector)
    {
        parent::__construct($connector);
    }

    public function index(): IndexResource
    {
        return new IndexResource($this->connector);
    }

    public function collections(): CollectionResource
    {
        return new CollectionResource($this->connector);
    }


}
