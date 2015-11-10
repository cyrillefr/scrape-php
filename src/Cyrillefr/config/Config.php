<?php

    namespace Cyrillefr\config;

    class Config
    {


        private static $arr_of_keys_conf;

        /**
         * $conf = Config::get(key)
         *
         */
        static function get($key)
        {

            if (! isset(self::$arr_of_keys_conf))
            {
                //$this->arr_of_keys_conf = parse_ini_file('scrap.ini');
                self::$arr_of_keys_conf = parse_ini_file('scrap.ini');
            }

            return self::$arr_of_keys_conf;
        }

    }