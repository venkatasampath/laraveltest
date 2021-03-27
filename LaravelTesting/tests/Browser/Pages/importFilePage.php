<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class importFilePage extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/importFile';
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

            // Import File Buttons
            '@import-type-select' => '[dusk="import-type-select"]',
            '@download-button' => '[dusk="download-button"]',
            '@browse-files' =>'[dusk="browse-files"]',
            //'@browse-Files' => '#browseFiles > div.row > div > div > label',
            '@upload-file-button' => '[dusk="upload-file-btn"]',

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
