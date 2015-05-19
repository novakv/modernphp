class phpcodesniffer::install {
  
  file { '/usr/local/bin/composer_phpcompatibility.sh':
      ensure => 'file',
      source => 'puppet:///modules/phpcodesniffer/composer_phpcompatibility.sh',
      owner  => 'root',
      group  => 'root',
      mode   => '0700',
      require => Class['composer'],
    }

  exec { 'run_composer_phpcodesniffer':
    command => '/usr/local/bin/composer_phpcompatibility.sh',
    unless  => '/bin/ls /root/.composer/vendor/wimg/php-compatibility',
    require => File['/usr/local/bin/composer_phpcompatibility.sh']
  }
}
