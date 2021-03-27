<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class notificationsPage extends BasePage
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
            '@profile-picture' => '#profilePicture',
            '@notifications-icon' => '[dusk="#notification-window > a > i"]',
            '@notifications-view-all' => '[dusk="#myDropdown > div.dropdownFooter > a"]',
            '@view-button-1' => '[dusk="view-button-1"]',
            '@view-button-2' => '[dusk="view-button-2"]',
            '@view-button-3' => '[dusk="view-button-3"]',
            '@view-button-4' => '[dusk="view-button-4"]',
            '@view-button-5' => '[dusk="view-button-5"]',

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
        $browser->click('@profile-picture')
            ->press('@logout-menu')
            ->waitForText('Welcome to CoRA')
            ->waitForLocation('/')
            ->assertDontSee('Administration');
    }
}
