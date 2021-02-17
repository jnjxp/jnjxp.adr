<?php

declare(strict_types = 1);

namespace Jnjxp\Adr\Process;

use Jnjxp\Adr\Action\ActionInterface;
use Jnjxp\Adr\Resolve\ContainerResolver;
use Jnjxp\Adr\Resolve\ResolverInterface;

class ActionHandler extends AbstractActionHandler
{
    protected $resolve;

    public function __construct(ResolverInterface $resolve = null)
    {
        $this->resolve = $resolve ?? new ContainerResolver();
    }

    protected function getResponder(ActionInterface $action) : callable
    {
        return $this->resolve->responder($action->getResponder());
    }

    protected function getDomain(ActionInterface $action) : ?callable
    {
        return $this->resolve->domain($action->getDomain());
    }

    protected function getInput(ActionInterface $action) : ?callable
    {
        return $this->resolve->input($action->getInput());
    }
}
