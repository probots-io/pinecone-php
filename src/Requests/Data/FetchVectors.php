<?php

namespace Probots\Pinecone\Requests\Data;

use GuzzleHttp\Psr7\Query;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\RequestProperties\HasQuery;

/**
 * @link https://docs.pinecone.io/reference/fetch
 */
class FetchVectors extends Request
{
    use HasQuery;

    protected Method $method = Method::GET;

    public function __construct(
        protected array   $ids,
        protected ?string $namespace = null,
    ) {}

    /**
     * This is a workaround for https://github.com/probots-io/pinecone-php/issues/3
     * It remaps ids[]=1&ids[]=2 to ids=1&ids=2
     */
    public static function queryIdsWorkaround($request): \GuzzleHttp\Psr7\Request
    {
        $requestUri = $request->getUri();

        if ($requestUri->getPath() === '/vectors/fetch') {
            $queryString = $requestUri->getQuery();
            parse_str(urldecode($queryString), $data);

            return $request->withUri($requestUri->withQuery(Query::build($data)));
        }

        return $request;
    }

    protected function defaultQuery(): array
    {
//        $payload = [
//            'ids' => implode(',', $this->ids), // 🙈
//        ];

        $payload = [
            'ids' => $this->ids
        ];

        if ($this->namespace) {
            $payload['namespace'] = $this->namespace;
        }

        return $payload;
    }

    public function resolveEndpoint(): string
    {
        return '/vectors/fetch';
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}