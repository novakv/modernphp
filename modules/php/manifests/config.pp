class php::config {
  file { '/etc/php.ini':
    ensure  => 'file',
    source => 'puppet:///modules/php/php.ini',
    owner   => 'root',
    group   => 'root',
    mode => '0644',
    require => Class['apache::install'],
    notify  => Class['apache::service'],
  }
}