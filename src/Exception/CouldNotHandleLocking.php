<?php

namespace Invertus\Lock\Exception;

use Exception;

class CouldNotHandleLocking extends Exception
{
    /**
     * @return CouldNotHandleLocking
     */
    public static function lockExists()
    {
        return new self('Lock exists');
    }

    /**
     * @return CouldNotHandleLocking
     */
    public static function lockOnAcquireIsMissing()
    {
        return new self('Lock on acquire is missing');
    }

    /**
     * @return CouldNotHandleLocking
     */
    public static function lockOnReleaseIsMissing()
    {
        return new self('Lock on release is missing');
    }
}