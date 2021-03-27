<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class orgAdminPage extends BasePage
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
            '@org-profiles-menu' => '[dusk="org-profiles-menu"]',

            // About Dusk Tags
            '@about-tab' => '[dusk="aboutTab"]',
            '@name-text' => '[dusk="name_text"]',
            '@org-acronym' => '[dusk="org_acronym"]',
            '@org-description' => '[dusk="org_description"]',
            '@address' => '[dusk="address"]',
            '@city' => '[dusk="city"]',
            '@state' => '[dusk="state"]',
            '@zip' => '[dusk="zip"]',
            '@website' => '[dusk="website"]',
            '@phone' => '[dusk="phone"]',
            '@tfphone' => '[dusk="tfphone"]',
            '@fax' => '[dusk="fax"]',
            '@lat' => '[dusk="lat"]',
            '@long' => '[dusk="long"]',
            '@update_profile' => '[dusk="update_profile"]',

            // General Dusk Tags
            '@general-tab' => '[dusk="generalTab"]',
            '@welcome-screen-url' => '[dusk="welcome_screen_url"]',
            '@update-general' => '[dusk="update_general"]',

            // Units of Measure Dusk Tags
            '@member-tab' => '[dusk="memberTab"]',
            '@org-mass-unit-of-measure' => '[dusk="org_mass_unit_of_measure"]',
            '@org-length-unit-of-measure' => '[dusk="org_length_unit_of_measure"]',
            //'@update-profile' => '[dusk="update_profile"]',
            '@update-profile' => '#measurements-submit',

            // Localization Dusk Tags
            '@localization' => '[dusk="localization"]',
            '@default-country' => '[dusk="default_country"]',
            '@default-language' => '[dusk="default_language"]',
            '@default-timezone' => '[dusk="default_timezone"]',
            '@update-localization' => '[dusk="update_localization"]',
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
