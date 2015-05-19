class exercises::winkelwagentje {
  #contain exercises::winkelwagentje::config

  # file  #TO DO ensure directories /home/vnovak/php/pgevord/ullmancode/h05 are created

  file { '/home/vnovak/php/pgevord/ullmancode/h05/SQL_CREATE_DATABASE_ecommerce.sql':
    ensure => 'file',
    source => 'puppet:///modules/exercises/SQL_CREATE_DATABASE_ecommerce.sql',
    owner  => 'vnovak',
    group  => 'vnovak',
    require => Class['mysql'],
  }

  exec { 'create_ecommerce_database':
    command => '/bin/mysql < /home/vnovak/php/pgevord/ullmancode/h05/SQL_CREATE_DATABASE_ecommerce.sql',
    unless  => '/bin/ls /var/lib/mysql/ecommerce',
    require => File['/home/vnovak/php/pgevord/ullmancode/h05/SQL_CREATE_DATABASE_ecommerce.sql'],
  }

  file { '/var/www/vhosts/test.com/public_html/includes':
    ensure => 'directory',
    require => Class['apache'],
  }

  file { '/var/www/vhosts/test.com/public_html/includes/footer.html':
    ensure => 'file',
    source => 'puppet:///modules/exercises/includes/footer.html',
    require => File['/var/www/vhosts/test.com/public_html/includes'],
  }
  file { '/var/www/vhosts/test.com/public_html/includes/header.html':
    ensure => 'file',
    source => 'puppet:///modules/exercises/includes/header.html',
    require => File['/var/www/vhosts/test.com/public_html/includes'],
  }
  file { '/var/www/vhosts/test.com/public_html/includes/stijl.css':
    ensure => 'file',
    source => 'puppet:///modules/exercises/includes/stijl.css',
    require => File['/var/www/vhosts/test.com/public_html/includes'],
  } 

  file { '/var/www/vhosts/test.com/public_html/categorie.php':
    ensure => 'file',
    source => 'puppet:///modules/exercises/categorie.php',
    require => File['/var/www/vhosts/test.com/public_html'],
  }
  file { '/var/www/vhosts/test.com/public_html/product.php':
    ensure => 'file',
    source => 'puppet:///modules/exercises/product.php',
    require => File['/var/www/vhosts/test.com/public_html'],
  }
  file { '/var/www/vhosts/test.com/public_html/betalen.php':
    ensure => 'file',
    source => 'puppet:///modules/exercises/betalen.php',
    require => File['/var/www/vhosts/test.com/public_html'],
  }
  file { '/var/www/vhosts/test.com/public_html/winkelwagentje.php':
    ensure => 'file',
    source => 'puppet:///modules/exercises/winkelwagentje.php',
    require => File['/var/www/vhosts/test.com/public_html'],
  }
  file { "/var/www/vhosts/test.com/public_html/images":
    source  => "puppet:///modules/exercises/images",
    recurse => true,
  }

}