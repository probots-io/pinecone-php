<?php

namespace Probots\Pinecone\Requests\Data;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * @link https://docs.pinecone.io/reference/describe_index_stats_post
 */
class GetIndexStats extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected array $filter = []
    ) {}

    public function resolveEndpoint(): string
    {
        return '/describe_index_stats';
    }

    protected function defaultBody(): array
    {
        $payload = [];

        if (count($this->filter) > 0) {
            $payload['filter'] = $this->filter;
        }
        return $payload;
    }


    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}
