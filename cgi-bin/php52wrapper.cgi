#!/bin/sh
PHPRC="/opt/php52/"
export PHPRC
PHP_FCGI_CHILDREN=4
export PHP_FCGI_CHILDREN
PHP_FCGI_MAX_REQUESTS=5000
export PHP_FCGI_MAX_REQUESTS
exec /opt/php52/bin/php-cgi 

