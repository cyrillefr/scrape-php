<?php

    namespace Cyrillefr\Scraper;

    use Cyrillefr\Scraper\CURLService;

    Class Content
    {

        /**
         * @var string $url 
         */
        private $url;

        /**
         * @var 
         */
        private $CURLService;

       
        public function __construct($url)
        {
            $this->url = $url;
        }


        

        Constructeur: une url et une classe


        //fn return content
        //Fait appel classe curl
        //Qui decide de faire appel a classe curl ou assimilé ?

       

        public function getStringContent(){
            //execute cURL
        }

    }