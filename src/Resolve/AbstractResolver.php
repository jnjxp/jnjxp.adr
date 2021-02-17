<?php

declare(strict_types = 1);

namespace Jnjxp\Adr\Resolve;

abstract class AbstractResolver implements ResolverInterface
{
    public function responder($spec) : callable
    {
        return $this->resolve($spec);
    }

    public function domain($spec) : ?callable
    {
        return $this->resolve($spec);
    }

    public function input($spec) : ?callable
    {
        return $this->resolve($spec);
    }

    abstract protected function resolve($spec) : ?callable;
}
