<?php

$options['shell-aliases'] = [
  // Used by devs and CircleCI to fetch a Prod DB and run pending updates.
  'ma-pull-db' => '!drush sql-sync @massgov.prod @self && drush cimy && drush updatedb',
  'ma-pull-files' => '!drush rsync @massgov.prod:%files @self:%files',
];


$options['uri'] = "http://mass.local";
$options['include'] = [
  // @todo Not needed after https://github.com/previousnext/drush_cmi_tools/issues/7
  "../vendor/previousnext/drush_cmi_tools",
];
/**
 * Using the flag "--structure-tables-key=common" on sql-dump and sql-sync will cause
 * the structure but not the data to be dumped for these tables.
 */
$options['structure-tables']['common'] = array('cache', 'cache_*', 'history', 'search_*', 'sessions', 'watchdog');

// Remember to pass config_installer as argument to site-install.
$command_specific['site-install'] = [
  'account-name' => 'massadmin',
  'db-url' => 'mysql://root:root@127.0.0.1/drupal',
];

$command_specific['config-import-plus'] = [
  'source' => '../conf/drupal/config',
  'delete-list' => '../conf/drupal/delete.yml'
];