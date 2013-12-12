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

interface ConfigLoaderInterface
{
    /**
     * @return array
     */
    public function getConfig();

    /**
     * @param $pathToConfig
     * @return array
     */
    public function load($pathToConfig);
}
