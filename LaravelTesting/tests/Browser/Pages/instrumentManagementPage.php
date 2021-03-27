<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class instrumentManagementPage extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/instruments';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',

            //NAV bar elements
            '@administration-button' => '[dusk="administrator-menu"]',
            '@user-management-button' => '[dusk="administrator-user_management"]',
            '@project-management-button' =>'[dusk="administrator-project_management"]',
            '@accession-management-button' =>'[dusk="administrator-accession_management"]',
            '@instrument-management-button' => '[dusk="administrator-instrument_management"]',

            //Form menu elements
            '@actions-button' => '[dusk="actions-button"]',
            '@actions-all-menu' =>'[dusk="actions-all-menu"]',
            '@actions-create-menu' =>'[dusk="actions-create-menu"]',
            '@actions-edit-menu' =>'[dusk="actions-edit-menu"]',
            '@actions-discard-menu' =>'[dusk="actions-discard-changes-menu"]',
            '@login-button' => '[dusk="login-menu"]',
            '@user-menu' => '#app > header > nav > div > ul > li.nav-item.dropdown.headerMenuOptions > a',
            '@user-logout' => '[dusk="logout-menu"]',
            '@login-menu-button' => '[dusk="login-menu"]',
            '@save-button' => '[dusk="instrument-save"]',

            //user add/remove elements
            '@actions-user-add-button' => '[dusk="project-view"]',
            '@users-assigned-field' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form > div.col-lg-12.form-group.users > span > span.selection > span > ul',
            '@users-assigned-result-field' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form > div.col-lg-12.form-group.users > span > span.selection > span > ul > li.select2-search.select2-search--inline > input',
            '@users-assigned-remove-button' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form > div.col-lg-12.form-group.users > span > span.selection > span > ul > li.select2-selection__choice > span',

            //user Management section elements
            '@organizaiton' => '[dusk="instrument-org_name"]',
            '@code' => '[dusk="instrument-name"]',
            '@category' => '[dusk="instrument-category"]',
            '@module' => '[dusk="instrument-module"]',
            '@reference' => '[dusk="instrument-reference"]',
            '@search' => '#DataTables_Table_0_filter > label > input',
            '@searchtopresult' => '#DataTables_Table_0 > tbody > tr > td.table-text.sorting_1 > div > a',
            '@actions-save' => 'Save',

        ];
    }
}
