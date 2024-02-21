<?php

namespace Probots\Pinecone\Resources;

use Probots\Pinecone\Client;

class Resource
{
    public function __construct(protected Client $connector)
    {
        //
    }
}