class composer {

  exec { "getcomposer":
    command => "/bin/curl -sS https://getcomposer.org/installer | php",
    unless  => "/bin/ls /usr/local/bin/composer",
    require => Class['php'],
  }
  exec { "movecomposer":
    command     => "/bin/mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer",
    subscribe   => Exec['getcomposer'],
    refreshonly => true,
  }
}