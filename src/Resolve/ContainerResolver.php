<?php

declare(strict_types = 1);

namespace Jnjxp\Adr\Resolve;

use Psr\Container\ContainerInterface;

class ContainerResolver extends AbstractResolver
{
    protected $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function resolve($spec) : ?callable
    {
        if (! $spec) {
            return null;
        }

        if (! $this->container) {
            return $spec;
        }

        if (is_string($spec)) {
            return $this->container->get($spec);
        }

        if (is_array($spec) && is_string($spec[0])) {
            $spec[0] = $this->container->get($spec[0]);
        }

        return $spec;
    }
}
