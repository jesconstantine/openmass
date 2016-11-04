@api
Feature: Paragraph type definitions
  As a MassGov alpha content editor,
  I want to be able to add content for actions (a bedrock of the alpha release) for pre-determined journeys,
  so that I can help Bay Staters get the best information they need to fulfill basic tasks.

  Scenario: Verify that the action_area paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "action_area" paragraph has the fields:
      | field                 | widget            |
      | field-area-action-ref | Paragraphs        |

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

  Scenario: Verify that the icon paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "icon" paragraph has the fields:
      | field                | widget         |
      | field-title          | Textfield      |
      | field-para-icon-term | Select List    |

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

  Scenario: Verify that the quick_action paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "quick_action" paragraph has the fields:
      | field             | widget     |
      | field-link        | Link       |

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

  Scenario: Verify that the map paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "map" paragraph has the fields:
      | field       | widget                   |
      | field-map   | Google Map Field default |

  Scenario: Verify that the video paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "video" paragraph has the fields:
      | field                  | widget       |
      | field-video-caption    | Textfield    |
      | field-video-id         | Textfield    |
      | field-video-source     | Select list  |

  Scenario: Verify that the contact group paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "contact_group" paragraph has the fields:
      | field                      | widget      |
      | field-title                | Textfield   |
      | field-contact-info         | Paragraphs  |
      | field-contact-group-layout | Select list |

  Scenario: Verify that the contact info paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "contact_info" paragraph has the fields:
      | field         | widget      |
      | field-type    | Select list |
      | field-label   | Textfield   |
      | field-phone   | Telephone number       |
      | field-email   | Email       |
      | field-link    | Link        |
      | field-address | Text area (multiple rows)     |
      | field-caption | Textfield   |

  Scenario: Verify that the related_link paragraph type has the correct field configuration
    Given I am logged in as a user with the "administrator" role
    Then the "related_link" paragraph has the fields:
      | field             | widget     |
      | field-link        | Link       |
      | field-description | Textfield  |
