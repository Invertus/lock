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

    public function __construct()
    {
        $lockFactory = new LockFactory();
        $this->lock = $lockFactory->create();
    }

    /**
     * @throws CouldNotHandleLocking
     */
    public function create(string $resource, int $ttl = Config::LOCK_TIME_TO_LIVE, bool $autoRelease = true): void
    {
        if ($this->lock->exists()) {
            throw CouldNotHandleLocking::lockExists();
        }

        $this->lock->create($resource, $ttl, $autoRelease);
    }

    /**
     * @throws CouldNotHandleLocking
     */
    public function acquire(bool $blocking = false): bool
    {
        if (!$this->lock->exists()) {
            throw CouldNotHandleLocking::lockOnAcquireIsMissing();
        }

        return $this->lock->acquire($blocking);
    }

    /**
     * @throws CouldNotHandleLocking
     */
    public function release(): void
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
