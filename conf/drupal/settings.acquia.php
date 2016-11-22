<?php

$databases = array();

$settings['hash_salt'] = '${drupal.hash_salt}';
$settings['update_free_access'] = FALSE;
$settings['container_yamls'][] = __DIR__ . '/services.yml';

$settings['file_public_path'] = '${drupal.settings.file_public_path}';
$settings['file_private_path'] = '${drupal.settings.file_private_path}';

$settings['trusted_host_patterns'] = array(
  '^${acquia.accountname}dev.prod.acquia-sites.com',
  '^${acquia.accountname}stg.prod.acquia-sites.com',
);

// Include the Acquia database connection and other config.
if (file_exists('/var/www/site-php')) {
  require '/var/www/site-php/${acquia.accountname}/${acquia.accountname}-settings.inc';
}

// Use our own config sync directory.
$config_directories = array();
$config_directories[CONFIG_SYNC_DIRECTORY] = '${drupal.config_sync_directory}';

//// Add an htaccess prompt on dev.
//// @see https://docs.acquia.com/articles/password-protect-your-non-production-environments-acquia-hosting#phpfpm

// Make sure Drush keeps working.
// Modified from function drush_verify_cli()
$cli = (php_sapi_name() == 'cli');

// PASSWORD-PROTECT NON-PRODUCTION SITES (i.e. staging/dev)
if (!$cli && (isset($_ENV['AH_NON_PRODUCTION']) && $_ENV['AH_NON_PRODUCTION'])) {
  $username = 'massgov';
  $password = 'for the commonwealth';
  if (!(isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_USER']==$username && $_SERVER['PHP_AUTH_PW']==$password))) {
    header('WWW-Authenticate: Basic realm="This site is protected"');
    header('HTTP/1.0 401 Unauthorized');
    // Fallback message when the user presses cancel / escape
    echo 'Access denied';
    exit;
  }
}

// IP-PROTECT PPRODUCTION AND STAGING SITES
if (!$cli && isset($_ENV['AH_SITE_ENVIRONMENT']) ) {
  switch ($_ENV['AH_SITE_ENVIRONMENT']) {
    case 'prod':
    case 'test':
      $config['restrict_by_ip.settings']['login_range'] = '10.20.0.0/16;146.243.0.0/16;170.63.0.0/16;63.250.249.138/32;104.247.39.34/32;40.130.238.138/32;207.173.24.186/32;50.224.63.14/32;80.71.2.77/32;66.207.219.134/32;208.66.24.54/32;50.247.79.241/32;59.100.22.81/32;14.141.169.186/32';
      break;
  }
}

// PASSWORD-PROTECT PRODUCTION
// to be removed when site goes live
if (!$cli && (isset($_ENV['AH_PRODUCTION']) && $_ENV['AH_PRODUCTION'])) {
    $username = 'massgov';
    $password = 'for the commonwealth';
    if (!(isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_USER']==$username && $_SERVER['PHP_AUTH_PW']==$password))) {
        header('WWW-Authenticate: Basic realm="This site is protected"');
        header('HTTP/1.0 401 Unauthorized');
        // Fallback message when the user presses cancel / escape
        echo 'Access denied';
        exit;
    }
}
