class role::modernphp {
  include localrepos
  include apache
  include composer
  include mysql
  include php
  include phpmyadmin
  include phpunit
  include phpcodesniffer
  #include xhprof
  include path::config
  include capistrano
}
