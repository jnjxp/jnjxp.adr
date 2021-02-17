<?php

declare(strict_types=1);

namespace Jnjxp\Adr\Action;

class ActionFactory implements ActionFactoryInterface
{
    public function newAction($input, $domain, $responder) : ActionInterface
    {
        return new Action($input, $domain, $responder);
    }
}
