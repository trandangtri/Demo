# Ensure the time is accurate, reducing the possibilities of apt repositories
# failing for invalid certificates
include git
include composer

exec { "apt-update":
  command => "/usr/bin/apt-get update"
}
#Exec["apt-update"] -> Package <| |>

## Begin Server manifest
class { 'apt': }

apt::source { 'packages.dotdeb.org-php55':
    location          => 'http://packages.dotdeb.org',
    release           => 'wheezy-php55',
    repos             => 'all',
    required_packages => 'debian-keyring debian-archive-keyring',
    key               => '89DF5277',
    key_server        => 'hkp://keys.gnupg.net:80',
    include_src       => true
}

Exec { path => [ '/usr/local/bin', '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin/' ] }
File { owner => 0, group => 0, mode => 0644 }

user { "vagrant_user":
    name       => vagrant,
    ensure     => present,
    groups     => ["www-data", "mysql"]
}

file_line { "vagrant_umask":
    ensure  => present,
    line    => "umask 002",
    path    => "/home/vagrant/.bashrc",
    require => User["vagrant_user"]
}

file_line { "vagrant_ssh_dir":
    line    => "cd /var/www",
    path    => "/home/vagrant/.bashrc"
}

ensure_packages( ['augeas-tools'] )

class { 'nginx': }

nginx::resource::vhost { 'ongr.dev':
  ensure               => present,
  server_name          => [
    'ongr.dev',
    'www.ongr.dev'
  ],
  index_files          => [
    'app_dev.php',
    'app.php'
  ],
  listen_port          => 80,
  www_root             => '/var/www/web/',
  use_default_location => false,
  vhost_cfg_append     => {
    'try_files'      => '$uri $uri/ /app_dev.php?$args',
  }
}

nginx::resource::location { "ongr.dev-php":
    vhost               => 'ongr.dev',
    location            => '~ \.php$',
    proxy               => undef,
    www_root            => '/var/www/web/',
    ensure              => 'present',
    index_files          => [
      'app_dev.php',
      'app.php'
    ],
    location_cfg_append => {
      'fastcgi_split_path_info' => '^(.+\.php)(/.+)$',
      'fastcgi_param'           => 'PATH_INFO $fastcgi_path_info',
      'fastcgi_param '          => 'PATH_TRANSLATED $document_root$fastcgi_path_info',
      'fastcgi_param  '         => 'SCRIPT_FILENAME $document_root$fastcgi_script_name',
      'fastcgi_pass'            => 'unix:/var/run/php5-fpm.sock',
      'fastcgi_index'           => 'app_dev.php',
      'include'                 => 'fastcgi_params',
    },
    notify              => Class['nginx::service'];
}


nginx::resource::vhost { 'magento.ongr.dev':
  ensure               => present,
  server_name          => [
    'magento.ongr.dev',
    '*.magento.ongr.dev'
  ],
  index_files          => [
    'index.html',
    'index.php'
  ],
  listen_port          => 80,
  www_root             => '/var/www/magento/',
  use_default_location => false,
  vhost_cfg_append     => {
    'try_files'      => '$uri $uri/ @handler',
    'expires'        => '30d',
  }
}

nginx::resource::location { "magento.ongr.dev-deny1":
  vhost               => 'magento.ongr.dev',
  location            => '^~ /app/',
  www_root             => '/var/www/magento/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'deny' => 'all',
  },
}
nginx::resource::location { "magento.ongr.dev-deny2":
  vhost               => 'magento.ongr.dev',
  location            => '^~ /report/config.xml',
  www_root             => '/var/www/magento/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'deny' => 'all',
  },
}
nginx::resource::location { "magento.ongr.dev-deny3":
  vhost               => 'magento.ongr.dev',
  location            => '^~ /var/',
  www_root             => '/var/www/magento/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'deny' => 'all',
  },
}
nginx::resource::location { "magento.ongr.dev-deny4":
  vhost               => 'magento.ongr.dev',
  location            => '^~ /includes/',
  www_root             => '/var/www/magento/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'deny' => 'all',
  },
}
nginx::resource::location { "magento.ongr.dev-deny5":
  vhost               => 'magento.ongr.dev',
  location            => '^~ /lib/',
  www_root             => '/var/www/magento/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'deny' => 'all',
  },
}
nginx::resource::location { "magento.ongr.dev-deny6":
  vhost               => 'magento.ongr.dev',
  location            => '^~ /media/downloadable/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  www_root             => '/var/www/magento/',
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'deny' => 'all',
  },
}
nginx::resource::location { "magento.ongr.dev-deny7":
  vhost               => 'magento.ongr.dev',
  location            => '^~ /pkginfo/',
  www_root             => '/var/www/magento/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'deny' => 'all',
  },
}
nginx::resource::location { "magento.ongr.dev-export":
  vhost               => 'magento.ongr.dev',
  location            => '/var/export/',
  www_root             => '/var/www/magento/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'auth_basic' => '"Restricted"',
    'auth_basic_user_file' => 'htpasswd',
    'autoindex' => 'on',
  },
}
nginx::resource::location { "magento.ongr.dev-hidden":
  vhost               => 'magento.ongr.dev',
  location            => '/.',
  www_root             => '/var/www/magento/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'return' => '404',
  },
}
nginx::resource::location { "magento.ongr.dev-handler":
  vhost               => 'magento.ongr.dev',
  location            => '@handler',
  www_root             => '/var/www/magento/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'rewrite' => '/ /index.php',
  },
}
nginx::resource::location { "magento.ongr.dev-forward":
  vhost               => 'magento.ongr.dev',
  location            => '~ .php/',
  www_root             => '/var/www/magento/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'rewrite' => '^(.*.php)/ $1 last',
  },
}

