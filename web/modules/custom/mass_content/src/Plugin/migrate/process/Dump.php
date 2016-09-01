<?php
/**
 * @file
 * Contains \Drupal\mass_content\Plugin\migrate\process\Dump.
 */

namespace Drupal\mass_content\Plugin\migrate\process;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;


/**
 * @MigrateProcessPlugin(
 *   id = "dump",
 *   handle_multiples = true
 * )
 */
class Dump extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (isset($this->configuration['method']) && $this->configuration['method'] == 'row') {
      var_export($row->getSource());
    }
    else {
      var_export($value);
    }

    print "\n";
    return $value;
  }

}
