@api
Feature: Paragraph type definitions
  As a MassGov alpha content editor,
  I want to be able to add content for actions (a bedrock of the alpha release) for pre-determined journeys,
  so that I can help Bay Staters get the best information they need to fulfill basic tasks.

  Scenario: Verify that the action_address_info paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "action_address_info" paragraph has the fields:
      | field                   | widget                    |
      | field-address-ref       | Paragraphs                |
      | field-address-label     | Textfield                 |
      | field-location-info-ref | Paragraphs                |

  Scenario: Verify that the action_area paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "action_area" paragraph has the fields:
      | field                 | widget            |
      | field-area-action-ref | Paragraphs        |

  Scenario: Verify that the action_address paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "action_address" paragraph has the fields:
      | field         | widget                    |
      | field-address | Text area (multiple rows) |

  Scenario: Verify that the action_step paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "action_step" paragraph has the fields:
      | field                 | widget                    |
      | field-para-icon-term  | Select list               |
      | field-title           | Textfield                 |
      | field-content         | Text area (multiple rows) |

  Scenario: Verify that the action_step_numbered paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "action_step_numbered" paragraph has the fields:
      | field         | widget                    |
      | field-title   | Textfield                 |
      | field-content | Text area (multiple rows) |

  Scenario: Verify that the action_step_numbered_list paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "action_step_numbered_list" paragraph has the fields:
      | field                            | widget                    |
      | field-action-step-numbered-items | Paragraphs                |

  Scenario: Verify that the callout_link paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "callout_link" paragraph has the fields:
      | field      | widget |
      | field-link | Link   |

  Scenario: Verify that the file_download paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "file_download" paragraph has the fields:
      | field           | widget         |
      | field-downloads | Entity browser |

  Scenario: Verify that the full_bleed paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "full_bleed" paragraph has the fields:
      | field                 | widget                    |
      | field-full-bleed-ref  | Paragraphs                |

  Scenario: Verify that the iframe paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "iframe" paragraph has the fields:
      | field        | widget       |
      | field-url    | Link         |
      | field-height | Number field |

  Scenario: Verify that the rich_text paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "rich_text" paragraph has the fields:
      | field      | widget                    |
      | field-body | Text area (multiple rows) |

  Scenario: Verify that the stat paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "stat" paragraph has the fields:
      | field             | widget        |
      | field-stat        | Textfield     |
      | field-description | Textfield     |
      | field-alignment   | Select list   |

  Scenario: Verify that the slideshow paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "slideshow" paragraph has the fields:
      | field            | widget             |
      | field-slideshow  | Entity browser     |

  Scenario: Verify that the subhead paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "subhead" paragraph has the fields:
      | field       | widget        |
      | field-title | Textfield     |

  Scenario: Verify that the related_link paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "related_link" paragraph has the fields:
      | field             | widget     |
      | field-link        | Link       |
      | field-description | Textfield  |

