<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * Provides information about the addon location and utility functions
 */
class AddonContext extends \App\Context
{

    /**
     * The constructor
     * @param string $dir The directory where the current addond is located 
     * @throws \InvalidArgumentException
     */
    function __construct($dir)
    {
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('');
        }
        parent::__construct($dir);
    }

    /**
     * Returns the options set for the current addon
     * @throws \Exception
     * @return array The options set for the current addon
     */
    function getOptions()
    {
        $app = &\App::$instance;
        if ($app->config->addonsDir === null) {
            throw new \Exception('Config option addonsDir not set');
        }
        $addonID = rtrim(str_replace($app->config->addonsDir, '', $this->dir), '/');
        return $app->addons->getOptions($addonID);
    }

}
