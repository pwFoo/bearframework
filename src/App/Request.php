<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * Provides information about the current request
 * @property-read string $scheme The request scheme
 * @property-read string $host The request hostname
 */
class Request
{

    /**
     * The request method
     * @var string 
     */
    public $method = '';

    /**
     * The base URL of the request
     * @var string 
     */
    public $base = '';

    /**
     * The path of the request. The path parts can be accessed by their indexes.
     * @var App\Request\Path 
     */
    public $path = null;

    /**
     * The query string of the request. The query parts can be accessed by their names.
     * @var App\Request\Query 
     */
    public $query = null;

    /**
     * The constructor
     */
    function __construct()
    {
        $this->path = new \App\Request\Path();
        $this->query = new \App\Request\Query();
    }

    /**
     * Returns the full URL of the request
     * @return string The full URL of the request
     */
    function __toString()
    {
        return $this->base . (string) $this->path;
    }

    function __get($name)
    {
        if ($name === 'scheme' || $name === 'host') {
            $data = parse_url($this->base);
            return isset($data[$name]) ? $data[$name] : null;
        }
    }

    function __set($name, $value)
    {
        if ($name === 'scheme' || $name === 'host') {
            $data = parse_url($this->base);
            $this->base = ($name === 'scheme' ? $value : $data['scheme']) . '://' . ($name === 'host' ? $value : $data['host']) . (isset($data['path']) ? $data['path'] : '');
        }
    }

    function __isset($name)
    {
        return $name === 'scheme' || $name === 'host';
    }

}
