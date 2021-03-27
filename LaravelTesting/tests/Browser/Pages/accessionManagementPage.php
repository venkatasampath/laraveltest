<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class accessionManagementPage extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/accessions';
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
            '@save-button' => '[dusk="accession-save"]',

            //Accession Management page elements
            '@project' => '[dusk="accession-project"]',
            '@consolidated-check' => '[dusk="se-consolidated_an"]',
            '@number' => '[dusk="accession-number"]',
            '@provenance1' => '[dusk="accession-provenance1"]',
            '@provenance2' => '[dusk="accession-provenance2"]',
            '@search' => '#DataTables_Table_0_filter > label > input',
            '@searchtopresult' => '#DataTables_Table_0 > tbody > tr:nth-child(1) > td.table-text.sorting_1 > div > a',
        ];
    }
}
