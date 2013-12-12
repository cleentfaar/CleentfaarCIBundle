<?php

/*
 * This file is part of the CleentfaarCIBundle package.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cleentfaar\Bundle\CIBundle\Tests\ConfigLoader;

use Cleentfaar\Bundle\CIBundle\ConfigLoader\GitConfigLoader;
use Cleentfaar\Bundle\CIBundle\Test\ConfigTest;

class GitConfigLoaderTest extends ConfigTest
{
    /**
     * @param string $pathToConfig
     */
    public function testConstruct()
    {
        $nonExistingPath = '/some/path/'.uniqid();
        try {
            $gitConfigLoader = new GitConfigLoader($nonExistingPath);
        } catch (\Exception $e) {
            $thrownException = true;
        }
        $this->assertTrue($thrownException);

        $thrownException = false;
        $existingPath = $this->getPathToGoodConfig();
        try {
            $gitConfigLoader = new GitConfigLoader($existingPath);
        } catch (\Exception $e) {
            $thrownException = true;
        }
        $this->assertFalse($thrownException);
    }

    /**
     * @return array
     */
    public function testGetConfig()
    {
        $existingPath = $this->getPathToGoodConfig();
        $gitConfigLoader = new GitConfigLoader($existingPath);
        $config = $gitConfigLoader->getConfig();
        $this->assertEquals('array', gettype($config));
        $this->assertNotEmpty($config);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function testRetrieveRepositorySlug()
    {
        $existingPath = $this->getPathToGoodConfig();
        $gitConfigLoader = new GitConfigLoader($existingPath);
        $slug = $gitConfigLoader->retrieveRepositorySlug();
        $this->assertEquals('string', gettype($slug));
        $this->assertNotEmpty($slug);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function testRetrieveBranch()
    {
        $existingPath = $this->getPathToGoodConfig();
        $gitConfigLoader = new GitConfigLoader($existingPath);
        $branch = $gitConfigLoader->retrieveBranch();
        $this->assertEquals('string', gettype($branch));
        $this->assertNotEmpty($branch);
    }

    /**
     * @param $pathToConfig
     * @return array
     * @throws \Exception
     */
    public function testLoad()
    {
        $existingPath = $this->getPathToGoodConfig();
        $gitConfigLoader = new GitConfigLoader();
        $config = $gitConfigLoader->load($existingPath);
        $this->assertEquals('array', gettype($config));
        $this->assertNotEmpty($config);
    }
}
