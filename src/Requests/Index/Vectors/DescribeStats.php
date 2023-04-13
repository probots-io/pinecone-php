<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DescribeStats extends Request
{


    protected Method $method = Method::POST;

    public function __construct(
        protected array $index,
        protected array $filter = []
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return 'https://' . $this->index['status']['host'] . '/describe_index_stats';
    }

    protected function defaultBody(): array
    {
        $payload = [];

        if (count($this->filter) > 0) {
            $payload['filter'] = $this->filter;
        }
        return $payload;
    }
}
