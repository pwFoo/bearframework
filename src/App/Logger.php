<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * Provides logging functionlity
 */
class Logger
{

    /**
     * Appends data to the file specified. The file will be created if not exists.
     * 
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\Config\InvalidOptionException
     * @return boolean TRUE if data is suceessfully written. FALSE otherwise.
     */
    public function log(string $level, string $message, array $context = [])
    {
        $app = App::get();
        $level = trim((string) $level);
        if (strlen($level) === 0) {
            throw new \InvalidArgumentException('The level argument must not be empty');
        }
        if ($app->config->logsDir === null) {
            throw new App\Config\InvalidOptionException('Config option logsDir is not set');
        }

        $filename = $level . '-' . date('Y-m-d') . '.log';
        try {
            $microtime = microtime(true);
            $microtimeParts = explode('.', $microtime);
            $logData = date('H:i:s', $microtime) . ':' . (isset($microtimeParts[1]) ? $microtimeParts[1] : '0') . "\n" . trim($message) . (empty($context) ? '' : "\n" . trim(print_r($context, true))) . "\n\n";
            $fileHandler = fopen($app->config->logsDir . DIRECTORY_SEPARATOR . $filename, 'ab');
            $result = fwrite($fileHandler, $logData);
            fclose($fileHandler);
            return is_int($result);
        } catch (\Exception $e) {
            return false;
        }
    }

}
