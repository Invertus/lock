<?php

namespace Invertus\Lock\Exception;

use Exception;

class CouldNotHandleLocking extends Exception
{
    public static function lockExists(): self
    {
        return new self('Lock exists');
    }

    public static function lockOnAcquireIsMissing(): self
    {
        return new self('Lock on acquire is missing');
    }

    public static function lockOnReleaseIsMissing(): self
    {
        return new self('Lock on release is missing');
    }
}