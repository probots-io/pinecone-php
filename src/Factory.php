<?php

namespace Probots\Pinecone;

final class Factory
{
    /**
     * The API key for the requests.
     */
    private ?string $apiKey = null;

    /**
     * The environment for the requests.
     */
    private ?string $environment = null;


    /**
     * Sets the API key for the requests.
     */
    public function withApiKey(string $apiKey): self
    {
        $this->apiKey = trim($apiKey);

        return $this;
    }

    /**
     * Sets environment for the requests.
     */
    public function withEnvironment(?string $environment): self
    {
        $this->environment = $environment;

        return $this;
    }


    /**
     * Creates a new Open AI Client.
     */
    public function make(): Client
    {
        return new Client($this->apiKey, $this->environment);
    }

}