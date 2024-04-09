<?php
declare(strict_types=1);

namespace Invertus\Lock\Service;

interface LockInterface
{
    public function exists(): bool;

    public function create(string $resource, int $ttl, bool $autoRelease): void;

    public function acquire(bool $blocking): bool;

    public function release(): void;
}
