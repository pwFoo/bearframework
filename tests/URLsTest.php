<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class URLsTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testGet()
    {
        $app = $this->getApp();
        $app->request->base = "https://example.com/www";
        $this->assertTrue($app->urls->get('/') === "https://example.com/www/");
        $this->assertTrue($app->urls->get('/products/') === "https://example.com/www/products/");
        $this->assertTrue($app->urls->get('/продукти/') === "https://example.com/www/%D0%BF%D1%80%D0%BE%D0%B4%D1%83%D0%BA%D1%82%D0%B8/");
        $this->assertTrue($app->urls->get('/път1/път2/') === "https://example.com/www/%D0%BF%D1%8A%D1%821/%D0%BF%D1%8A%D1%822/");
    }

}
