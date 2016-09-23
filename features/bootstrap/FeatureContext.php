<?php

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;

use Drupal\DrupalExtension\Context\MinkContext;
use Drupal\DrupalExtension\Context\DrupalContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements SnippetAcceptingContext
{

  /**
   * @var MinkContext
   */
  private $minkContext;

  /**
   * Context from the scope environment, which gives us access to the current
   * logged-in user.
   *
   * @var \Behat\MinkExtension\Context\MinkContext
   */
  protected $drupalContext;

  /**
   * Initializes context.
   *
   * Every scenario gets its own context instance.
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct()
  {
  }

  /**
   * @BeforeScenario
   */
  public function gatherContexts(BeforeScenarioScope $scope)
  {
    $environment = $scope->getEnvironment();
    $this->drupalContext = $environment->getContext(DrupalContext::class);
    $this->minkContext = $environment->getContext(MinkContext::class);
  }

  /**
   * Asserts a content type has a title and
   * fields provided in the form of a given type:
   * | field               | tag      | type  | multivalue |
   * | body                | textarea |       | true       |
   * | field-subheadline   | input    | text  | false      |
   * | field-author        | input    | text  | false      |
   * | field-summary       | textarea |       | true       |
   * | field-full-text     | textarea |       | true       |
   * | field-ref-sections  | select   |       | false      |
   *
   * Assumes fields are targeted with #edit-<fieldname>. For example,
   * "body" checks for the existence of the element, "#edit-body". Note, for
   * almost everything this will begin with "field-", like "field-tags".
   *
   * @Then the content type :content_type has the fields:
   *
   * @param String $content_type
   * @param TableNode $fieldsTable
   */
  public function assertFields($content_type, TableNode $fieldsTable) {
    $this->minkContext->visitPath('node/add/' . $content_type);
    // All content types have a title.
    $this->minkContext->assertElementOnPage('#edit-title-0-value');
    foreach ($fieldsTable->getHash() as $row) {
      // Get all IDs that start with our field name. D8 prints fields
      // differently than D7, so this is necessary.
      $css_selector = '[id^=edit-' . $row['field'] . ']';

      $this->minkContext->assertElementOnPage($css_selector);
      $this->assertFieldType('edit-' . $row['field'], $row['tag'], $row['type']);
      $this->assertFieldMultivalue($row['field'], filter_var($row['multivalue'], FILTER_VALIDATE_BOOLEAN));
    }
  }

  /**
   * Assert a paragraph has fields configured to the correct form widgets.
   *
   * @Then the :paragraph_type paragraph has the fields:
   * | field      | widget      |
   * | field-name | Textfield   |
   *
   * @param String $paragraph_type
   * @param TableNode $fieldsTable
   */
  public function assertParagraphFields($paragraph_type, TableNode $fieldsTable) {
    $this->minkContext->visitPath('admin/structure/paragraphs_type/' . $paragraph_type . '/form-display');

    foreach ($fieldsTable->getHash() as $row) {
      $id = 'edit-fields-' . $row['field'] . '-type';
      $this->minkContext->assertElementOnPage("[id^={$id}]");

      $widget = $this->getSession()->getPage()->find('css', "#{$id} option[selected='selected']")->getText();

      if (strtolower($widget) !== strtolower($row['widget'])) {
        throw new Exception(sprintf("Field %s has \"%s\" widget but should have \"%s\".", $row['field'], $widget, $row['widget']));
      }
    }
  }

  /**
   * @param $field
   * @param $multivalue
   * @throws \Exception
   */
  public function assertFieldMultivalue($field, $multivalue) {
    // Make a CSS selector for the "add more" button
    $add_more = str_replace('-', '_', $field) . '_add_more';
    $element = $this->getSession()->getPage()->find('css', '[name=' . $add_more . ']');

    // If the field is supposed to be multivalue but isn't, throw an error.
    if ($multivalue && is_null($element)) {
      throw new Exception(sprintf("Field %s is not multivalue but should be", $field));
    }

    // If the field is not supposed to be multivalue but is, throw an error.
    if (!$multivalue && !is_null($element)) {
      throw new Exception(sprintf("Field %s is multivalue but should not be", $field));
    }
  }

  /**
   * Test a field on the current page to see if it matches
   * the expected HTML field type.
   *
   * @Then the ":field" field is ":tag"
   * @Then the ":field" field is ":tag" with type ":type"
   *
   * @param string $field
   * @param string $expectedTag
   * @param string $expectedType
   * @throws \Exception
   */
  public function assertFieldType($field, $expectedTag, $expectedType = '') {
    $callback = 'assert' . ucfirst($expectedTag);
    if (!method_exists($this, $callback)) {
      throw new Exception(sprintf('%s is not a field tag we know how to validate.',
        $expectedTag));
    }
    $this->$callback($field, $expectedType);
  }
  /**
   * Verify the field is a textarea.
   *
   * @param $field
   * @param $expectedType
   * @throws Exception
   */
  public function assertTextarea($field, $expectedType) {
    $element = $this->getSession()->getPage()->find('css', '[id^=' . $field . '-wrapper]');
    if (NULL == $element->find('css', 'textarea.form-textarea')) {
      throw new Exception(sprintf("Couldn't find %s of type textarea.", $field));
    }
  }
  /**
   * Verify the field is an input field of the given type.
   *
   * @param $field
   * @param $expectedType
   * @throws Exception
   */
  public function assertInput($field, $expectedType) {
    $element = $this->getSession()->getPage()->find('css', '[id^=' . $field . ']');
    if (NULL == $element || NULL == $element->find('css', 'input[type="' . $expectedType . '"]')) {
      throw new Exception(sprintf("Couldn't find %s of type %s", $field, $expectedType));
    }
  }

  /**
   * Verify the field is an input field of the given type.
   *
   * @param $field
   * @param $expectedType
   * @throws Exception
   */
  public function assertTextfield($field, $expectedType) {
    $element = $this->getSession()->getPage()->find('css', '[id^=' . $field . '-wrapper]');
    if (NULL == $element || NULL == $element->find('css', 'input[type="' . $expectedType . '"]')) {
      throw new Exception(sprintf("Couldn't find %s of type %s", $field, $expectedType));
    }
  }

  /**
   * Verify the field is an input field of the given type.
   *
   * @param $field
   * @param $expectedType
   * @throws Exception
   */
  public function assertFile($field, $expectedType) {
    $element = $this->getSession()->getPage()->find('css', '[id^=' . $field . '-wrapper]');
    if (NULL == $element || NULL == $element->find('css', 'input[type="file"]')) {
      throw new Exception(sprintf("Couldn't find %s of type %s", $field, $expectedType));
    }
  }
  /**
   * Verify the field is a select list.
   *
   * @param $field
   * @param $expectedType
   * @throws Exception
   */
  public function assertSelect($field, $expectedType) {
    $element = $this->getSession()->getPage()->find('css', '[id^=' . $field . '-wrapper]');
    if (NULL == $element->find('css', 'select.form-select')) {
      throw new Exception(sprintf("Couldn't find %s of type select.", $field));
    }
    // Verify that the select list is not part of a multivalue widget.
    if (!$element->find('css', 'select.form-select')->isVisible()) {
      throw new Exception(sprintf("Couldn't find %s of type select.", $field));
    }
  }

  /**
   * Verify the field is a paragraph field.
   *
   * @param $field
   * @param $expectedType
   * @throws Exception
   */
  public function assertParagraphs($field, $expectedType = '') {
    $element = $this->getSession()->getPage()->find('css', '[id^=' . $field . '-wrapper]');

    if (NULL == $element || NULL == $element->find('css', '[id^=' . $field . '-add-more-add-more-button-' . $expectedType . ']')) {
      throw new Exception(sprintf("Couldn't find %s of paragraph type %s", $field, $field . '-add-more-add-more-button-' . $expectedType));
    }
  }

  /**
   *
   * @Then the :region region contains the following links:
   *
   * @param String $region
   * @param TableNode $links
   *
   * @throws \Exception
   */
  public function assertRegionLinks($region, $links) {
    $session = $this->getSession();
    $regionObj = $session->getPage()->find('region', $region);
    foreach ($links->getHash() as $row) {
      /*$this->minkContext->assertElementOnPage('#edit-' . $row['field'] );
      $this->assertFieldType('#edit-' . $row['field'], $row['tag'], $row['type']);*/
      $link = $regionObj->findLink($row['link']);
      if (empty($link)) {
        throw new \Exception(sprintf('The link "%s" was not found in the "%s" region on the page %s', $row['link'], $region, $this->getSession()->getCurrentUrl()));
      }
    }
  }
}
