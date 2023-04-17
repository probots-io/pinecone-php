<?php

namespace Probots\Pinecone\Resources;

use Saloon\Contracts\Connector;

class Resource
{
    /**
     * @param Connector $connector
     */
    public function __construct(protected Connector $connector)
    {
        //
    }
}