<?php

/**
 * LoginPage TestsBrowserPage
 *
 * @category   LoginPage
 * @package    CoRA-TestsBrowserPage
 * @author     Kyle Hampton <kthampton@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class loginPage extends homePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/login';
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
          '@email' => '#email',
          '@password' => '#password',



            // Logout Buttons
          '@profile-picture' => '[dusk="profile-img"]',
          '@logout-menu' => '[dusk="logout-menu"]',
        ];
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
            ->waitForText('Login')
            ->assertDontSee('Administration');
    }
 }
