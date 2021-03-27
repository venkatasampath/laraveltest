<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class userManagementPage extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/users';
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
            '@save-button' => '[dusk="user-save"]',

            //user Management section elements
            '@organization' => '[dusk="user-organization"]',
            '@name' => '[dusk="user-name"]',
            '@email' => '[dusk="user-email"]',
            '@active' => '[dusk="user-active"]',
            '@role' => '[dusk="user-role"]',
            '@password' => '[dusk="user-password"]',
            '@password-confirm' => '[dusk="user-password_confirmation"]',
            '@password-fail' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form > div.form-group.has-error > div > input',
            '@login-email' => '#email', //'[dusk="login-email"]',
            '@login-password' => '#password', //'[dusk="login-password"]',
            '@search' => '#DataTables_Table_0_filter > label > input',
            '@searchtopresult' => '#DataTables_Table_0 > tbody > tr.odd > td.table-text.sorting_1 > div > a',
        ];
    }
}
