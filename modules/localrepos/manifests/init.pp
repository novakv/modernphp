class localrepos {
  
  $defaults = {
    ensure  => 'file',
    owner  => 'root',
    group  => 'root',
    mode   => '0644',
  }
  create_resources('file', hiera_hash('localrepos::files'), $defaults)
}
