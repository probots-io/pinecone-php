<?php

namespace Probots\Pinecone;

use Probots\Pinecone\Contracts\ClientContract;
use Probots\Pinecone\Requests\Data\FetchVectors;
use Probots\Pinecone\Requests\Exceptions\MissingHostException;
use Probots\Pinecone\Resources\ControlResource;
use Probots\Pinecone\Resources\DataResource;
use Psr\Http\Message\RequestInterface;
use Saloon\Http\Connector;
use Saloon\Http\PendingRequest;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class Client extends Connector implements ClientContract
{
    use AcceptsJson, AlwaysThrowOnErrors;

    protected ?string $response = Response::class;

    protected string $baseUrl = 'https://api.pinecone.io';

    public function __construct(
        public string  $apiKey,
        public ?string $indexHost = null,
    ) {}

    // (Temporary) Workaround for https://github.com/probots-io/pinecone-php/issues/3
    public function handlePsrRequest(RequestInterface $request, PendingRequest $pendingRequest): RequestInterface
    {
        return FetchVectors::queryIdsWorkaround($request);
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function control(): ControlResource
    {
        return new ControlResource($this);
    }

    /**
     * @throws MissingHostException
     */
    public function data(): DataResource
    {
        $this->baseUrl = $this->indexHost;

        if (!$this->indexHost) {
            throw new MissingHostException('Index host is missing');
        }

        return new DataResource($this);
    }

    public function setIndexHost(string $indexHost): self
    {
        $this->indexHost = $indexHost;

        return $this;
    }


    protected function defaultHeaders(): array
    {
        return [
            'Api-Key'      => $this->apiKey,
            'Accept'       => 'application/json;',
            'Content-Type' => 'application/json'
        ];
    }

}
