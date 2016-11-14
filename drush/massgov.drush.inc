<?php

function massgov_drush_command() {
  $items['ma-deploy'] = array(
    'description' => 'Deploy code and database (if needed). Perform config-import, updb, and similar tasks.',
    'arguments' => array(
      'target' => 'Target environment. Recognized values: state, prod',
      'git-ref' => 'Tag or branch to deploy.',
    ),
    'required arguments' => 2,
    'options' => array(),
    'examples' => array(
      'drush ma-deploy stage tags/build-0.6.1' => 'Deploy tag to staging environment.',
    ),
  );
  return $items;
}

function drush_massgov_ma_deploy_validate($target) {
  if (!in_array($target, array('stage', 'prod'))) {
    return drush_set_error('Invalid target');
  }
}

function drush_massgov_ma_deploy($target, $git_ref) {
  $is_prod = $target == 'prod';
  $alias =  $is_prod ? '@massgov.prod' : '@massgov.test';
  $options_cloudapi = array(
    // 'ac-config' => '../artifacts/acquiacloud/.acquia/cloudapi.conf',
    'format' => 'json',
  );

  // Turn on Maint mode
  $args = array('system.maintenance_mode', 1);
  $options = array('input-format' => 'integer');
  if (!drush_invoke_process($alias, 'state-set', $args, $options)) {
    return drush_set_error('Unable to turn on Maintenance mode.');
  }

  // @todo Disable System Notification block


  // Backup Prod DB if needed.
  if ($is_prod) {
    // cache-rebuild empties cache-* tables.
    $args = $options = array();
    drush_invoke_process($target, 'cache-rebuild', $args, $options);

    $args = array('massgov');
    if ($return = drush_invoke_process($alias, 'ac-database-instance-backup', $args, $options_cloudapi)) {
      $json = $return['object']['output'];
      $data = json_decode($json);
      $task_backup = $data['task'];
      massgov_wait($task_backup);
    }
    else {
      return drush_set_error('Unable to start instance backup');
    }
  }
  else {
    // Copy Prod DB to Stage.
    $args = array('massgov', 'test');
    if ($return = drush_invoke_process('@massgov.prod', 'ac-database-copy', $args, $options_cloudapi)) {
      $task_db = $return['object']['id'];
    }
    else {
      return drush_set_error('Unable to copy Database from Prod');
    }

    // Copy Prod files to Stage.
    $args = array('test');
    if (!$return = drush_invoke_process('@massgov.prod', 'ac-files-copy', $args, $options_cloudapi)) {
      return drush_set_error('Unable to copy files from Prod');
    }
  }

  // Deploy the new code.
  $args = array($git_ref);
  if (!$return = drush_invoke_process($alias, 'ac-code-path-deploy', $args, $options_cloudapi)) {
    return drush_set_error('Unable to deploy new code');
  }

  // Import any new config
  // @todo options.
  $args = array();
  $options = array();
  if (!$return = drush_invoke_process($alias, 'cimy', $args, $options)) {
    return drush_set_error('Unable to import new configuration');
  }

  // Run any pending DB updates
  $args = $options = array();
  if (!$return = drush_invoke_process($alias, 'updb', $args, $options)) {
    return drush_set_error('Unable run pending Db updates');
  }

  // Disable Maintenance mode.
  $args = array('system.maintenance_mode', 0);
  $options = array('input-format' => 'integer');
  if (!$return = drush_invoke_process($alias, 'state-set', $args, $options)) {
    return drush_set_error('Unable to disable maintenance mode.');
  }

  // Purge Varnish cache.
  $args = array();
  if (!$return = drush_invoke_process($alias, 'ac-domain-purge', $args, $options_cloudapi)) {
    return drush_set_error('Unable to purge Varnish');
  }

}

function massgov_wait($task_id, $options_cloudapi) {
  while (TRUE) {
    if (!$return = drush_invoke_process($alias, 'ac-task-info', $args, $options_cloudapi)) {
      return drush_set_error('Unable to get task information.');
    }
    $json = $return['object'];
    $data = json_decode($json);
    if ($data['status'] == 'complete') {
      break;
    }
    else {
      drush_log('Will re-check for task completion in 10 seconds.', 'ok');
      sleep(10);
    }
  }
}