class exercises::winkelwagentjeoopenhanced inherits exercises::winkelwagentjeoop {
  #file { '/var/www/vhosts/test.com/public_html/winkelwagentje.php':

  File <| title == '/var/www/vhosts/test.com/public_html/winkelwagentje.php' |> {
    ensure => 'file',
    source => 'puppet:///modules/exercises/oopenhanced/winkelwagentje.php',
    require => File['/var/www/vhosts/test.com/public_html'],
  }
  File <| title == '/var/www/vhosts/test.com/public_html/WidgetWinkelwagentje.php' |> {
    ensure => 'file',
    source => 'puppet:///modules/exercises/oopenhanced/WidgetWinkelwagentje.php',
    require => File['/var/www/vhosts/test.com/public_html'],
  }
  file { '/var/www/vhosts/test.com/public_html/Item.php':
    ensure => 'file',
    source => 'puppet:///modules/exercises/oopenhanced/Item.php',
    require => File['/var/www/vhosts/test.com/public_html'],
  }  
}
