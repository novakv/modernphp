#!/bin/bash

/bin/chmod +x /root 
export COMPOSER_HOME="/root/.composer"
/usr/local/bin/composer global require --dev phpunit/phpunit
