<?php
/**
 * @file
 *
 * @copyright Copyright (c) 2016 Palantir.net
 */

use FeatureContext;

/**
 * Defines content features specific to Mass.gov.
 */
class MassMarkupContext extends FeatureContext {

  /**
   * @var Object[] Array of action nodes keyed on 'title'.
   */
  private $actions = [];

  /**
   * @var Object[] Array of subtopic nodes keyed on 'title'.
   */
  private $subtopics = [];

  /**
   * @var Object[] Array of topic nodes keyed on 'title'.
   */
  private $topoics = [];

  /**
   * @var Object[] Array of section landing nodes keyed on 'title'.
   */
  private $section_landings = [];

  /**
   * Create default test actions.
   *
   * @Given test actions exists
   */
  public function defaultActions() {
    $actions = [
      [
        'title' => 'Behat Test - Find a State Park',
        'field-external-url' => NULL,
        'field-parent' => 'Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test - Get a State Park Pass',
        'field-external-url' => NULL,
        'field-parent' => 'Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test - Reserve a Campsite (external)',
        'field-external-url' => 'http://www.google.com',
        'field-parent' => 'Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test - Find Scenic Viewing Areas',
        'field-parent' => 'Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test - Find Horseback Riding Trails (external)',
        'field-external-url' => 'http://www.google.com',
        'field-parent' => 'Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test - Download a Trail Map',
        'field-parent' => 'Nature & Outdoor Activities',
      ],
      [
        'title' => 'Behat Test - Get a Boating License',
        'field-parent' => 'Recreational Licenses & Permits',
      ],
      [
        'title' => 'Behat Test - Get a Fishing License (external)',
        'field-external-url' => 'http://www.google.com',
        'field-parent' => 'Recreational Licenses & Permits',
      ],
      [
        'title' => 'Behat Test - Get a Hunting License',
        'field-parent' => 'Recreational Licenses & Permits',
      ],
      [
        'title' => 'Behat Test - Post a Job',
        'field-parent' => 'Search Jobs',
      ],
      [
        'title' => 'Behat Test - Find a State Job',
        'field-parent' => 'Search Jobs',
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
   * @Given test subtopics exists
   */
  public function defaultSubtopics() {
    $subtopics = [
      [
        'title' => 'Behat Test - Nature & Outdoor Activities',
        'field-parent' => 'Behat Test - State Parks & Recreation',
        'field-featured-image' => NULL,
        'field-lede' => 'The lede text for Nature & Outdoor Activities',
        'field-description' => 'The description text for Nature & Outdoor Activities',
        'field-featured-content' => [
          'Behat Test - Find a State Park',
          'Behat Test - Download a Trail Map',
        ],
        'field-agency-links' => [
          [
            'title' => 'MassParks',
            'url' => 'http://www.google.com',
          ],
          [
            'title' => 'Department of Fish and Game',
            'url' => 'http://www.google.com',
          ],
        ],
        'field-topic-callout-links' => [
          [
            'title' => 'Camping',
            'url' => '/subtopic/nature-outdoor-activities?filter=Camping',
          ],
          [
            'title' => 'Hiking',
            'url' => '/subtopic/nature-outdoor-activities?filter=Hiking',
          ]
          [
            'title' => 'Biking',
            'url' => '/subtopic/nature-outdoor-activities?filter=Biking',
          ]
        ],
      ],
      [
        'title' => 'Behat Test - Recreational Licenses & Permits',
        'field-parent' => 'Behat Test - State Parks & Recreation',
        'field-featured-image' => NULL,
        'field-lede' => 'The lede text for Recreational Licenses & Permits',
        'field-description' => 'The description text for Recreational Licenses & Permits',
        'field-featured-content' => [
          'Behat Test - Get a Boating License',
        ],
        'field-agency-links' => [
          [
            'title' => 'Department of Agricultural Resources',
            'url' => 'http://www.google.com',
          ],
        ],
        'field-topic-callout-links' => [],
      ],
      [
        'title' => 'Behat Test - Search Jobs',
        'field-parent' => 'Behat Test - Finding a Job',
        'field-featured-image' => NULL,
        'field-lede' => 'The lede text for Search Jobs',
        'field-description' => 'The description text for Search Jobs',
        'field-featured-content' => [
          'Behat Test - Find a State Job',
        ],
        'field-agency-links' => [
          [
            'title' => 'MassCareers',
            'url' => 'http://www.google.com',
          ],
        ],
        'field-topic-callout-links' => [
          [
            'title' => 'Education',
            'url' => '/subtopic/search-jobs?filter=Education',
          ],
          [
            'title' => 'Public Sector',
            'url' => '/subtopic/search-jobs?filter=Public Sector',
          ],
          [
            'title' => 'Public Safety',
            'url' => '/subtopic/search-jobs?filter=Public Safety',
          ],
        ],
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
   * @Given test topics exists
   */
  public function defaultTopcis() {
    $topics = [
      [
        'title' => 'Behat Test - State Parks & Recreation',
        'field-section' => 'Behat Test - Visiting & Exploring',
        'field-lede' => 'Lede text for State Parks & Rec.',
        'field-icon' => 'camping',
        'field-common-actions' => [
          'Behat Test - Get a State Park Pass',
          'Behat Test - Download a Trail Map',
        ],
      ],
      [
        'title' => 'Behat Test - Finding a Job',
        'field-section' => 'Behat Test - Working',
        'field-lede' => 'Lede text for Finding a Job',
        'field-icon' => 'apple',
        'field-common-actions' => [
          'Behat Test - Post a Job',
        ],
      ],
    ];

    foreach ($topics as $topic) {
      $topic += ['type' => 'topic'];
      $this->createNode($topic);
    }
  }

  /**
   * Create default test section landings.
   *
   * @Given test section landings exists
   */
  public function defaultSectionLandings() {
    $section_landings = [
      [
        'title' => 'Behat Test - Vising & Exploring',
        'field-icon' => 'family',
      ],
      [
        'title' => 'Behat Test - Working',
        'field-icon' => 'apple',
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
    $this->{$type}[$node->title] = $node;

    return $created;
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
