<?php

namespace Invertus\Lock\Service;

use Symfony\Component\Filesystem\LockHandler;

class LockV2 implements LockInterface
{
    /** @var ?LockHandler */
    private $lock;

    /**
     * @var string
     */
    private $resourcePath;

    /**
     * @param string $resourcePath
     */
    public function __construct($resourcePath)
    {
        $this->resourcePath = $resourcePath;
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
        $this->lock = new LockHandler($resource, $this->resourcePath);
    }

    /**
     * @param bool $blocking
     *
     * @return bool
     */
    public function acquire($blocking)
    {
        return $this->lock->lock($blocking);
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
