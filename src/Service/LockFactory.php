<?php
declare(strict_types=1);

namespace Invertus\Lock\Service;

use Symfony\Component\Lock\Factory as SymfonyFactoryV3;
use Symfony\Component\Lock\LockFactory as SymfonyFactoryV4;

class LockFactory
{
    public function create(string $resourcePath): LockInterface
    {
        if (class_exists(SymfonyFactoryV4::class)) {
            // Symfony 4.4+
            return new LockV4($resourcePath);
        }

        if (class_exists(SymfonyFactoryV3::class)) {
            // Symfony 3.4+
            return new LockV3($resourcePath);
        }

        // Symfony 2.8+
        return new LockV2($resourcePath);
    }
}
