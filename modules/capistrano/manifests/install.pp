class capistrano::install {
  package { [ 'ruby' ]:
    ensure => present,
  }
  package { 'capistrano':
    ensure   => present,
    provider => gem,
    require => Package['ruby'],
  }
}
