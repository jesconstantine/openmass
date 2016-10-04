<?php
/**
 * @file
 *
 * @copyright Copyright (c) 2016 Palantir.net
 */

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

  /**
   * @Then I should see the correct markup for the page banner
   */
  public function iShouldSeeTheCorrectMarkupForThePageBanner() {
    $this->assertRegionElement('div.ma__breadcrumbs__container', 'breadcrumbs');
    $this->assertRegionElement('style', 'page_banner');
    $this->assertRegionElement('div.ma__page-banner__icon', 'page_banner');
    $this->assertRegionElement('svg', 'page_banner');
    $this->assertRegionElement('h1.ma__page-banner__title', 'page_banner');
  }

  /**
   * @Then I should see the correct markup for the section links
   */
  public function iShouldSeeTheCorrectMarkupForTheSectionLinks() {
    $this->assertRegionElement('.ma__section-links__content', 'section_links');
    $this->assertRegionElement('.ma__section-links__icon', 'section_links');
    $this->assertRegionElement('.ma__section-links__title', 'section_links');
    $this->assertRegionElement('.ma__section-links__toggle-content', 'section_links');
    $this->assertRegionElement('.ma__section-links__title > a', 'section_links');
    $this->assertRegionElement('.ma__section-links__toggle-content > .ma__section-links__description', 'section_links');
    $this->assertRegionElement('.ma__section-links__toggle-content  h4.ma__section-links__mobile-title', 'section_links');
    $this->assertRegionElement('.ma__section-links__toggle-content  h4.ma__section-links__mobile-title > a', 'section_links');
  }
}
