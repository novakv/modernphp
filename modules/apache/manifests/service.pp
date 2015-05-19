class apache::service {
  service { 'httpd':
    ensure => $::apache::service_ensure,
    enable => $::apache::service_enable,
  }
}