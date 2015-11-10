<?php

    namespace Cyrillefr\config;

    class Config {


        private $arr_of_keys_conf;

        /**
         * $conf = Config::get(key)
         *
         */
        static function get($key){

            if (! isset($this->arr_of_keys_conf))
            {
                $this->arr_of_keys_conf = parse_ini_file('scrap.ini');
            }

            return $this->arr_of_keys_conf;
        }

    }