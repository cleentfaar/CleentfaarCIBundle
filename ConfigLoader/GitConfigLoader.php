<?php

/*
 * This file is part of the CleentfaarCIBundle package.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cleentfaar\Bundle\CIBundle\ConfigLoader;

class GitConfigLoader implements ConfigLoaderInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @param string $pathToConfig
     */
    public function __construct($pathToConfig = null)
    {
        if ($pathToConfig !== null) {
            $this->load($pathToConfig);
        }
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function retrieveRepositorySlug()
    {
        try {
            $config = $this->getConfig();
            if (!isset($config['remote origin'])) {
                throw new \Exception("No 'remote origin' was found in the .git/config file");
            }
            $url = $config['remote origin']['url'];
            $repositorySlug = basename(pathinfo($url, PATHINFO_DIRNAME)) . '/' . pathinfo($url, PATHINFO_FILENAME);
            return $repositorySlug;
        } catch (\Exception $e) {
            throw new \Exception("Could not determine repository slug", null, $e);
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function retrieveBranch()
    {
        try {
            $config = $this->getConfig();
            foreach (array_keys($config) as $key) {
                if (substr($key, 0, 7) == 'branch ') {
                    return substr($key, 7);
                }
            }
            throw new \Exception("There is no 'branch ...' entry in the configuration");
        } catch (\Exception $e) {
            throw new \Exception("Could not determine current branch", null, $e);
        }
    }

    /**
     * @param $pathToConfig
     * @return array
     * @throws \Exception
     */
    public function load($pathToConfig)
    {
        try {
            if (!file_exists($pathToConfig)) {
                throw new \Exception(sprintf("Path to GIT configuration file does not exist: %s", $pathToConfig));
            }
            if (!isset($this->config)) {
                $gitConfig = parse_ini_file($pathToConfig, true);
                if (!is_array($gitConfig)) {
                    throw new \Exception("Failed to access GIT configuration file in %s", $pathToConfig);
                }
                $this->config = $gitConfig;
            }
            return $this->config;
        } catch (\Exception $e) {
            throw new \Exception("Failed to load configuration", null, $e);
        }
    }
}
