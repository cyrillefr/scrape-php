<?php

    namespace Cyrillefr\Scraper;

    use Cyrillefr\Scraper\CURLService;

    Class Content
    {


        private $CURLService;
        private $url;

       
        public function __construct($url)
        {
            $this->url = $url;
            $this->CURLService = new $CURLService();
        }


        public function getStringContent(){
            return $this->CURLService->http_get($this->url);
        }

    }