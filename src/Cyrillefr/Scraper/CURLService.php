<?php

    namespace Cyrillefr\Scraper;

    

    Class CURLService
    {


        /**
         * @var string $url 
         */
        private $url;


        public function __construct(){
        }

        //curl GET
        public function http_get($url){
                $s = curl_init(); 
                curl_setopt($s, CURLOPT_URL, $url);

                //no cookies: no page
                curl_setopt($s, CURLOPT_COOKIEFILE, Config::get('cookie_file')); 
                curl_setopt($s, CURLOPT_COOKIEJAR, Config::get('cookie_file'));

                
                curl_setopt($s, CURLOPT_RETURNTRANSFER, 1);
                //redirection
                curl_setopt($s, CURLOPT_FOLLOWLOCATION, true); 
                curl_setopt($s, CURLOPT_USERAGENT, Config::get('curl_user_agent'));
                $response = curl_exec ($s);
                curl_close($s);


                if($response == '')
                    throw new Exception ('Could not reach url.');

                return $response;
        }

    }