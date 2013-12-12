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
use Cleentfaar\Bundle\CIBundle\DataCollector\ScrutinizerDataCollector;
use Cleentfaar\Bundle\CIBundle\Test\ConfigTest;

class ScrutinizerDataCollectorTest extends ConfigTest
{
    public function testCollect()
    {
        $thrownException = false;
        try {
            $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
            $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');

            $gitConfigLoader = new GitConfigLoader($this->getPathToGoodConfig());
            $dataCollector = new ScrutinizerDataCollector($this->getScrutinizerConfig(), $gitConfigLoader);

            $dataCollector->collect($request, $response);
        } catch (\Exception $e) {
            $thrownException = true;
        }
        $this->assertFalse($thrownException);
    }

    public function testGetQualityShieldUrl()
    {
        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
        $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');

        $gitConfigLoader = new GitConfigLoader($this->getPathToGoodConfig());
        $dataCollector = new ScrutinizerDataCollector($this->getScrutinizerConfig(), $gitConfigLoader);

        $dataCollector->collect($request, $response);
        $shieldUrl = $dataCollector->getQualityShieldUrl();
        $this->assertEquals('string', gettype($shieldUrl));
    }

    public function testGetCoverageShieldUrl()
    {
        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
        $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');

        $gitConfigLoader = new GitConfigLoader($this->getPathToGoodConfig());
        $dataCollector = new ScrutinizerDataCollector($this->getScrutinizerConfig(), $gitConfigLoader);

        $dataCollector->collect($request, $response);
        $shieldUrl = $dataCollector->getCoverageShieldUrl();
        $this->assertEquals('string', gettype($shieldUrl));
    }

    public function testGetScrutinizerUrl()
    {
        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
        $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');

        $gitConfigLoader = new GitConfigLoader($this->getPathToGoodConfig());
        $dataCollector = new ScrutinizerDataCollector($this->getScrutinizerConfig(), $gitConfigLoader);

        $dataCollector->collect($request, $response);
        $url = $dataCollector->getScrutinizerUrl();
        $this->assertEquals('string', gettype($url));
    }

    public function testBadConfig()
    {
        $thrownException = false;
        try {
            $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
            $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');
            $gitConfigLoader = new GitConfigLoader($this->getPathToBadConfig());
            $dataCollector = new ScrutinizerDataCollector($this->getScrutinizerConfig(), $gitConfigLoader);
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
            $dataCollector = new ScrutinizerDataCollector($this->getScrutinizerConfig(), $gitConfigLoader);
            $dataCollector->collect($request, $response);
        } catch (\Exception $e) {
            $thrownException = true;
        }
        $this->assertFalse($thrownException);
    }

    private function getScrutinizerConfig()
    {
        return array(
            'enabled' => true,
            'shields' => array(
                'quality' => array(
                    'enabled' => true,
                    'hash' => '123abc',
                ),
                'coverage' => array(
                    'enabled' => true,
                    'hash' => '123abc',
                ),
            )
        );
    }
}