nginx::resource::location { "magento.ongr.dev-php":
  vhost               => 'magento.ongr.dev',
  location            => '~ \.php$',
  www_root             => '/var/www/magento/',
  index_files          => [
    'index.html',
    'index.php'
  ],
  proxy               => undef,
  ensure              => 'present',
  location_cfg_append => {
    'expires' => 'off',
    'fastcgi_pass' => 'unix:/var/run/php5-fpm.sock',
    'fastcgi_param'           => 'SCRIPT_FILENAME $document_root$fastcgi_script_name',
    'fastcgi_param '          => 'MAGE_RUN_CODE default',
    'fastcgi_param  '         => 'MAGE_RUN_TYPE store',
    'include'                 => 'fastcgi_params',
  },
  location_custom_cfg_append => {
    'if (!-e $request_filename)' => '{ rewrite / /index.php last; }',
  },
  notify              => Class['nginx::service'];
}

class { '::mysql::server':
  root_password    => 'root',
  override_options => {
    'mysqld' => {
      'log-bin' => 'mysql-bin',
      'binlog_format' => 'ROW'
    }
  }
}

file { "/var/lib/mysql":
  ensure => "directory",
  owner  => "mysql",
  group  => "mysql",
  mode   => 770,
}

class { 'php':
  version             => 'latest',
  package             => "php5-fpm",
  service             => "php5-fpm",
  service_autorestart => false,
  config_file         => "/etc/php5/fpm/php.ini",
  require => [
    File['/etc/apt/sources.list.d/packages.dotdeb.org-php55.list'],
    Exec['apt-update']
  ]
}

service { "php5-fpm":
  ensure     => running,
  enable     => true,
  hasrestart => true,
  hasstatus  => true,
  require    => Package["php5-fpm"]
}

php::module {
  [
  'mysql',
  'cli',
  'curl',
  'intl',
  'gd',
  'mcrypt',
  'common',
  'xdebug'
  ]:
}

exec { "php-fpm-owner-fix":
  command => "sed -i 's/;listen.owner/listen.owner/g' /etc/php5/fpm/pool.d/www.conf",
  require => Class["php"],
  notify => Service["php5-fpm"]
}

exec { "php-fpm-group-fix":
  command => "sed -i 's/;listen.group/listen.group/g' /etc/php5/fpm/pool.d/www.conf",
  require => Class["php"],
  notify => Service["php5-fpm"]
}

augeas { "custom":
  context => "/files/etc/php5/mods-available/custom.ini",
  changes => [
  "set PHP/date.timezone Europe/Vilnius",
  "set XDEBUG/xdebug.default_enable 1",
  "set XDEBUG/xdebug.max_nesting_level 250",
  "set XDEBUG/xdebug.remote_autostart 0",
  "set XDEBUG/xdebug.remote_connect_back 1",
  "set XDEBUG/xdebug.remote_enable 1",
  "set XDEBUG/xdebug.remote_handler dbgp",
  "set XDEBUG/xdebug.remote_port 9000",
  "set XDEBUG/xdebug.remote_host 192.168.33.1"
  ],
  require => Class["php"]
}

file { "/etc/php5/cli/conf.d/custom.ini":
    ensure => link,
    source => '/etc/php5/mods-available/custom.ini',
    require => Augeas["custom"]
}

file { "/etc/php5/fpm/conf.d/custom.ini":
    ensure => link,
    source => '/etc/php5/mods-available/custom.ini',
    require => Augeas["custom"]
}

#Elasticsearch
class { 'elasticsearch':
  java_install => true,
  package_url => 'http://download.elasticsearch.org/elasticsearch/elasticsearch/elasticsearch-1.3.4.deb',
}

elasticsearch::instance { 'ongr-01': }

elasticsearch::plugin{'mobz/elasticsearch-head':
    module_dir => 'head',
    instances  => 'ongr-01'
}

elasticsearch::plugin{'elasticsearch/marvel/latest':
    module_dir => 'marvel',
    instances  => 'ongr-01'
}


# Install compass as gem
package { 'compass':
    provider => 'gem',
    ensure => 'present'
}

exec { 'sass-css-importer':
    command => 'gem install --pre sass-css-importer',
    unless => 'gem list --local | grep -c sass-css-importer'
}

file { '/usr/local/bin/debug':
  ensure => present,
  mode => 755,
  content => "#!/bin/sh\nenv PHP_IDE_CONFIG=\"serverName=ongr\" XDEBUG_CONFIG=\"idekey=PHPSTORM\" SYMFONY_DEBUG=\"1\" $@"
}

exec { "node_sources" :
  command => "curl -sL https://deb.nodesource.com/setup | bash -",
  require => Class["apt"]
}

package { 'nodejs':
  require => Exec['node_sources'],
  ensure => installed,
}

package { 'npm':
  require => Exec['node_sources'],
  ensure => installed,
}

package { 'phantomjs':
  require => package['npm'],
  ensure   => present,
  provider => 'npm',
}
