<?php

    namespace Cyrillefr\Scraper\Tests;

    use Cyrillefr\Scraper\CURLService;
    use PHPUnit_Framework_TestCase;

    class CURLServiceTest extends PHPUnit_Framework_TestCase {

        public function testcURLEnabled()
        {
            $this->assertTrue(function_exists('curl_init'));
        }

    }