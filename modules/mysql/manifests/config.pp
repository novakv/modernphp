class mysql::config {

  unless $::mysql::service_enable == false {

    file { $::mysql::mysql_secure:
      ensure => 'file',
      source => 'puppet:///modules/mysql/mysql_secure.sh',
      owner  => 'root',
      group  => 'root',
      mode   => '0700',
    }

    exec { 'run_mysql_secure':
      command => '/usr/local/bin/mysql_secure.sh',
      onlyif  => '/bin/ls /var/lib/mysql/test',
      require => File['/usr/local/bin/mysql_secure.sh'],
    }
  }
}