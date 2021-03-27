<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class exportFileManagerPage extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/exportFileManager';
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
            '@download-button' => '@download-button',
            '@details-button' => '@details-button',

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
