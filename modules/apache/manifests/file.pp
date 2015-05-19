define apache::file (
  $ensure  = undef,
  $owner   = 'root',
  $group   = 'root',
  $mode    = '0644',
  $source  = undef,
  $content = undef,
  ) {
	  
  file { "${apache::confd}/${title}.conf":
    ensure  => $ensure,
    source  => $source,
    notify  => Class['apache::service'],
    require => Class['apache::install'],
  }

  file { [ "/var/www/vhosts/${title}", "/var/www/vhosts/${title}/public_html", "/var/www/vhosts/${title}/logs" ]:
    ensure  => 'directory',
  }
  
  file { [ "/var/www/vhosts/${title}/logs/error.log", "/var/www/vhosts/${title}/logs/requests.log" ]:
    ensure  => 'file',
    owner => 'apache',
    group => 'apache',
  }
  
  file { "/var/www/vhosts/${title}/public_html/index.html":
    ensure => 'file',
    owner  => 'apache',
    group  => 'apache',
    source => "puppet:///modules/apache/${title}.index.html",
  }

  #exec { "manage_selinux_context":
    #command     => "/sbin/semanage fcontext -a -t httpd_log_t '/var/www/vhosts/*/*.log' && /sbin/restorecon -R /var/www/vhosts/",
    #unless      => "/bin/ls -Z  /var/www/vhosts/*/*.log | grep httpd_log_t",
    #subscribe   => File['/var/www/vhosts/'],
  #}

}