<?php

/*
 * This file is part of the CleentfaarCIBundle package.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cleentfaar\Bundle\CIBundle\DataCollector;

use Cleentfaar\Bundle\CIBundle\ConfigLoader\GitConfigLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TravisDataCollector extends BaseDataCollector
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var \Cleentfaar\Bundle\CIBundle\Configloader\GitConfigloader
     */
    private $configLoader;

    /**
     * @param array $config
     * @param string $pathToGitConfig
     */
    public function __construct(array $config, GitConfigLoader $configLoader)
    {
        $this->config = $config;
        $this->configLoader = $configLoader;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param \Exception $exception
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $repositorySlug = $this->configLoader->retrieveRepositorySlug();
        $branch = $this->configLoader->retrieveBranch();
        $this->data['travis_url'] = sprintf('https://travis-ci.org/%s', $repositorySlug);
        foreach (array_keys($this->config['shields']) as $shield) {
            switch ($shield) {
                case 'build':
                    $this->data['build_shield_url'] = sprintf(
                        'https://travis-ci.org/%s.png?branch=%s',
                        $repositorySlug,
                        $branch
                    );
                    break;
            }
        }
    }

    /**
     * @return string
     */
    public function getTravisUrl()
    {
        return $this->data['travis_url'];
    }

    /**
     * @return string
     */
    public function getBuildShieldUrl()
    {
        return $this->data['build_shield_url'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'travis';
    }
}
