<?php

$options['shell-aliases'] = [
  // Used by devs to fetch a Prod DB and run pending updates.
  'ma-pull-db' => '!drush sql-sync @massgov.prod @self && drush updatedb && drush cimy',
  'ma-pull-files' => '!drush rsync @massgov.prod:%files @self:%files',
];


$options['include'] = [
  // @todo Not needed after https://github.com/previousnext/drush_cmi_tools/pull/8
  "../vendor/previousnext/drush_cmi_tools",
];
/**
 * Using the flag "--structure-tables-key=common" on sql-dump and sql-sync will cause
 * the structure but not the data to be dumped for these tables.
 */
$options['structure-tables']['common'] = array('cache', 'cache_*', 'history', 'search_*', 'sessions', 'watchdog');

$command_specific['config-import-plus'] = [
  'source' => '../conf/drupal/config',
  'delete-list' => '../conf/drupal/delete.yml'
];