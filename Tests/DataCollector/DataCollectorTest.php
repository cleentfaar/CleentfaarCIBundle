<?php

/*
 * This file is part of the CleentfaarCIBundle package.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cleentfaar\Bundle\CIBundle\Tests\DataCollector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class DataCollectorTest extends WebTestCase
{
    protected function getPathToGoodConfig()
    {
        return __DIR__ . '/../config.good';
    }

    protected function getPathToBadConfig()
    {
        return __DIR__ . '/../config.bad';
    }
}