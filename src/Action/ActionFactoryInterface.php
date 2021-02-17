<?php

declare(strict_types=1);

namespace Jnjxp\Adr\Action;

interface ActionFactoryInterface
{
    public function newAction($input, $domain, $responder) : ActionInterface;
}
