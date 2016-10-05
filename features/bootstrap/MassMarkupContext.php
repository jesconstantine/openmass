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
  public function iShouldSeeTheCorrectMarkupForThePageBanner()
  {
    $this->assertRegionElement('div.ma__breadcrumbs__container', 'breadcrumbs');
    $this->assertRegionElement('style', 'page_banner');
    $this->assertRegionElement('div.ma__page-banner__icon', 'page_banner');
    $this->assertRegionElement('svg', 'page_banner');
    $this->assertRegionElement('h1.ma__page-banner__title', 'page_banner');
  }

  /**
   * @Then I should see the correct markup for the footer
   */
  public function iShouldSeeTheCorrectMarkupForTheFooter()
  {
      $this->assertRegionElement('button.ma__footer__back2top', 'footer');
      $this->assertRegionElement('.ma__footer__container > .ma__footer__nav', 'footer');
      $this->assertRegionElement('.ma__footer__info > .ma__footer__logo', 'footer');
      $this->assertRegionElement('.ma__footer__info > .ma__footer__social', 'footer');
      $this->assertRegionElement('.ma__footer__info > .ma__footer__copyright', 'footer');

  }

  /**
   * @Then I see the subtopic page markup
   */
  public function iSeeTheSubtopicPageMarkup()
  {
    $this->assertRegionElement('.ma__page-header__content > h1.ma__page-header__title', 'page_header');
    $this->assertRegionElement('.ma__page-header__content > h4.ma__page-header__sub-title', 'page_header');
    $this->assertRegionElement('.ma__page-header__content > .ma__page-header__intro > .ma__rich-text', 'page_header');
    $this->assertRegionElement('section.ma__action-finder .ma__action-finder__container', 'page_main');
    $this->assertRegionElement('section.ma__action-finder header.ma__action-finder__header > h2.ma__action-finder__title', 'page_main');
    $this->assertRegionElement('section.ma__action-finder .ma__action-finder__category', 'page_main');
    $this->assertRegionElement('section.ma__action-finder ul.ma__action-finder__items > li.ma__action-finder__item.ma__action-finder__item--text', 'page_main');
    $this->assertRegionElement('section.ma__link-list > .ma__link-list__container > h2.ma__link-list__title', 'page_main');
    $this->assertRegionElement('section.ma__link-list > .ma__link-list__container > ul.ma__link-list__items > li.ma__link-list__item > a.ma__link-list__link', 'page_main');
  }
}
