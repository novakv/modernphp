class php::install {

  $packages = hiera_array('php::packages')
  package { $packages:
    ensure => 'present',
    require => Class['localrepos'],
  }
}