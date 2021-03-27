<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\notificationsPage;

class notificationsTest extends DuskTestCase
{
    /**
     * A Dusk test to the notifications feature for a test user.
     *
     * @return void
     * @throws
     * @test
     * @group Notifications
     * @group UNO
     * @group Notifications
     * @group AuthorKyle
     */
    public function Notifications()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Notifications set up and verification
            $browser->visit(new notificationsPage)
                //->click('@notifications-icon')
                ->click('#notification-window > a > i')
                ->click('#myDropdown > div.dropdownFooter > a > span')
                ->pause(1000)
                ->assertPathIs('/notifications')
                ->assertSee('Notifications')

                // Click into the first notification
                ->click('@view-button-1')
                ->pause(1000)
                ->assertSee('View Notifications')

                // Navigate back to the nortifications page
                ->click('#toggleAppContent > div > div > div.card-body > div > table > tbody > tr:nth-child(1) > td > table > tbody > tr > td > p:nth-child(7) > a')
                ->pause(1000)
                ->assertPathIs('/notifications')
                ->assertSee('Notifications')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the notifications feature for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Notifications
     * @group UNO
     * @group NotificationsManager
     * @group AuthorKyle
     */
    public function NotificationsManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Notifications set up and verification
            $browser->visit(new notificationsPage)
                //->click('@notifications-icon')
                ->click('#notification-window > a > i')
                ->click('#myDropdown > div.dropdownFooter > a > span')
                ->pause(1000)
                ->assertPathIs('/notifications')
                ->assertSee('Notifications')

                /*
                // Click into the first notification
                ->click('@view-button-1')
                ->pause(1000)
                ->assertSee('View Notifications')

                // Navigate back to the nortifications page
                ->click('#toggleAppContent > div > div > div.card-body > div > table > tbody > tr:nth-child(1) > td > table > tbody > tr > td > p:nth-child(7) > a'0)
                */
                ->pause(1000)
                ->assertPathIs('/notifications')
                ->assertSee('Notifications')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the notifications feature for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Notifications
     * @group UNO
     * @group NotificationsOrgAdmin
     * @group AuthorKyle
     */
    public function NotificationsOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Notifications set up and verification
            $browser->visit(new notificationsPage)
                //->click('@notifications-icon')
                ->click('#notification-window > a > i')
                ->click('#myDropdown > div.dropdownFooter > a > span')
                ->pause(1000)
                ->assertPathIs('/notifications')
                ->assertSee('Notifications')

                /*
                // Click into the first notification
                ->click('@view-button-1')
                ->pause(1000)
                ->assertSee('View Notifications')

                // Navigate back to the nortifications page
                ->click('#toggleAppContent > div > div > div.card-body > div > table > tbody > tr:nth-child(1) > td > table > tbody > tr > td > p:nth-child(7) > a')
                */
                ->pause(1000)
                ->assertPathIs('/notifications')
                ->assertSee('Notifications')
                ->logoutUser();
        });
    }
}
