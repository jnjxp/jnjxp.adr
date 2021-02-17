<?php

declare(strict_types=1);

namespace Jnjxp\Adr;

use Interop\Container\ServiceProviderInterface;

class AdrServiceProvider implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            Process\ActionHandler::class         => AdrFactory::class,
            Resolve\ResolverInterface::class     => AdrFactory::class,
            Respond\Responder::class             => AdrFactory::class,
            Action\ActionFactoryInterface::class => AdrFactory::class
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
