<?php
/**
 * @file
 *
 * @copyright Copyright (c) 2016 Palantir.net
 */

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Drupal\DrupalExtension\Context\MinkContext;
use Drupal\DrupalExtension\Context\DrupalContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Defines content features specific to Mass.gov.
 */
class MassContentContext extends RawDrupalContext {

  /**
   * @var Object[] Array of action nodes keyed on 'title'.
   */
  private $action = [];

  /**
   * @var Object[] Array of subtopic nodes keyed on 'title'.
   */
  private $subtopic = [];

  /**
   * @var Object[] Array of topic nodes keyed on 'title'.
   */
  private $topic = [];

  /**
   * @var Object[] Array of section landing nodes keyed on 'title'.
   */
  private $section_landing = [];

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
   * Create all default content.
   *
   * @Given default test content exists
   */
  public function createDefaultTestContent() {
    $this->defaultSectionLandings();
    $this->defaultTopics();
    $this->defaultSubtopics();
    $this->defaultActions();

    // Now that all the data structures exist, we need to go back through and
    // add content dependencies.

    // $this->updateDefaultTopics();
    // $this->updateDefaultSubtopcis();
    // $this->updateDefaultSectionLandings();
  }

  /**
   * Create default test actions.
   *
   * The Action Parent field is required, thus Subtopics must be created before
   * these actions can be instantiated.
   *
   * @Given test actions exist
   */
  public function defaultActions() {
    $actions = [
      [
        'title' => 'Behat Test: Find a State Park',
        'field_action_parent' => 'Behat Test: Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test: Get a State Park Pass',
        'field_action_parent' => 'Behat Test: Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test: Reserve a Campsite (external)',
        'field_external-url' => 'http://www.google.com',
        'field_action_parent' => 'Behat Test: Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test: Find Scenic Viewing Areas',
        'field_action_parent' => 'Behat Test: Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test: Find Horseback Riding Trails (external)',
        'field_external-url' => 'http://www.google.com',
        'field_action_parent' => 'Behat Test: Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test: Download a Trail Map',
        'field_action_parent' => 'Behat Test: Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test: Get a Boating License',
        'field_action_parent' => 'Behat Test: Recreational Licenses & Permits',
      ],
      [
        'title' => 'Behat Test: Get a Fishing License (external)',
        'field_external-url' => 'http://www.google.com',
        'field_action_parent' => 'Behat Test: Recreational Licenses & Permits',
      ],
      [
        'title' => 'Behat Test: Get a Hunting License',
        'field_action_parent' => 'Behat Test: Recreational Licenses & Permits',
      ],
      [
        'title' => 'Behat Test: Post a Job',
        'field_action_parent' => 'Behat Test: Search Jobs',
      ],
      [
        'title' => 'Behat Test: Find a State Job',
        'field_action_parent' => 'Behat Test: Search Jobs',
      ],
    ];

    foreach ($actions as $action) {
      $action += ['type' => 'action'];
      $this->createNode($action);
    }
  }

  /**
   * Create default test subtopics.
   *
   * Note: The "field_topic_parent" field is required, so Topics will need to be
   * created before this content can be stubbed out.
   *
   * Note: The "featured_content" field is optional, so content relationships
   * will need to be updated after all the stub data is created.
   *
   * @Given test subtopics exist
   */
  public function defaultSubtopics() {
    $subtopics = [
      [
        'title' => 'Behat Test: Nature & Outdoor Activities',
        'field_topic_parent' => 'Behat Test: State Parks & Recreation',
        'field_lede' => 'The lede text for Nature & Outdoor Activities',
        'field_description' => 'The description text for Nature & Outdoor Activities',
        // 'field_featured_content' => [
        //   'Behat Test: Find a State Park',
        //   'Behat Test: Download a Trail Map',
        // ],
        'field_agency_links' => implode(', ', [
          'MassParks - http://www.google.com',
          'Department of Fish - http://www.google.com',
        ]),
        'field_topic_callout_links' => implode(', ', [
          'Camping - /subtopic/nature-outdoor-activities?filter=Camping',
          'Hiking - /subtopic/nature-outdoor-activities?filter=Hiking',
          'Biking - /subtopic/nature-outdoor-activities?filter=Biking',
        ]),
      ],
      [
        'title' => 'Behat Test: Recreational Licenses & Permits',
        'field_topic_parent' => 'Behat Test: State Parks & Recreation',
        'field_lede' => 'The lede text for Recreational Licenses & Permits',
        'field_description' => 'The description text for Recreational Licenses & Permits',
        // 'field_featured_content' => [
        //   'Behat Test: Get a Boating License',
        // ],
        'field_agency_links' => implode(', ', [
          'Department of Agricultural Resources - http://www.google.com',
        ]),
      ],
      [
        'title' => 'Behat Test: Search Jobs',
        'field_topic_parent' => 'Behat Test: Finding a Job',
        'field_lede' => 'The lede text for Search Jobs',
        'field_description' => 'The description text for Search Jobs',
        // 'field_featured_content' => [
        //   'Behat Test: Find a State Job',
        // ],
        'field_agency_links' => implode(', ', [
          'MassCareers - http://www.google.com',
          'MassIT - http://www.google.com'
        ]),
        'field_topic_callout_links' => implode(', ', [
          'Education - /subtopic/search-jobs?filter=Education',
          'Public Sector - /subtopic/search-jobs?filter=Public Sector',
          'Public Safety - /subtopic/search-jobs?filter=Public Safety',
        ]),
      ],
    ];

    foreach ($subtopics as $subtopic) {
      $subtopic += ['type' => 'subtopic'];
      $this->createNode($subtopic);
    }
  }

