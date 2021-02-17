<?php

declare(strict_types=1);

namespace Jnjxp\Adr;

use Jnjxp\Adr\Action\ActionFactory;
use Jnjxp\Adr\Action\ActionFactoryInterface;
use Jnjxp\Adr\Process\ActionHandler;
use Jnjxp\Adr\Resolve\ContainerResolver;
use Jnjxp\Adr\Resolve\ResolverInterface;
use Jnjxp\Adr\Respond\Responder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class AdrFactory
{
    public function __invoke(ContainerInterface $container, string $name)
    {
        switch ($name) {
            case ActionHandler::class:
                return $this->newActionHandler($container);
                break;
            case ResolverInterface::class:
                return $this->newResolver($container);
                break;
            case Responder::class:
                return $this->newResponder($container);
                break;
            case ActionFactoryInterface::class:
                return $this->newActionFactory($container);
                break;
            default:
                throw new ServiceNotFoundException($name);
                break;
        }
    }

    public function newActionHandler(ContainerInterface $container) : ActionHandler
    {
        return new ActionHandler(
            $container->get(ResolverInterface::Class)
        );
    }

    public function newResolver(ContainerInterface $container) : ResolverInterface
    {
        return new ContainerResolver($container);
    }

    public function newResponder(ContainerInterface $container) : Responder
    {
        return new Responder($container->get(ResponseFactoryInterface::class));
    }

    public function newActionFactory(ContainerInterface $container) : ActionFactoryInterface
    {
        return new ActionFactory();
    }
}
