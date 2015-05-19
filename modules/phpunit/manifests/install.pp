class phpunit::install {
  
  file { '/usr/local/bin/composer_phpunit.sh':
      ensure => 'file',
      source => 'puppet:///modules/phpunit/composer_phpunit.sh',
      owner  => 'root',
      group  => 'root',
      mode   => '0700',
      require => Class['composer'],
    }

  exec { 'run_composer_phpunit':
    command => '/usr/local/bin/composer_phpunit.sh',
    unless  => '/bin/ls /root/.composer/vendor/bin/phpunit',
    require => File['/usr/local/bin/composer_phpunit.sh']
  }
}
