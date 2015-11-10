<?php

    namespace Cyrillefr\config;

    class Config {


        /**
         * $conf = Config::get(key)
         *
         */
        static function get($key){
            $arr = parse_ini_file('scrap.ini');
            return $arr[$key];
        }

    }