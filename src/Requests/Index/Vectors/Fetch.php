<?php

namespace Probots\Pinecone\Requests\Index\Vectors;

use GuzzleHttp\Psr7\Query;
use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\RequestProperties\HasQuery;

/**
 * @link https://docs.pinecone.io/reference/fetch
 *
 * @param array $index
 * @param array $ids
 * @param string|null $namespace
 *
 * @response
 *
 *
 * @error_response
 * object
 * code | integer
 * message | string
 * details | array of objects
 *   typeUrl | string
 *   value | string
 */
class Fetch extends Request implements HasBody
{
    use HasJsonBody, HasQuery;

    /**
     * @var Method
     */
    protected Method $method = Method::GET;

    /**
     * @param array $index
     * @param array $ids
     * @param string|null $namespace
     */
    public function __construct(
        protected array   $index,
        protected array   $ids,
        protected ?string $namespace = null,
    ) {}

    /**
     * @param $request
     * @return \GuzzleHttp\Psr7\Request
     *
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

    /**
     * @return array|mixed[]
     */
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

//        dd(\GuzzleHttp\Psr7\Query::build(["ids" => $this->ids]));

        return $payload;
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return 'https://' . $this->index['status']['host'] . '/vectors/fetch';
    }

    /**
     * @param Response $response
     * @return bool|null
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }
}