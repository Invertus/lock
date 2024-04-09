<?php

namespace Invertus\Lock\Tests;

use Invertus\Lock\Exception\CouldNotHandleLocking;
use Invertus\Lock\Lock;
use PHPUnit\Framework\TestCase;

class LockTest extends TestCase
{
    public function testItSuccessfullyCompletesLockFlow()
    {
        $lock = new Lock();

        $lock->create('test-lock-name');

        $this->assertTrue($lock->acquire());

        $lock->release();
    }

    public function testItSuccessfullyLocksResourceFromAnotherProcess()
    {
        $lock = new Lock();

        $lock->create('test-lock-name');

        $this->assertTrue($lock->acquire());

        $newLock = new Lock();

        $newLock->create('test-lock-name');

        $this->assertFalse($newLock->acquire());
    }

    public function testItSuccessfullyReleasesLockAndEnablesNextProcess()
    {
        $lock = new Lock();

        $lock->create('test-lock-name');

        $this->assertTrue($lock->acquire());

        $lock->release();

        $newLock = new Lock();

        $newLock->create('test-lock-name');

        $this->assertTrue($newLock->acquire());
    }

    public function testItUnsuccessfullyCompletesLockFlowFailedToCreateLockWithMissingLock()
    {
        $lock = new Lock();

        $this->expectException(CouldNotHandleLocking::class);

        $lock->create('test-lock-name');
        $lock->create('test-lock-name');
    }

    public function testItUnsuccessfullyCompletesLockFlowFailedToAcquireLockWithMissingLock()
    {
        $lock = new Lock();

        $this->expectException(CouldNotHandleLocking::class);

        $lock->acquire();
    }

    public function testItUnsuccessfullyCompletesLockFlowFailedToReleaseLockWithMissingLock()
    {
        $lock = new Lock();

        $this->expectException(CouldNotHandleLocking::class);

        $lock->release();
    }
}