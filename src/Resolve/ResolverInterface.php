<?php

declare(strict_types = 1);

namespace Jnjxp\Adr\Resolve;

interface ResolverInterface
{
    public function responder($spec) : callable;

    public function domain($spec) : ?callable;

    public function input($spec) : ?callable;
}
