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

use Cleentfaar\Bundle\CIBundle\ConfigLoader\GitConfigLoader;
use Cleentfaar\Bundle\CIBundle\DataCollector\TravisDataCollector;
use Cleentfaar\Bundle\CIBundle\Test\ConfigTest;

class TravisDataCollectorTest extends ConfigTest
{
    public function testCollect()
    {
        $thrownException = false;
        try {
            $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
            $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');

            $gitConfigLoader = new GitConfigLoader($this->getPathToGoodConfig());
            $dataCollector = new TravisDataCollector($this->getTravisConfig(), $gitConfigLoader);

            $dataCollector->collect($request, $response);
        } catch (\Exception $e) {
            $thrownException = true;
        }
        $this->assertFalse($thrownException);
    }

    public function testGetBuildShieldUrl()
    {
        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
        $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');

        $gitConfigLoader = new GitConfigLoader($this->getPathToGoodConfig());
        $dataCollector = new TravisDataCollector($this->getTravisConfig(), $gitConfigLoader);

        $dataCollector->collect($request, $response);
        $buildShieldUrl = $dataCollector->getBuildShieldUrl();
        $this->assertEquals('string', gettype($buildShieldUrl));
    }

    public function testGetTravisUrl()
    {
        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
        $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');

        $gitConfigLoader = new GitConfigLoader($this->getPathToGoodConfig());
        $dataCollector = new TravisDataCollector($this->getTravisConfig(), $gitConfigLoader);

        $dataCollector->collect($request, $response);
        $travisUrl = $dataCollector->getTravisUrl();
        $this->assertEquals('string', gettype($travisUrl));
    }

    public function testBadConfig()
    {
        $thrownException = false;
        try {
            $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
            $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');
            $gitConfigLoader = new GitConfigLoader($this->getPathToBadConfig());
            $dataCollector = new TravisDataCollector($this->getTravisConfig(), $gitConfigLoader);
            $dataCollector->collect($request, $response);
        } catch (\Exception $e) {
            $thrownException = true;
        }
        $this->assertTrue($thrownException);
    }

    public function testGoodConfig()
    {
        $thrownException = false;
        try {
            $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
            $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');
            $gitConfigLoader = new GitConfigLoader($this->getPathToGoodConfig());
            $dataCollector = new TravisDataCollector($this->getTravisConfig(), $gitConfigLoader);
            $dataCollector->collect($request, $response);
        } catch (\Exception $e) {
            $thrownException = true;
        }
        $this->assertFalse($thrownException);
    }

    private function getTravisConfig()
    {
        return array(
            'enabled' => true,
            'shields' => array(
                'build' => array(
                    'enabled' => true
                )
            )
        );
    }
}
