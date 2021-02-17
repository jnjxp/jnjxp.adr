<?php

declare(strict_types = 1);

namespace Jnjxp\Adr\Process;

use Jnjxp\Adr\Action\ActionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractActionHandler implements MiddlewareInterface, RequestHandlerInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $handler = $this->actionable($request) ? $this : $handler;
        return $handler->handle($request);
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $action = $this->getAction($request);
        return $this->act($request, $action);
    }

    protected function actionable(ServerRequestInterface $request) : bool
    {
        return (bool) $this->getAction($request);
    }

    protected function getAction(ServerRequestInterface $request) : ?ActionInterface
    {
        $action = $request->getAttribute(ActionInterface::class);
        return ($action && $action instanceof ActionInterface) ? $action : null;
    }

    protected function act(ServerRequestInterface $request, ActionInterface $action) : ResponseInterface
    {
        $responder = $this->getResponder($action);

        if (! $responder) {
            throw new \Exception('No Responder!');
        }

        $domain = $this->getDomain($action);

        if (! $domain) {
            return $responder($request);
        }

        $input  = $this->getInput($action);
        $params = $input ? (array) $input($request) : [];

        $payload = call_user_func_array($domain, $params);
        return $responder($request, $payload);
    }

    abstract protected function getResponder(ActionInterface $action) : callable;

    abstract protected function getDomain(ActionInterface $action) : ?callable;

    abstract protected function getInput(ActionInterface $action) : ?callable;
}
