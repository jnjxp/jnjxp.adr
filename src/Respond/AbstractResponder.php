<?php

declare(strict_types=1);

namespace Jnjxp\Adr\Respond;

use Fig\Http\Message\StatusCodeInterface;
use PayloadInterop\DomainPayload;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

abstract class AbstractResponder implements ResponderAcceptsInterface, StatusCodeInterface
{
    protected $responseFactory;

    protected $payload;
    protected $request;
    protected $response;

    public static function accepts() : array
    {
        return ['application/json'];
    }

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(
        ServerRequestInterface $request,
        DomainPayload $payload = null
    ) : ResponseInterface {
        $this->request  = $request;
        $this->payload  = $payload;
        $this->response = $this->responseFactory->createResponse();
        $this->init();
        $method = $this->getMethod();
        $this->$method();
        return $this->response;
    }

    protected function init() : void
    {
    }

    protected function getMethod() : string
    {
        if (! $this->payload) {
            return 'noContent';
        }

        $method = str_replace('_', '', strtolower($this->payload->getStatus()));
        return method_exists($this, $method) ? $method : 'unknown';
    }

    protected function noContent() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_NO_CONTENT);
    }

    protected function unknown() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_INTERNAL_SERVER_ERROR);
        $this->body([
            'error' => 'Unknown domain payload status',
            'status' => $this->payload->getStatus(),
            'result' => $this->payload->getResult()
        ]);
    }

    protected function redirect($uri, int $status = self::STATUS_FOUND) : void
    {
        if (! is_string($uri) && ! $uri instanceof UriInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Uri provided to %s MUST be a string or Psr\Http\Message\UriInterface instance; received "%s"',
                __CLASS__,
                (is_object($uri) ? get_class($uri) : gettype($uri))
            ));
        }
        $this->response = $this->response->withStatus($status);
        $this->response = $this->response->withHeader('Location', $uri);
    }

    protected function body($data) : void
    {
        $this->jsonBody($data);
    }

    protected function jsonBody($data) : void
    {
        if (isset($data)) {
            $this->response = $this->response->withHeader('Content-Type', 'application/json');
            $this->response->getBody()->write(json_encode($data));
        }
    }
}
