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
   * @Then I should see the correct markup for the section links
   */
  public function iShouldSeeTheCorrectMarkupForTheSectionLinks()
  {
    $this->assertRegionElement('.ma__section-links__content', 'section_links');
    $this->assertRegionElement('.ma__section-links__icon', 'section_links');
    $this->assertRegionElement('.ma__section-links__title', 'section_links');
    $this->assertRegionElement('.ma__section-links__toggle-content', 'section_links');
    $this->assertRegionElement('.ma__section-links__title > a', 'section_links');
    $this->assertRegionElement('.ma__section-links__toggle-content > .ma__section-links__description', 'section_links');
    $this->assertRegionElement('.ma__section-links__toggle-content  h4.ma__section-links__mobile-title', 'section_links');
    $this->assertRegionElement('.ma__section-links__toggle-content  h4.ma__section-links__mobile-title > a', 'section_links');
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

  /**
   * @Then I should see the correct markup for the top actions
   */
  public function iShouldSeeTheCorrectMarkupForTheTopActions()
  {
    $this->assertRegionElement('h2.ma__top-actions__title', 'top_actions');
    $this->assertRegionElement('ul.ma__top-actions__items', 'top_actions');
    //$this->assertRegionElement('ul.ma__top-actions__items > li.ma__top-actions__item > div.ma__top-actions__link > div.ma__callout-link > span.ma__decorative-link > a.js-clickable-link', 'top_actions');
  }

  /**
   * @Then I should see the correct markup for the header search form
   */
  public function iShouldSeeTheCorrectMarkupForTheHeaderSearchForm()
  {
      $this->assertRegionElement('div.ma__header__search > section.ma__header-search > div#cse-header-search-form > div.gsc-control-searchbox-only > form.gsc-search-box > table.gsc-search-box > tbody > tr > td.gsc-input > input.gsc-input', 'header');

      $this->assertRegionElement('div.ma__header__search > section.ma__header-search > div#cse-header-search-form > div.gsc-control-searchbox-only > form.gsc-search-box > table.gsc-search-box > tbody > tr > td.gsc-search-button > input.gsc-search-button', 'header');
  }

  /**
   * @Then I should see the correct markup for the results search form
   */
  public function iShouldSeeTheCorrectMarkupForTheResultsSearchForm()
  {
      $this->assertRegionElement('div.ma__content__search > section.ma__content-search > div#cse-search-results-form > form.gsc-search-box > table.gsc-search-box > tbody > tr > td.gsc-input > input.gsc-input', 'page_pre');

      $this->assertRegionElement('div.ma__content__search > section.ma__content-search > div#cse-search-results-form > form.gsc-search-box > table.gsc-search-box > tbody > tr > td.gsc-search-button > input.gsc-search-button', 'page_pre');
  }

  /**
   * @Then I should see the correct markup for the search results
   */
  public function iShouldSeeTheCorrectMarkupForTheSearchResults()
  {
      $this->assertRegionElement('div#cse-search-results > div.gsc-control-cse > div.gsc-control-wrapper-cse  > div.gsc-results-wrapper-nooverlay > div.gsc-wrapper', 'search_results');
  }
}
