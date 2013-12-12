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

use Cleentfaar\Bundle\CIBundle\Configloader\GitConfigloader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ScrutinizerDataCollector extends BaseDataCollector
{
    /**
     * @var \Cleentfaar\Bundle\CIBundle\Configloader\GitConfigloader
     */
    private $configLoader;

    /**
     * @param array $config
     * @param string $pathToGitConfig
     */
    public function __construct(array $config, GitConfigloader $configLoader)
    {
        $this->data['config'] = $config;
        $this->configLoader = $configLoader;
    }

    public function shieldEnabled($shield)
    {
        return isset($this->data['config']['shields'][$shield]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param \Exception $exception
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $repositorySlug = $this->configLoader->retrieveRepositorySlug();
        $this->data['scrutinizer_url'] = sprintf('https://scrutinizer-ci.com/g/%s/', $repositorySlug);
        foreach ($this->data['config']['shields'] as $shield => $shieldConfig) {
            if (!array_key_exists('hash', $shieldConfig)) {
                throw new \Exception(sprintf("No hash set for shield %s", $shield));
            }
            switch ($shield) {
                case 'quality':
                    $this->data['quality_shield_url'] = sprintf(
                        'https://scrutinizer-ci.com/g/%s/badges/quality-score.png?s=%s',
                        $repositorySlug,
                        $shieldConfig['hash']
                    );
                    break;
                case 'coverage':
                    $this->data['coverage_shield_url'] = sprintf(
                        'https://scrutinizer-ci.com/g/%s/badges/coverage.png?s=%s',
                        $repositorySlug,
                        $shieldConfig['hash']
                    );
                    break;
            }
        }
    }

    /**
     * @return string
     */
    public function getScrutinizerUrl()
    {
        return $this->data['scrutinizer_url'];
    }

    /**
     * @return string
     */
    public function getQualityShieldUrl()
    {
        return $this->data['quality_shield_url'];
    }

    public function getCoverageShieldUrl()
    {
        return $this->data['coverage_shield_url'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'scrutinizer';
    }
}
