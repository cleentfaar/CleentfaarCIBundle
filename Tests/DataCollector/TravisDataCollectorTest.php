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
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class TravisDataCollectorTest extends WebTestCase
{
/*    public function testCollect()
    {
        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
        $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');

        $gitConfigLoader = $this->getMock('\Cleentfaar\Bundle\CIBundle\ConfigLoader\GitConfigLoader');
        $mockLoader = $this->getMock('\Cleentfaar\Bundle\CIBundle\DataCollector\TravisDataCollector');

        $mockLoader->expects($this->once())->method('collect')->with($request, $response);
        $this->assertAttributeEquals(
            $gitConfigLoader,
            'configLoader',
            $mockLoader
        );
        $mockLoader->collect($request, $response);
    }*/

    /**
     * @return string
     */
    public function testGetTravisUrl()
    {
        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
        $response = $this->getMock('\Symfony\Component\HttpFoundation\Response');

        $gitConfigLoader = new GitConfigLoader($this->getPathToBadConfig());
        $dataCollector = new TravisDataCollector($this->getTravisConfig(), $gitConfigLoader);

        $dataCollector->collect($request, $response);
        $travisUrl = $dataCollector->getTravisUrl();
        $this->assertEquals('string', gettype($travisUrl));
    }

    /**
     * @return string
     */
    /*public function testGetBuildShieldUrl()
    {
        $mockLoader = $this->getMock('\Cleentfaar\Bundle\CIBundle\DataCollector\TravisDataCollector', array('getBuildShieldUrl'));
        $buildShieldUrl = $mockLoader->getBuildShieldUrl();
        $this->assertEquals('string', gettype($buildShieldUrl));
    }*/

    private function getTravisConfig()
    {
        return array(
            'enabled' => true,
            'shields' => array(
                'build' => true
            )
        );
    }

    private function getPathToGoodConfig()
    {
        return __DIR__ . '/../config.good';
    }

    private function getPathToBadConfig()
    {
        return __DIR__ . '/../config.bad';
    }

    private function getDataLoader()
    {
        return $this->getMock('\Cleentfaar\Bundle\CIBundle\DataCollector\TravisDataCollector');
    }
}
