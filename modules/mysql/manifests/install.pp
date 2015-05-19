class mysql::install {

  unless $::apache::service_enable == false {

    case $::osfamily {
      'RedHat': {
        package { [ 'expect', 'mariadb-server', 'mariadb' ]:
          require => Class['localrepos'],
          ensure => present,
        }
      }
      default: {
        fail("The ${module_name} module is not supported on an ${::operatingsystem} distribution.")
      }
    }
  }
}