  /**
   * Create default test topics.
   *
   * The Common Actions field here is optional, and the actions may or may not
   * exist, so they should be created in a followup.
   *
   * @Given test topics exist
   */
  public function defaultTopics() {
    $topics = [
      [
        'title' => 'Behat Test: State Parks & Recreation',
        'field_section' => 'Behat Test: Visiting & Exploring',
        'field_lede' => 'Lede text for State Parks & Rec.',
        'field_icon' => 'camping',
        // 'field_common_actions' => [
        //   'Behat Test: Get a State Park Pass',
        //   'Behat Test: Download a Trail Map',
        // ],
      ],
      [
        'title' => 'Behat Test: Finding a Job',
        'field_section' => 'Behat Test: Working',
        'field_lede' => 'Lede text for Finding a Job',
        'field_icon' => 'apple',
        // 'field_common_actions' => [
        //   'Behat Test: Post a Job',
        // ],
      ],
    ];

    // var_dump($this->section_landing['Behat Test: Working']->nid);

    foreach ($topics as $topic) {
      $topic += ['type' => 'topic'];
      $this->createNode($topic);
    }
  }

  /**
   * Create default test section landings.
   *
   * @Given test section landings exist
   */
  public function defaultSectionLandings() {
    $section_landings = [
      [
        'title' => 'Behat Test: Visiting & Exploring',
        'field_icon' => 'family',
      ],
      [
        'title' => 'Behat Test: Working',
        'field_icon' => 'apple',
      ],
    ];

    foreach ($section_landings as $landing) {
      $landing += ['type' => 'section_landing'];
      $this->createNode($landing);
    }
  }

  /**
   * Create a node in Drupal from an array.
   *
   * @param array $node
   * @return object
   */
  protected function createNode(Array $node) {
    $type = $node['type'];
    // If there is not a title, set one.
    $node['title'] = ($node['title']) ?: $this->randomTitle($type);

    $node = $this->drupalContext->nodeCreate((object) $node);

    // Track the node as a local array entry for ease of reference.
    if (is_array($this->{$type})) {
      $this->{$type}[$node->title] = $node;
    }

    return $node;
  }

  /**
   * Visit a given test node.
   *
   * @When I visit the test :type :title
   *
   * @param $type The test content type
   * @param $title The test node title
   *
   * @throws Exception
   */
  public function vistsTestNode($type, $title) {
    if (empty($title)) {
      throw new \Exception('The node type must be provided.');
    }

    if (empty($title)) {
      throw new \Exception('The node titel must be provided.');
    }

    // @todo Add logic here for setting the path; should be able to get it from
    // the content arrays.
  }

  /**
   * Generate a random title for a node type.
   *
   * @param $type
   * @return string
   */
  public function randomTitle($type, $prefix = 'Behat Test -')
  {
    $random = strtolower($this->drupalContext->getRandom()->name());
    $type = str_replace('_', ' ', $type);

    return ucwords("{$prefix} {$type} {$random}");
  }

}
