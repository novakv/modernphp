class mysql::service {
  service { 'mariadb':
    ensure => $::mysql::service_ensure,
    enable => $::mysql::service_enable,
  }
}