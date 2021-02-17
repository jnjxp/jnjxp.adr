<?php

declare(strict_types=1);

namespace Jnjxp\Adr\Action;

interface ActionInterface
{
    public function getInput();

    public function getDomain();

    public function getResponder();
}
