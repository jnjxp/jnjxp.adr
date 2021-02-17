<?php

declare(strict_types=1);

namespace Jnjxp\Adr\Action;

class Action implements ActionInterface
{
    private $input;

    private $domain;

    private $responder;

    public function __construct($input, $domain, $responder)
    {
        $this->input = $input;
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getResponder()
    {
        return $this->responder;
    }
}
