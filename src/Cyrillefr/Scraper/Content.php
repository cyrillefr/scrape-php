<?php

    namespace Cyrillefr\Scraper;

    use Cyrillefr\Scraper\CURLService;


    Class Content
    {


        private $CURLService;
        private $url;
        private $stringContent;

       
        public function __construct($url)
        {
            $this->url = $url;
            $this->CURLService = new CURLService();
        }


        public function getStringContent()
        {
            try
            {
                $this->stringContent = $this->CURLService->http_get($this->url); 
            }
            catch (\Exception $e)
            {
               $this->stringContent = '';
               throw $e;
            }
            
            //finally    
            return $this->stringContent;
            
        }

    }