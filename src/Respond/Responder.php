<?php

declare(strict_types=1);

namespace Jnjxp\Adr\Respond;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Fig\Http\Message\StatusCodeInterface;
use PayloadInterop\DomainPayload;

class Responder extends AbstractResponder
{
    protected function accepted() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_ACCEPTED);
        $this->body($this->payload->getResult());
    }

    protected function created() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_CREATED);
        $this->body($this->payload->getResult());
    }

    protected function deleted() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_NO_CONTENT);
        $this->body($this->payload->getResult());
    }

    protected function error() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_INTERNAL_SERVER_ERROR);
        $this->body($this->payload->getResult());
    }

    protected function failure() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_BAD_REQUEST);
        $this->body($this->payload->getResult());
    }

    protected function found() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_OK);
        $this->body($this->payload->getResult());
    }

    protected function notAuthenticated() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_UNAUTHORIZED);
        $this->body($this->payload->getResult());
    }

    protected function notAuthorized() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_FORBIDDEN);
        $this->body($this->payload->getResult());
    }

    protected function notFound() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_NOT_FOUND);
        $this->body($this->payload->getResult());
    }

    protected function notValid() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_UNPROCESSABLE_ENTITY);
        $this->body($this->payload->getResult());
    }

    protected function processing() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_NON_AUTHORITATIVE_INFORMATION);
        $this->body($this->payload->getResult());
    }

    protected function success() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_OK);
        $this->body($this->payload->getResult());
    }

    protected function updated() : void
    {
        $this->response = $this->response->withStatus(self::STATUS_SEE_OTHER);
        $this->body($this->payload->getResult());
    }
}
