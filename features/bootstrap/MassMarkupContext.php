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
      $this->assertRegionElement('.ma__header__backto', 'header');
      $this->assertRegionElement('.ma__header__container > .ma__header__logo > .ma__site-logo > a', 'header');
      $this->assertRegionElement('nav.ma__header__nav > .ma__header__button-container > .ma__header__back-button', 'header');
      $this->assertRegionElement('nav.ma__header__nav > .ma__header__button-container > .ma__header__menu-button', 'header');
      $this->assertRegionElement('nav.ma__header__nav > .ma__header__nav-container > .ma__header__main-nav > .ma__main-nav > ul.ma__main-nav__items', 'header');
      $this->assertRegionElement('ul.ma__main-nav__items > li.ma__main-nav__item > a.ma__main-nav__top-link', 'header');
  }
}
