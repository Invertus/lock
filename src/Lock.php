<?php

namespace Invertus\Lock;

use Invertus\Lock\Config\Config;
use Invertus\Lock\Exception\CouldNotHandleLocking;
use Invertus\Lock\Service\LockFactory;
use Invertus\Lock\Service\LockInterface;

class Lock
{
    /** @var LockInterface */
    private $lock;

    /**
     * @param string $resourcePath
     */
    public function __construct($resourcePath = null)
    {
        $lockFactory = new LockFactory();
        $this->lock = $lockFactory->create($resourcePath);
    }

    /**
     * @param string $resource
     * @param int $ttl
     * @param bool $autoRelease
     *
     * @return void
     *
     * @throws CouldNotHandleLocking
     */
    public function create($resource, $ttl = Config::LOCK_TIME_TO_LIVE, $autoRelease = true)
    {
        if ($this->lock->exists()) {
            throw CouldNotHandleLocking::lockExists();
        }

        $this->lock->create($resource, $ttl, $autoRelease);
    }

    /**
     * @param bool $blocking
     *
     * @return bool
     *
     * @throws CouldNotHandleLocking
     */
    public function acquire($blocking = false)
    {
        if (!$this->lock->exists()) {
            throw CouldNotHandleLocking::lockOnAcquireIsMissing();
        }

        return $this->lock->acquire($blocking);
    }

    /**
     * @return void
     *
     * @throws CouldNotHandleLocking
     */
    public function release()
    {
        if (!$this->lock->exists()) {
            throw CouldNotHandleLocking::lockOnReleaseIsMissing();
        }

        $this->lock->release();
    }

    public function __destruct()
    {
        try {
            $this->release();
        } catch (CouldNotHandleLocking $exception) {
            return;
        }
    }
}
