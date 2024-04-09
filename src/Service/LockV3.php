<?php

namespace Invertus\Lock\Service;

use Symfony\Component\Lock\Factory;
use Symfony\Component\Lock\Store\FlockStore;

/**
 * Symfony 3.4+
 */
class LockV3 implements LockInterface
{
    /** @var Factory Factory */
    private $lockFactory;
    /** @var ?LockInterface */
    private $lock;

    /**
     * @param string $resourcePath
     */
    public function __construct($resourcePath)
    {
        $this->lockFactory = new Factory(new FlockStore($resourcePath));
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return !empty($this->lock);
    }

    /**
     * @param string $resource
     * @param int $ttl
     * @param bool $autoRelease
     *
     * @return void
     */
    public function create($resource, $ttl, $autoRelease)
    {
        $this->lock = $this->lockFactory->createLock($resource, $ttl, $autoRelease);
    }

    /**
     * @param bool $blocking
     *
     * @return bool
     */
    public function acquire($blocking)
    {
        return $this->lock->acquire($blocking);
    }

    /**
     * @return void
     */
    public function release()
    {
        $this->lock->release();

        $this->lock = null;
    }
}
