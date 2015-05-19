class apache::install {

  unless $::apache::service_enable == false {

    case $::osfamily {
      'RedHat': {
        package { [ 'httpd', 'mod_ssl', 'policycoreutils', 'policycoreutils-python', 'elinks' ]:
          ensure => present,
        }
        #package { 'mod_ssl':
        #  ensure => present,
        #}
      }
      default: {
        fail("The ${module_name} module is not supported on an ${::operatingsystem} distribution.")
      }
    }
  }
}