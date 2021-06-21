<?php

declare(strict_types=1);

namespace Inisiatif\Package\Tracking\Input;

use Inisiatif\Package\Tracking\Request;

abstract class Input
{
    abstract public function request(): Request;
}
