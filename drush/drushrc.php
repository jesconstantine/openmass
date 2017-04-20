<?php


/**
 * Using the flag "--structure-tables-key=common" on sql-dump and sql-sync will cause
 * the structure but not the data to be dumped for these tables.
 */
$options['structure-tables']['common'] = array('cache', 'cache_*', 'history', 'search_*', 'sessions', 'watchdog');

$command_specific['core-rsync'] = [
  'exclude-paths' => 'css:php:styles:js:php:xmlsitemap',
];

$command_specific['sql-sync'] = [
  'structure-tables-key' => 'common',
];

