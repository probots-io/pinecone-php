<?php

namespace Probots\Pinecone\Resources;


use Saloon\Contracts\Connector;

class DataResource extends Resource
{
    public function __construct(protected Connector $connector)
    {
        parent::__construct($connector);
    }

    public function vectors(): VectorResource
    {
        return new VectorResource($this->connector);
    }

}
