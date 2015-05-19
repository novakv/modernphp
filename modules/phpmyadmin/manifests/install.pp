class phpmyadmin::install {

  case $::osfamily {
    'RedHat': {
      package { 'phpMyAdmin':
        require => Class['localrepos'],
        ensure => present,
      }
    }
    default: {
      fail("The ${module_name} module is not supported on an ${::operatingsystem} distribution.")
    }
  }
  
}