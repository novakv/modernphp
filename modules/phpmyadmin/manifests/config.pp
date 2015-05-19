class phpmyadmin::config {

  file { $::phpmyadmin::apache_config:
    ensure => 'file',
    source => 'puppet:///modules/phpmyadmin/phpMyAdmin.conf',
    owner  => 'root',
    group  => 'root',
    notify  => Class['apache::service'],
  }

  file { $::phpmyadmin::main_config:
    ensure => 'file',
    source => 'puppet:///modules/phpmyadmin/config.inc.php',
    owner  => 'root',
    group  => 'apache',
    mode   => '0640',
    notify  => Class['apache::service'],
  }
  
}