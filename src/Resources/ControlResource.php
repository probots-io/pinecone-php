<?php

namespace Probots\Pinecone\Resources;

use Saloon\Contracts\Connector;

class ControlResource extends Resource
{
    /**
     * @param Connector $connector
     * @param string|null $name
     */
    public function __construct(protected Connector $connector)
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
