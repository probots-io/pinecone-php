<?php

namespace Probots\Pinecone\Resources;


use Probots\Pinecone\Client;

class DataResource extends Resource
{
    public function __construct(protected Client $connector)
    {
        parent::__construct($connector);
    }

    public function vectors(): VectorResource
    {
        return new VectorResource($this->connector);
    }

}
