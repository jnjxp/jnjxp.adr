<?php

declare(strict_types=1);

namespace Jnjxp\Adr\Input;

use Psr\Http\Message\ServerRequestInterface;
use Fig\Http\Message\RequestMethodInterface;

class Input implements RequestMethodInterface
{
    public function __invoke(ServerRequestInterface $request) : array
    {
        return [
            array_replace(
                (array) $request->getQueryParams(),
                (array) $request->getParsedBody(),
                (array) $request->getUploadedFiles(),
                (array) $request->getCookieParams(),
                (array) $request->getAttributes()
            )
        ];
    }

    public function __call($name, array $args) : array
    {
        return [$this->get($name, $args[0])];
    }

    protected function get(string $attr, ServerRequestInterface $request)
    {
        return $request->getAttribute($attr);
    }

    public function slug(ServerRequestInterface $request) : array
    {
        return [$request->getAttribute('slug')];
    }

    public function page(ServerRequestInterface $request) : array
    {
        return [$this->getPage($request)];
    }

    public function body(ServerRequestInterface $request) : array
    {
        return [$request->getParsedBody()];
    }

    public function edit(ServerRequestInterface $request) : array
    {
        $params = [(int) $request->getAttribute('identity')];
        $params[] = $request->getMethod() == self::METHOD_POST
            ? $request->getParsedBody()
            : null;
        return $params;
    }

    private function getPage(ServerRequestInterface $request) : int
    {
        $query = $request->getQueryParams();
        return isset($query['page']) ? (int) $query['page'] : 1;
    }
}
