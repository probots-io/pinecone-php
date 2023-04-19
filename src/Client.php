<?php

namespace Probots\Pinecone;

use Probots\Pinecone\Contracts\ClientContract;
use Probots\Pinecone\Resources\CollectionResource;
use Probots\Pinecone\Resources\IndexResource;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class Client extends Connector implements ClientContract
{
    use AcceptsJson, AlwaysThrowOnErrors;

    protected ?string $response = Response::class;

    /**
     * @param string $apiKey
     * @param string $environment
     */
    public function __construct(
        public string $apiKey,
        public string $environment,
    )
    {
        //
    }

    /**
     * @return string
     */
    public function resolveBaseUrl(): string
    {
        return 'https://controller.' . $this->environment . '.pinecone.io';
    }

    /**
     * @param string|null $name
     * @return IndexResource
     */
    public function index(?string $name = null): IndexResource
    {
        return new IndexResource($this, $name);
    }

    /**
     * @param string|null $name
     * @return CollectionResource
     */
    public function collections(?string $name = null): CollectionResource
    {
        return new CollectionResource($this, $name);
    }

    /**
     * @return array
     */
    protected function defaultHeaders(): array
    {
        return [
            'Api-Key' => $this->apiKey,
            'Accept' => 'application/json;',
            'Content-Type' => 'application/json'
        ];
    }

}
