<?php 

    $usageMsg = 'Usage: php ' . basename(__FILE__) . ' run|test ';

    //Usage: one argument only
    if ($argc !== 2) {
        echo $usageMsg . PHP_EOL;
        exit(1);
    }

    //argument passed
    $argument = $argv[1];


    /* 2 modes
    run launches the app
    test launches tests
    */
    switch ($argument) {
        case 'run':
            command::run();
            break;

        case 'test':
            command::test();
            break;
        
        default:
            echo $usageMsg . PHP_EOL;
            exit(1);
            break;
    }

    /**
    * Utility command class
    */
    class command {

        private static $scraper;

        private function getScraper(){
            self::$scraper = new scraper();
            return self::$scraper;
        }

        public static function run(){
            self::getScraper()->run();
        }

        public static function test(){
            self::getScraper()->test();
        }
    }


    /*
    * Utility conf class
    */
    class conf {

        static function getConf(){
            return parse_ini_file('scrap.ini');
        }

    }

    /**
    Main class
    */
    class scraper {

        private $config; 
        //local curl utility
        private $userAgent = 'curl/7.38.0';


        public function __construct(){
            $this->config = conf::getConf();
        }


        public function run(){

            $json_string = '';
            $results = [];

            try {
                //connect
                $response  = self::connect($this->config['url_to_scrap']);

                //fetch array of results
                $results = self::getElements($response);

            }
            catch (Exception $e) {
                $results['results'] = 'Exception: ' . $e->getMessage();
            } 
   
            //finally
            echo json_encode($results);
        }

        //curl GET
        private function connect($url){
                $s = curl_init(); 
                curl_setopt($s, CURLOPT_URL, $url);

                //no cookies: no page
                curl_setopt($s, CURLOPT_COOKIEFILE, $this->config['cookie_file']); 
                curl_setopt($s, CURLOPT_COOKIEJAR, $this->config['cookie_file']);
                curl_setopt($s, CURLOPT_RETURNTRANSFER, 1);
                //redirection
                curl_setopt($s, CURLOPT_FOLLOWLOCATION, true); 
                curl_setopt($s, CURLOPT_USERAGENT, $this->userAgent);
                $response = curl_exec ($s);
                curl_close($s);


                if($response == '')
                    throw new Exception ('Could not reach url.');

                return $response;
        }

        private function getElements($response){

            $doc = new DOMDocument();
            //prevent warnings display
            //cf. http://php.net/manual/en/domdocument.loadhtml.php#95463
            libxml_use_internal_errors(true);

            $doc->loadHTML($response); 

            $xpath = new DOMXpath($doc);


            //All informations under nodes likes that
            //Then we 'll have to go to 2 different subsets by 
            //query twice again from this point
            $xPathQryRoot = "//li/div[@class='product ']/div[@class='productInner']";
            $nodeList = $xpath->query($xPathQryRoot);

            $products = [];

            $totalPrice = 0;

            foreach ($nodeList as $key => $value) {

                $tmp = [];

                //from div class = product / div class = productInner, we re query
                //to get title and size
                $eltsTitle = $xpath->query("div[@class='productInfoWrapper']/div[@class='productInfo']/h3/a", $value);

                foreach ($eltsTitle as $k => $valTitle) {
                   $tmp['title'] = trim($valTitle->textContent);
                   
                   $eltsHref = $xpath->query("./@href", $valTitle);
                   foreach ($eltsHref as $key => $valHref) {
                       
                       $urlFollow = $valHref->textContent;

                       //curl GET
                       try {
                            $response  = self::connect($urlFollow);
                            //2 digits after dot
                            $tmp['size'] = number_format( (strlen($response)/1000), 2, '.', '' ) . 'kb';
                            }
                            catch (Exception $e) {

                            }
                   }

                }                

                //from div class = product / div class = productInner, we re query to get price detail
                $eltsImgPrice =  $xpath->query("div[@class='addToTrolleytabBox']/
                    div[@class='addToTrolleytabContainer addItemBorderTop']
                    /div[@class='pricingAndTrolleyOptions']
                    /div[@class='priceTab activeContainer priceTabContainer']/
                    div[@class='pricing']/p[@class='pricePerUnit']", $value);



                foreach ($eltsImgPrice as $k => $valPrice) {
                   $tmp['unit_price'] = trim( substr($valPrice->textContent, 4, -7));
                   $totalPrice += $tmp['unit_price'];
                }

                $products[] = $tmp;
                
            }

            //2 digits after dot
            $totalPrice = number_format($totalPrice, 2, '.', '' );

            return array('results' => $products, 'total' =>  $totalPrice  );


        }


        public function test()
        {

            //test curl is installed
            if (function_exists('curl_init')) {
                echo "OK Curl functions are available." . PHP_EOL;
            } 
            else {
                echo "KO ! Curl functions are not available" . PHP_EOL;
            }

            $filename = './scrap.ini';

            if (file_exists($filename)) {
                echo 'OK ' . basename($filename) . ' is available.' . PHP_EOL;
            } 
            else {
                echo 'KO ! ' . basename($filename) . ' is not available.' . PHP_EOL;
            }

            $PHPVersionMajor = substr(phpversion(), 0, 3);
            if ($PHPVersionMajor >= 5.4){
                echo 'OK Version of PHP >=' . $PHPVersionMajor . PHP_EOL;
            } 
            else {
                echo 'Warning ! Version of PHP < ' . $PHPVersionMajor . '. Might not run properly' . PHP_EOL;
            }

        }





    }

?>