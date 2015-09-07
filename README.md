# scrape-php


I have installed the 4.4.44 version of PHP, compilled it with the curl option:  
sudo ./configure --enable-mbstring   --with-curl=/usr --with-readline.  
Along I have installed libcurl4-gnutls-dev (in order to compile) and  php5-curl (in order to execute).

There are two files. One additional file is to be created: it will store cookies.  
Both files scrape.ini and scrap_webpage.php must be in the same directory.

So the test part tests if curl functions are available and that ini file is in the same directory and the version of PHP.  
The test part will remain to ensure that PHP can write in the directory.  
Otherwise it won't work.

To run/test: cd scrape-php directory  
php scrap_webpage.php run|test  

I did not included description.
