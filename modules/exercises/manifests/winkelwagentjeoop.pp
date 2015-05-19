class exercises::winkelwagentjeoop inherits exercises::winkelwagentje {
  #file { '/var/www/vhosts/test.com/public_html/winkelwagentje.php':

  File <| title == '/var/www/vhosts/test.com/public_html/winkelwagentje.php' |> {
    ensure => 'file',
    source => 'puppet:///modules/exercises/oop/winkelwagentje.php',
    require => File['/var/www/vhosts/test.com/public_html'],
  }
  file { '/var/www/vhosts/test.com/public_html/WidgetWinkelwagentje.php':
    ensure => 'file',
    source => 'puppet:///modules/exercises/oop/WidgetWinkelwagentje.php',
    require => File['/var/www/vhosts/test.com/public_html'],
  }  
}