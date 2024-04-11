<?php

namespace Invertus\Lock\Service;

interface LockInterface
{
    /**
     * @return bool
     */
    public function exists();

    /**
     * @param string $resource
     * @param int $ttl
     * @param bool $autoRelease
     *
     * @return void
     */
    public function create($resource, $ttl, $autoRelease);

    /**
     * @param bool $blocking
     *
     * @return bool
     */
    public function acquire($blocking);

    /**
     * @return void
     */
    public function release();
}
