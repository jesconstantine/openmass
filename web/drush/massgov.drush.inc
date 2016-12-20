<?php

function massgov_drush_command() {
  $items['ma-deploy'] = array(
    'description' => 'Deploy code and database (if needed). Perform config-import, updb, and similar tasks.',
    'arguments' => array(
      'target' => 'Target environment. Recognized values: stage, cd, prod',
      'git-ref' => 'Tag or branch to deploy.',
    ),
    'required-arguments' => TRUE,
    'options' => array(),
    'drush dependencies' => array('acapi'),
    'bootstrap' => DRUSH_BOOTSTRAP_NONE,
    'examples' => array(
      'drush ma-deploy stage tags/build-0.6.1' => 'Deploy tag to staging environment.',
    ),
  );
  return $items;
}

function drush_massgov_ma_deploy_validate($target) {
  if (!in_array($target, array('cd', 'test', 'prod'))) {
    return drush_set_error('Invalid argument: target');
  }
}

function drush_massgov_ma_deploy($target, $git_ref) {
  $to_prod = $target == 'prod';
  $alias_target =  '@massgov.'. $target;
  $options_cloudapi = array(
    'format' => 'json',
  );

  // Turn on Maint mode
  $args = array('system.maintenance_mode', 1);
  $options = array('format' => 'integer');
  $return = drush_invoke_process($alias_target, 'state-set', $args, $options);
  massgov_check_error($return);

  // Backup Prod DB if needed.
  if ($to_prod) {
    // cache-rebuild empties cache-* tables.
    $args = $options = array();
    $return = drush_invoke_process($alias_target, 'cache-rebuild', $args, $options);
    massgov_check_error($return);

    $args = array('massgov');
    $return = drush_invoke_process($alias_target, 'ac-database-instance-backup', $args, $options_cloudapi);
    massgov_check_error($return);
    $json = $return['object']['output'];
    $data = json_decode($json);
    $task_backup = $data->id;
    massgov_wait($task_backup, $options_cloudapi);
  }
  else {
    // Copy Prod DB to target.
    $args = array('massgov', $target);
    $return = drush_invoke_process('@massgov.prod', 'ac-database-copy', $args, $options_cloudapi);
    massgov_check_error($return);
    $task_db = $return['object']['id'];

    // Copy Prod files to target.
    $args = array($target);
    $return = drush_invoke_process('@massgov.prod', 'ac-files-copy', $args, $options_cloudapi);
    massgov_check_error($return);

    // Make sure DB copy is complete before proceeding. Files are less important.
    massgov_wait($task_db, $options_cloudapi);
  }

  // Deploy the new code.
  $args = array($git_ref);
  $return = drush_invoke_process($alias_target, 'ac-code-path-deploy', $args, $options_cloudapi);
  massgov_check_error($return);

  // Import new config
  $return = drush_invoke_process($alias_target, 'cimy');
  massgov_check_error($return);

  // Run any pending DB updates
  $args = $options = array();
  $return = drush_invoke_process($alias_target, 'updb', $args, $options);
  massgov_check_error($return);

  // Purge Varnish cache.
  $args = array();
  $return = drush_invoke_process($alias_target, 'ac-domain-purge', $args, $options_cloudapi);
  massgov_check_error($return);

  // @todo Disable System Notification block

  // Disable Maintenance mode.
  $args = array('system.maintenance_mode', 0);
  $options = array('format' => 'integer');
  $return = drush_invoke_process($alias_target, 'state-set', $args, $options);
  massgov_check_error($return);
}

function massgov_wait($task_id, $options_cloudapi) {
  while (TRUE) {
    $return = drush_invoke_process($alias, 'ac-task-info', array($task_id), $options_cloudapi);
    massgov_check_error($return);
    $json = $return['object']['output'];
    $data = json_decode($json);
    if (!empty($data->completed)) {
      break;
    }
    else {
      drush_log(dt('Will re-check for task !task_id completion in 10 seconds.', array('!task_id' => $task_id)), 'ok');
      sleep(10);
    }
  }
}

function massgov_check_error($return) {
  if (!$return) {
    throw new Exception('Failure in drush_invoke_process()');
  }
  elseif ($return['error_status']) {
    foreach ($return['error_log'] as $key => $value) {
      foreach ($value as $message) {
        $messages[] = $message;
      }
    }
    throw new Exception(implode('', $messages));
  }
}