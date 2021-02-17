<?php

declare(strict_types=1);

namespace Jnjxp\Adr;

use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
