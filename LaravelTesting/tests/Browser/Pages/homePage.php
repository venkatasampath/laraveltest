<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class homePage extends page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
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
            '@refresh-dashboard' => '#dashboard > div:nth-child(1) > div > div.float-right.col-4 > span > input',
            '@cora-home' => '#app > header > nav > a',
            //'@sidebar-collapse' => '[dusk="rightSideBar-menu"]',
            '@sidebar-collapse' => '#sidebarCollapse',
            '@dashboard-home' => '[dusk="dashboard"]',
            '@se-menu' => '@se-menu',
            '@se-search' => '@se-search',
            '@se-new' => '@se-new',
            '@se-reports-dashboard' => '@se-reports_dashboard',
            '@se-advance-search' => '@se-advance_search',
            '@dna-menu' => '@dna-menu',
            '@dna-search' => '@dna-search',
            '@dna-mtDNA' => '@dna-mtDNA',
            '@reports' => '#sidebar > ul > li:nth-child(4) > a',
            '@file-export' => '@file-export',
            '@file-import' => '@file-import',
            '@file-manager' => '@file-manager',

            '@cora-project-switcher' => '[dusk="cora-project-switcher"]',
            '@cora-project-switcher-button' => '[dusk="cora-project-switcher-button"]',
            '@search-type-selector' => '[dusk="cora-search-options"]',
            '@cora-search-options' => '[dusk="cora-search-options"]',
            '@cora-search' => '[dusk="cora-search"]',
            '@cora-search-button' => '[dusk="cora-search-button"]',


            //Dash Board Widgets

                //table links

                    //Speciman Summary Table
            '@specimen-summary-buna' => '[dusk="specimen_summary-buna"]',
            '@specimen-summary-cabanatuan' => '[dusk="specimen_summary-cabanatuan"]',
            '@specimen-summary-castelfiorentino' => '[dusk="specimen_summary-castelfiorentino"]',
            '@specimen_summary-enoura maru' => '[dusk="specimen_summary-enoura maru"]',
            '@specimen_summary-hürtgen forest' => '[dusk="specimen_summary-hürtgen forest"]',
            '@specimen_summary-kwp' => '[dusk="specimen_summary-kwp"]',
            '@specimen_summary-market garden' => '[dusk="specimen_summary-market garden"]',
            '@specimen_summary-ploesti' => '[dusk="specimen_summary-ploesti"]',
            '@specimen_summary-solomon islands' => '[dusk="specimen_summary-solomon islands"]',
            '@specimen_summary-southeast asia' => '[dusk="specimen_summary-southeast asia"]',
            '@specimen_summary-tarawa' => '[dusk="specimen_summary-tarawa"]',
            '@specimen_summary-uss arizona' => '[dusk="specimen_summary-uss arizona"]',
            '@specimen_summary-uss california' => '[dusk="specimen_summary-uss california"]',
            '@specimen_summary-uss nevada' => '[dusk="specimen_summary-uss nevada"]',
            '@specimen_summary-uss oklahoma' => '[dusk="specimen_summary-uss oklahoma"]',
            '@specimen_summary-uss west virginia' => '[dusk="specimen_summary-uss west virginia"]',
            '@specimen_summary-wake island' => '[dusk="specimen_summary-wake island"]',

                    //DNA Summary table
            '@dna-summary-buna' => '[dusk="dna_summary-buna"]',
            '@dna-summary-cabanatuan' => '[dusk="dna_summary-cabanatuan"]',
            '@dna-summary-castelfiorentino' => '[dusk="dna_summary-castelfiorentino"]',
            '@dna_summary-enoura maru' => '[dusk="dna_summary-enoura maru"]',
            '@dna_summary-hürtgen forest' => '[dusk="dna_summary-hürtgen forest"]',
            '@dna_summary-kwp' => '[dusk="dna_summary-kwp"]',
            '@dna_summary-market garden' => '[dusk="dna_summary-market garden"]',
            '@dna_summary-ploesti' => '[dusk="dna_summary-ploesti"]',
            '@dna_summary-solomon islands' => '[dusk="dna_summary-solomon islands"]',
            '@dna_summary-southeast asia' => '[dusk="dna_summary-southeast asia"]',
            '@dna_summary-tarawa' => '[dusk="dna_summary-tarawa"]',
            '@dna_summary-uss arizona' => '[dusk="dna_summary-uss arizona"]',
            '@dna_summary-uss california' => '[dusk="dna_summary-uss california"]',
            '@dna_summary-uss nevada' => '[dusk="dna_summary-uss nevada"]',
            '@dna_summary-uss oklahoma' => '[dusk="dna_summary-uss oklahoma"]',
            '@dna_summary-uss west virginia' => '[dusk="dna_summary-uss west virginia"]',
            '@dna_summary-wake island' => '[dusk="dna_summary-wake island"]',

                //Widget Buttons

                    //Pie Charts
            '@pie-complete-size' => '[dusk="complete: -size"]',
            '@pie-complete-donut' => '[dusk="complete: -donut"]',
            '@pie-complete-collapse' => '[dusk="complete: -collapse"]',
            '@pie-complete-close' => '[dusk="complete: -close"]',
            '@pie-complete-details' => '[dusk="complete: -details"]',

            '@pie-individual-assigned-size' => '[dusk="individual # assigned: -size"]',
            '@pie-individual-assigned-donut' => '[dusk="individual # assigned: -donut"]',
            '@pie-individual-assigned-collapse' => '[dusk="individual # assigned: -collapse"]',
            '@pie-individual-assigned-close' => '[dusk="individual # assigned: -close"]',
            '@pie-individual-assigned-details' => '[dusk="individual # assigned: -details"]',

            '@pie-dna-sampled-size' => '[dusk="dna sampled: -size"]',
            '@pie-dna-sampled-donut' => '[dusk="dna sampled: -donut"]',
            '@pie-dna-sampled-collapse' => '[dusk="dna sampled: -collapse"]',
            '@pie-dna-sampled-close' => '[dusk="dna sampled: -close"]',
            '@pie-dna-sampled-details' => '[dusk="dna sampled: -details"]',

            '@pie-dna-mito-results-size' => '[dusk="dna mito results: -size"]',
            '@pie-dna-mito-results-donut' => '[dusk="dna mito results: -donut"]',
            '@pie-dna-mito-results-collapse' => '[dusk="dna mito results: -collapse"]',
            '@pie-dna-mito-results-close' => '[dusk="dna mito results: -close"]',
            '@pie-dna-mito-results-details' => '[dusk="dna mito results: -details"]',

            '@pie-dna-ystr-results-size' => '[dusk="dna ystr results: -size"]',
            '@pie-dna-ystr-results-donut' => '[dusk="dna ystr results: -donut"]',
            '@pie-dna-ystr-results-collapse' => '[dusk="dna ystr results: -collapse"]',
            '@pie-dna-ystr-results-close' => '[dusk="dna ystr results: -close"]',
            '@pie-dna-ystr-results-details' => '[dusk="dna ystr results: -details"]',

            '@pie-dna-austr-results-size' => '[dusk="dna austr results: -size"]',
            '@pie-dna-austr-results-donut' => '[dusk="dna austr results: -donut"]',
            '@pie-dna-austr-results-collapse' => '[dusk="dna austr results: -collapse"]',
            '@pie-dna-austr-results-close' => '[dusk="dna austr results: -close"]',
            '@pie-dna-austr-results-details' => '[dusk="dna austr results: -details"]',

            '@pie-measured-size' => '[dusk="measured: -size"]',
            '@pie-measured-donut' => '[dusk="measured: -donut"]',
            '@pie-measured-collapse' => '[dusk="measured: -collapse"]',
            '@pie-measured-close' => '[dusk="measured: -close"]',
            '@pie-measured-details' => '[dusk="measured: -details"]',

            '@pie-ct-scanned-size' => '[dusk="ct scanned: -size"]',
            '@pie-ct-scanned-donut' => '[dusk="ct scanned: -donut"]',
            '@pie-ct-scanned-collapse' => '[dusk="ct scanned: -collapse"]',
            '@pie-ct-scanned-close' => '[dusk="ct scanned: -close"]',
            '@pie-ct-scanned-details' => '[dusk="ct scanned: -details"]',

            '@pie-xray-scanned-size' => '[dusk="xray scanned: -size"]',
            '@pie-xray-scanned-donut' => '[dusk="xray scanned: -donut"]',
            '@pie-xray-scanned-collapse' => '[dusk="xray scanned: -collapse"]',
            '@pie-xray-scanned-close' => '[dusk="xray scanned: -close"]',
            '@pie-xray-scanned-details' => '[dusk="xray scanned: -details"]',

            '@pie-clavicle-triangle-size' => '[dusk="clavicle triage: -size"]',
            '@pie-clavicle-triangle-donut' => '[dusk="clavicle triage: -donut"]',
            '@pie-clavicle-triangle-collapse' => '[dusk="clavicle triage: -collapse"]',
            '@pie-clavicle-triangle-close' => '[dusk="clavicle triage: -close"]',
            '@pie-clavicle-triangle-details' => '[dusk="clavicle triage: -details"]',

            '@pie-isotope-sampled-size' => '[dusk="isotope sampled: -size"]',
            '@pie-isotope-sampled-donut' => '[dusk="isotope sampled: -donut"]',
            '@pie-isotope-sampled-collapse' => '[dusk="isotope sampled: -collapse"]',
            '@pie-isotope-sampled-close' => '[dusk="isotope sampled: -close"]',
            '@pie-isotope-sampled-details' => '[dusk="isotope sampled: -details"]',

                    //Bar Charts
            '@bar-mito-sequences-collapse' => '[dusk="mito sequences-collapse"]',
            '@bar-mito-sequences-close' => '[dusk="mito sequences-close"]',
            '@bar-mito-sequences-details' => '[dusk="mito sequences-details"]',

            '@bar-frequency-bones-collapse' => '[dusk="frequency bones-collapse"]',
            '@bar-frequency-bones-close' => '[dusk="frequency bones-close"]',
            '@bar-frequency-bones-details' => '[dusk="frequency bones-details"]',

            '@bar-frequency-zones-collapse' => '[dusk="frequency zones-collapse"]',
            '@bar-frequency-zones-close' => '[dusk="frequency zones-close"]',
            '@bar-frequency-zones-details' => '[dusk="frequency zones-details"]',

                    //Stacked Bar Charts
            '@stacked-bar-mni-mito-bones-side-collapse' => '[dusk="mni mito bones & side-collapse"]',
            '@stacked-bar-mni-mito-bones-side-close' => '[dusk="mni mito bones & side-close"]',
            '@stacked-bar-mni-mito-bones-side-details' => '[dusk="mni mito bones & side-details"]',

            '@stacked-bar-mni-bones-side-collapse' => '[dusk="mni bones & side-collapse"]',
            '@stacked-bar-mni-bones-side-close' => '[dusk="mni bones & side-close"]',
            '@stacked-bar-mni-bones-side-details' => '[dusk="mni bones & side-details"]',

            '@stacked-bar-frequency-zones-side-collapse' => '[dusk="frequency zones & side-collapse"]',
            '@stacked-bar-frequency-zones-side-close' => '[dusk="frequency zones & side-close"]',
            '@stacked-bar-frequency-zones-side-details' => '[dusk="frequency zones & side-details"]',

                    //Line Chart
            '@line-specimens-collapse' => '[dusk="specimens-collapse"]',
            '@line-specimens-close' => '[dusk="specimens-close"]',
            '@line-specimens-details' => '[dusk="specimens-details"]',

            '@line-dnas-collapse' => '[dusk="dnas-collapse"]',
            '@line-dnas-close' => '[dusk="dnas-close"]',
            '@line-dnas-details' => '[dusk="dnas-details"]',

            //OrgAdmin Elements
            '@top_DNA_project' => '#dna > tbody > tr > td:nth-child(1) > a',
            '@top_SE_project' => '#se > tbody > tr > td:nth-child(1) > a',

            //Right Sidebar Elements
                //tab navigation
            '@right-sidebar' => '[dusk="right-sideBar-Menu"]',
            '@right-sb-layout' => '[dusk="theme-tab-menu"]',
            '@right-sb-media' => '[dusk="media-tab-menu"]',
            '@right-sb-help' => '[dusk="help-tab-menu"]',
            '@right-sb-feed' => '[dusk="home-tab-menu"]',
            '@right-sb-settings' => '[dusk="settings-tab-menu"]',


                //layout tab
            '@right-sb-layout-Ltoggle' => '[dusk="toggle-sidebar-expand"]',
            '@right-sb-layout-hover' => '[dusk="sidebar-expand-on_hover"]',
            '@right-sb-layout-Rtoggle' => '[dusk="toggle-rightSideBar-slide"]',
            '@right-sb-layout-skin' => '[dusk="toggle-rightSideBar-skin"]',
            '@right-sb-skin-bluedark' => '[dusk="blue-theme"]',
            '@right-sb-skin-blackdark' => '[dusk="black-theme"]',
            '@right-sb-skin-purpledark' => '[dusk="purple-theme"]',
            '@right-sb-skin-greendark' => '[dusk="green-theme"]',
            '@right-sb-skin-reddark' => '[dusk="red-theme"]',
            '@right-sb-skin-yellowdark' => '[dusk="yellow-theme"]',
            '@right-sb-skin-bluelight' => '[dusk="blue-light-theme"]',
            '@right-sb-skin-blacklight' => '[dusk="black-light-theme"]',
            '@right-sb-skin-purplelight' => '[dusk="purple-light-theme"]',
            '@right-sb-skin-greenlight' => '[dusk="green-light-theme"]',
            '@right-sb-skin-redlight' => '[dusk="red-light-theme"]',
            '@right-sb-skin-yellowlight' => '[dusk="yellow-light-theme"]',
                //activity feed tab
            '@right-sb-feed-se' => '#se_feed > tbody > tr > td:nth-child(1) > a',
            '@right-sb-feed-dna' => '#dna_feed > tbody > tr > td:nth-child(1) > a',
                //general setting tab
            '@right-sb-settings-lines' => '[dusk="lines_per_page"]',
            '@right-sb-settings-update-general' => '[dusk="update_general"]',
            '@right-sb-settings-accession' => '[dusk="accession"]',
            '@right-sb-settings-provenance1' => '[dusk="provenance1"]',
            '@right-sb-settings-provenance2' => '[dusk="provenance2"]',
            '@right-sb-settings-update-se' => '[dusk="update_projects-rightsidebar-se"]',
            '@right-sb-settings-lab' => '[dusk="default_laboratory"]',
            '@right-sb-settings-dna' => '[dusk="default_dna_method"]',
            '@right-sb-settings-update-dna' => '[dusk="update_projects"]',

            '@online-help' => '[dusk="onlineHelp"]',
            '@about_menu' => '[dusk="about-menu"]',

            // Logout Buttons
            '@profile-picture' => '[dusk="profile-img"]',
        ];
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        //
    }
    /**
     * Login a new user.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $email
     * @param  string  $password
     * @return void
     */
    public function loginUser(Browser $browser, $email, $password)
    {
        $browser->type('@email', $email)
            ->type('@password', $password)
            ->press('Login');
    }
    /*
    *
     * Logout a user.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function logoutUser(Browser $browser)
    {
        //$browser->click('#app > header > nav > div > ul > li.nav-item.dropdown > a > span')
        $browser->click('@profile-picture')
            ->press('@logout-menu')
            ->waitForText('Login')
            ->assertDontSee('Administration');
    }
}
