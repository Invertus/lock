<?php

namespace Invertus\Lock\Service;

use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\FlockStore;

class LockV4 implements LockInterface
{
    /** @var LockFactory Factory */
    private $lockFactory;
    /** @var ?LockInterface */
    private $lock;

    /**
     * @param string $resourcePath
     */
    public function __construct($resourcePath)
    {
        $this->lockFactory = new LockFactory(new FlockStore($resourcePath));
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
