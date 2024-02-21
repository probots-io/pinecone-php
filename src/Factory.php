<?php

namespace Probots\Pinecone;

final class Factory
{
    /**
     * The API key for the requests.
     */
    private ?string $apiKey = null;

    /**
     * The host for the Data requests.
     */
    private ?string $host = null;


    /**
     * Sets the API key for the requests.
     */
    public function withApiKey(string $apiKey): self
    {
        $this->apiKey = trim($apiKey);

        return $this;
    }

    /**
     * Sets the index host for Data Operations
     */
    public function withHost(?string $host): self
    {
        $this->host = $host;

        return $this;
    }


    /**
     * Creates a new Open AI Client.
     */
    public function make(): Client
    {
        return new Client($this->apiKey, $this->host);
    }

}