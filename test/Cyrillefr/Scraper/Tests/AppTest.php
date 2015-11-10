<?php

    namespace Cyrillefr\Scraper\Tests;

    use PHPUnit_Framework_TestCase;

    class AppTest extends PHPUnit_Framework_TestCase {

        
        //PHP Version must be <5.5 and >5
        public function testPHPVersionInferiorTo55()
        {
            $this->assertGreaterThan(phpversion(), 5.5);
        }

        public function testPHPVersionSuperiorTo55()
        {
            $this->assertLessThan(phpversion(), 5);
        }        


        public function testConfFileExists()
        {
            $this->assertFileExists('scrap.ini');
        }


    }