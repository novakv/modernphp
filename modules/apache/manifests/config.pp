class apache::config {

  unless $::apache::service_enable == false {

    file { $::apache::main_config:
      ensure  => 'file',
      #content => epp('apache/apache.epp'),
      source => 'puppet:///modules/apache/httpd.conf',
      owner   => 'root',
      group   => 'root',
      require => Class['apache::install'],
      notify  => Class['apache::service'],
    }

    file { '/var/www/vhosts/':
      ensure  => 'directory',
      owner   => 'apache',
      group   => 'apache',
    }

    apache::file { 'example.com':
      ensure => 'file',
      source => 'puppet:///modules/apache/example.com.conf',
    }

    apache::file { 'test.com':
      ensure => 'file',
      source => "puppet:///modules/apache/test.com.conf",
    }

    file { '/etc/hosts':
      ensure => 'file',
      owner  => 'root',
      source => "puppet:///modules/apache/etc.hosts",
    }

    #http://www.certdepot.net/rhel7-get-started-firewalld/
    exec { "firewalld_http_service":
      command     => "/bin/firewall-cmd --permanent --zone=public --add-service=http && /bin/firewall-cmd --permanent --zone=public --add-service=https && /bin/firewall-cmd --reload",
      unless      => "/bin/firewall-cmd --list-services | grep http",
    }
  }
}