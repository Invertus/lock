<?php
declare(strict_types=1);

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

    public function __construct(string $resourcePath)
    {
        $this->resourcePath = $resourcePath;
    }

    public function exists(): bool
    {
        return !empty($this->lock);
    }

    public function create(string $resource, int $ttl, bool $autoRelease): void
    {
        $this->lock = new LockHandler($resource, $this->resourcePath);
    }

    public function acquire(bool $blocking): bool
    {
        return $this->lock->lock($blocking);
    }

    public function release(): void
    {
        $this->lock->release();

        $this->lock = null;
    }
}
