<?php

$databases = array();
$databases['default']['default'] = array(
  'driver' => 'mysql',
  'database' => '${drupal.database.database}',
  'username' => '${drupal.database.username}',
  'password' => '${drupal.database.password}',
  'host' => '${drupal.database.host}',
  'prefix' => '',
  'collation' => 'utf8mb4_general_ci',
);

$config_directories = array();
$config_directories[CONFIG_SYNC_DIRECTORY] = '${drupal.config_sync_directory}';

$settings['hash_salt'] = '${drupal.hash_salt}';
$settings['update_free_access'] = FALSE;
$settings['container_yamls'][] = __DIR__ . '/services.yml';

$settings['file_public_path'] = '${drupal.settings.file_public_path}';
$settings['file_private_path'] = '${drupal.settings.file_private_path}';

// Set variable to indicate if we are in "Edit Domain".
// @see https://kbv2.acquia.com/articles/best-practices-setting-edit-domain
$forwarded_host = (empty($_SERVER['HTTP_X_FORWARDED_HOST'])) ? $_SERVER['HTTP_HOST'] : $_SERVER['HTTP_X_FORWARDED_HOST'];
$config['is_edit_domain'] = (strpos($forwarded_host, 'edit') !== FALSE) ? TRUE : FALSE;
