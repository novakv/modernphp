class phpmyadmin (
  String $apache_config = '/etc/httpd/conf.d/phpMyAdmin.conf',
  String $main_config = '/etc/phpMyAdmin/config.inc.php'
   ) {
contain phpmyadmin::install
contain phpmyadmin::config
}