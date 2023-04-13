<?php

namespace Probots\Pinecone;

use Probots\Pinecone\Resources\CollectionResource;
use Probots\Pinecone\Resources\IndexResource;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class Client extends Connector
{
    use AcceptsJson;

    private $index = null;

    public function __construct(
        public string $apiKey,
        public string $environment,
    )
    {
        //
    }

    /**
     * The Base URL of the API
     *
     * @return string
     */
    public function resolveBaseUrl(): string
    {
        return 'https://controller.' . $this->environment . '.pinecone.io';
    }

    public function index(?string $name = null): IndexResource
    {
        return new IndexResource($this, $name);
    }

    public function collections(?string $name = null): CollectionResource
    {
        return new CollectionResource($this, $name);
    }

    /**
     * Default headers for every request
     *
     * @return string[]
     */
    protected function defaultHeaders(): array
    {
        return [
            'Api-Key' => $this->apiKey,
            'Accept' => 'application/json;',
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * Default HTTP client options
     *
     * @return string[]
     */
    protected function defaultConfig(): array
    {
        return [];
    }

}
