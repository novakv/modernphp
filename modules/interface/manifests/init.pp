class interface {
  file { '/etc/sysconfig/network-scripts/ifcfg-enp0s8':
    ensure  => 'file',
    source => 'puppet:///modules/interface/ifcfg-enp0s8',
    owner   => 'root',
    group   => 'root',
  }
}