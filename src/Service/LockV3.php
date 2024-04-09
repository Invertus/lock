<?php
declare(strict_types=1);

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

    public function __construct(string $resourcePath)
    {
        $this->lockFactory = new Factory(new FlockStore($resourcePath));
    }

    public function exists(): bool
    {
        return !empty($this->lock);
    }

    public function create(string $resource, int $ttl, bool $autoRelease): void
    {
        $this->lock = $this->lockFactory->createLock($resource, $ttl, $autoRelease);
    }

    public function acquire(bool $blocking): bool
    {
        return $this->lock->acquire($blocking);
    }

    public function release(): void
    {
        $this->lock->release();

        $this->lock = null;
    }
}
