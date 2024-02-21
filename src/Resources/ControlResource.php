<?php

namespace Probots\Pinecone\Resources;

use Probots\Pinecone\Client;

class ControlResource extends Resource
{
    public function __construct(protected Client $connector)
    {
        parent::__construct($connector);
    }

    public function index(?string $name = null): Control\IndexResource
    {
        return new Control\IndexResource($this->connector, $name);
    }

    public function collection(?string $name = null): Control\CollectionResource
    {
        return new Control\CollectionResource($this->connector, $name);
    }


}
