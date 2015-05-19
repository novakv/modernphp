class apache (
  Boolean $service_enable = true,
  String $service_ensure = 'running',
  String $main_config = '/etc/httpd/conf/httpd.conf',
  String $confd = '/etc/httpd/conf.d',
  
   ) {
contain apache::install
contain apache::config
contain apache::service
}