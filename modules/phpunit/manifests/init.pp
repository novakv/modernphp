class phpunit (
  #String $apache_config = '/etc/httpd/conf.d/phpMyAdmin.conf',
  #String $main_config = '/etc/phpMyAdmin/config.inc.php'
   ) {
contain phpunit::install
#contain phpunit::config
}