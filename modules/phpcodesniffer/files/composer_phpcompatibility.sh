#!/bin/bash

/bin/chmod +x /root 
export COMPOSER_HOME="/root/.composer"
#readme https://github.com/wimg/PHPCompatibility
/usr/local/bin/composer global require --dev wimg/php-compatibility dev-master
#cd /root/.composer/vendor/squizlabs/php_codesniffer/CodeSniffer/Standards/
#git clone https://github.com/wimg/PHPCompatibility.git
/usr/local/bin/composer global require --dev simplyadmire/composer-plugins @dev
/usr/local/bin/composer global require phpmd/phpmd @stable
/usr/local/bin/composer global require fabpot/php-cs-fixer @stable