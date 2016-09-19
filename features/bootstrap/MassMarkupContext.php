<?php
use Palantirnet\PalantirBehatExtension\Context\MarkupContext;
/**
 * Defines markup features specific to Mass.gov.
 */
class MassMarkupContext extends MarkupContext
{
  /**
   * @Then I should see the correct markup for the header
   */
  public function iShouldSeeTheCorrectMarkupForTheHeader()
  {
      $this->assertRegionElement('.ma__header__skip-nav', 'header');

  }
}
