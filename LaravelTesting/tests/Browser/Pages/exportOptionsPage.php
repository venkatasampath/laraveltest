<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class exportOptionsPage extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/exportOptions';
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

            // Export Dusk Tags
            '@export-button-1' => '[dusk="export-button-1"]',
            '@export-button-2' => '[dusk="export-button-2"]',
            '@export-button-3' => '[dusk="export-button-3"]',
            '@export-button-4' => '[dusk="export-button-4"]',
            '@export-button-5' => '[dusk="export-button-5"]',
            '@export-button-6' => '[dusk="export-button-6"]',
            '@export-button-7' => '[dusk="export-button-7"]',
            '@export-button-8' => '[dusk="export-button-8"]',
            '@export-button-9' => '[dusk="export-button-9"]',
            '@export-button-10' => '[dusk="export-button-10"]',
            '@export-button-11' => '[dusk="export-button-11"]',
            '@export-button-12' => '[dusk="export-button-12"]',
            '@export-button-13' => '[dusk="export-button-13"]',
            '@export-button-14' => '[dusk="export-button-14"]',
            '@export-button-15' => '[dusk="export-button-15"]',
            '@export-button-16' => '[dusk="export-button-16"]',
            '@export-button-17' => '[dusk="export-button-17"]',
            '@export-button-18' => '[dusk="export-button-18"]',
            '@export-button-19' => '[dusk="export-button-19"]',
            '@export-button-20' => '[dusk="export-button-20"]',
            '@export-button-21' => '[dusk="export-button-21"]',

            // Download Dusk Tags
            '@download-button-1' => '[dusk="download-button-1"]',
            '@download-button-2' => '[dusk="download-button-2"]',
            '@download-button-3' => '[dusk="download-button-3"]',
            '@download-button-4' => '[dusk="download-button-4"]',
            '@download-button-5' => '[dusk="download-button-5"]',
            '@download-button-6' => '[dusk="download-button-6"]',
            '@download-button-7' => '[dusk="download-button-7"]',
            '@download-button-8' => '[dusk="download-button-8"]',
            '@download-button-9' => '[dusk="download-button-9"]',
            '@download-button-10' => '[dusk="download-button-10"]',
            '@download-button-11' => '[dusk="download-button-11"]',
            '@download-button-12' => '[dusk="download-button-12"]',
            '@download-button-13' => '[dusk="download-button-13"]',
            '@download-button-14' => '[dusk="download-button-14"]',
            '@download-button-15' => '[dusk="download-button-15"]',
            '@download-button-16' => '[dusk="download-button-16"]',

            // Details Dusk Tags
            '@details-button-1' => '[dusk="details-button-1"]',
            '@details-button-2' => '[dusk="details-button-2"]',
            '@details-button-3' => '[dusk="details-button-3"]',
            '@details-button-4' => '[dusk="details-button-4"]',
            '@details-button-5' => '[dusk="details-button-5"]',
            '@details-button-6' => '[dusk="details-button-6"]',
            '@details-button-7' => '[dusk="details-button-7"]',
            '@details-button-8' => '[dusk="details-button-8"]',
            '@details-button-9' => '[dusk="details-button-9"]',
            '@details-button-10' => '[dusk="details-button-10"]',
            '@details-button-11' => '[dusk="details-button-11"]',
            '@details-button-12' => '[dusk="details-button-12"]',
            '@details-button-13' => '[dusk="details-button-13"]',
            '@details-button-14' => '[dusk="details-button-14"]',
            '@details-button-15' => '[dusk="details-button-15"]',
            '@details-button-16' => '[dusk="details-button-16"]',

            // Logout Buttons
            '@profile-picture' => '#profilePicture',
        ];
    }
    /**
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
            ->waitForText('Welcome to CoRA')
            ->waitForLocation('/')
            ->assertDontSee('Administration');
    }
}
