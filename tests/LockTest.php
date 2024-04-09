<?php
declare(strict_types=1);

namespace Invertus\Lock\Tests;

use Invertus\Lock\Exception\CouldNotHandleLocking;
use Invertus\Lock\Lock;
use PHPUnit\Framework\TestCase;

class LockTest extends TestCase
{
    public function testItSuccessfullyCompletesLockFlow(): void
    {
        $lock = new Lock();

        $lock->create('test-lock-name');

        $this->assertTrue($lock->acquire());

        $lock->release();
    }

    public function testItSuccessfullyLocksResourceFromAnotherProcess(): void
    {
        $lock = new Lock();

        $lock->create('test-lock-name');

        $this->assertTrue($lock->acquire());

        $newLock = new Lock();

        $newLock->create('test-lock-name');

        $this->assertFalse($newLock->acquire());
    }

    public function testItSuccessfullyReleasesLockAndEnablesNextProcess(): void
    {
        $lock = new Lock();

        $lock->create('test-lock-name');

        $this->assertTrue($lock->acquire());

        $lock->release();

        $newLock = new Lock();

        $newLock->create('test-lock-name');

        $this->assertTrue($newLock->acquire());
    }

    public function testItUnsuccessfullyCompletesLockFlowFailedToCreateLockWithMissingLock(): void
    {
        $lock = new Lock();

        $this->expectException(CouldNotHandleLocking::class);

        $lock->create('test-lock-name');
        $lock->create('test-lock-name');
    }

    public function testItUnsuccessfullyCompletesLockFlowFailedToAcquireLockWithMissingLock(): void
    {
        $lock = new Lock();

        $this->expectException(CouldNotHandleLocking::class);

        $lock->acquire();
    }

    public function testItUnsuccessfullyCompletesLockFlowFailedToReleaseLockWithMissingLock(): void
    {
        $lock = new Lock();

        $this->expectException(CouldNotHandleLocking::class);

        $lock->release();
    }
}