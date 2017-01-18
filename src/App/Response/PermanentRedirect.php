<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that makes permanent redirect
 */
class PermanentRedirect extends \BearFramework\App\Response
{

    /**
     * The constructor
     * 
     * @param string $url The redirect url
     */
    public function __construct(string $url)
    {
        parent::__construct('');
        $this->statusCode = 301;
        $this->headers->set(new Header('Content-Type', 'text/plain'));
        $this->headers->set(new Header('Location', $url));
    }

}
