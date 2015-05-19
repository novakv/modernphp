class path::config {
  file { '/etc/profile.d/path.sh':
    ensure => 'file',
    #source => 'puppet:///modules/path/path.sh',
    content => "PATH=\${PATH}:/opt/puppetlabs/bin:/root/.composer/vendor/bin\n",
    owner  => 'root',
    group  => 'root',
    mode   => '0755',
  }
}
