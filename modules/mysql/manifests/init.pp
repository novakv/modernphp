class mysql (
  Boolean $service_enable = true,
  String $service_ensure = 'running',
  String $mysql_secure = '/usr/local/bin/mysql_secure.sh',
   ) {
contain mysql::install
contain mysql::config
contain mysql::service
}