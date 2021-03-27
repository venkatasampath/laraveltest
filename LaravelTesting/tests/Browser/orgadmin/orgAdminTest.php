<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\orgAdminPage;

class orgAdminTest extends DuskTestCase
{
    /**
     * Create a new LoginTest instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Delete cookies from each LoginTest instance.
     *
     * @return void
     */
    protected function setUp():void
    {
        parent::setUp();
        foreach (static::$browsers as $browser) {
            $browser->driver->manage()->deleteAllCookies();
        }
    }
    /**
     * Flush the session from each LoginTest instance.
     *
     * @return void
     */
    public function tearDown():void
    {
        session()->flush();

        parent::tearDown();
    }
    /**
     * A Dusk test to the about functions of the org admin profile.
     *
     * @return void
     * @throws
     * @test
     * @group OrgAdmin
     * @group UNO
     * @group OrgAdminAbout
     * @group AuthorKyle
     */
    public function OrgAdminAbout()
    {
        // Org Admin user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Org Admin set up and verification
            $browser->visit(new orgAdminPage)
                ->click('@profile-picture')
                ->click('@org-profiles-menu')
                ->pause(1000)
                ->assertSee('Org Profile')
                ->assertPathIs('/org/1/profile')
                ->assertSee('About')

                // Edit Org Admin About Settings
                ->clear('@name-text')
                ->type('@name-text','Mavericks')
                ->clear('@org-description')
                ->type('@org-description','Durango is the mascot')
                ->clear('@address')
                ->type('@address','456 Other St')
                ->clear('@city')
                ->type('@city','Council Bluffs')
                ->clear('@state')
                ->type('@state','IA')
                ->clear('@zip')
                ->type('@zip','68114')
                ->clear('@website')
                ->type('@website','unomaha.edu')
                ->clear('@phone')
                ->type('@phone','5551112233')
                ->clear('@tfphone')
                ->type('@tfphone','5554445566')
                ->clear('@fax')
                ->type('@fax','5557778899')
                ->clear('@lat')
                ->type('@lat','111.0000000')
                ->clear('@long')
                ->type('@long','999.0000000')
                ->click('@update_profile')

                // Assert Successful Edits
                ->pause(1000)
                ->assertSee('About')
                ->assertValue('@name-text','Mavericks')
                ->assertValue('@org-description','Durango is the mascot')
                ->assertValue('@address','456 Other St')
                ->assertValue('@city','Council Bluffs')
                ->assertValue('@state','IA')
                ->assertValue('@zip','68114')
                ->assertValue('@website','unomaha.edu')
                ->assertValue('@phone','555-111-2233')
                ->assertValue('@tfphone','555-444-5566')
                ->assertValue('@fax','555-777-8899')
                ->assertValue('@lat','111.0000000')
                ->assertValue('@long','999.0000000')

                // Change Org Admin About Settings to original values
                ->clear('@name-text')
                ->type('@name-text','University of Nebraska at Omaha')
                ->clear('@org-description')
                ->type('@org-description','There is no guarantee of a parking spot')
                ->clear('@address')
                ->type('@address','123 Fake Ave.')
                ->clear('@city')
                ->type('@city','Aceboogie')
                ->clear('@state')
                ->type('@state','NE')
                ->clear('@zip')
                ->type('@zip','61234')
                ->clear('@website')
                ->type('@website','heyheyhoho.com')
                ->clear('@phone')
                ->type('@phone','5321236532')
                ->clear('@tfphone')
                ->type('@tfphone','6534575435')
                ->clear('@fax')
                ->type('@fax','6543457543')
                ->clear('@lat')
                ->type('@lat','123.0000000')
                ->clear('@long')
                ->type('@long','543.0000000')
                ->click('@update_profile')

                // Assert Successful Changes
                ->pause(1000)
                ->assertSee('About')
                ->assertValue('@name-text','University of Nebraska at Omaha')
                ->assertValue('@org-description','There is no guarantee of a parking spot')
                ->assertValue('@address','123 Fake Ave.')
                ->assertValue('@city','Aceboogie')
                ->assertValue('@state','NE')
                ->assertValue('@zip','61234')
                ->assertValue('@website','heyheyhoho.com')
                ->assertValue('@phone','532-123-6532')
                ->assertValue('@tfphone','653-457-5435')
                ->assertValue('@fax','654-345-7543')
                ->assertValue('@lat','123.0000000')
                ->assertValue('@long','543.0000000')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the general functions of the org admin profile.
     *
     * @return void
     * @throws
     * @test
     * @group OrgAdmin
     * @group UNO
     * @group OrgAdminGeneral
     * @group AuthorKyle
     */
    public function OrgAdminGeneral()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Org Admin General set up and verification
            $browser->visit(new orgAdminPage)
                ->click('@profile-picture')
                ->click('@org-profiles-menu')
                ->pause(1000)
                ->assertSee('Org Profile')
                ->assertPathIs('/org/1/profile')
                ->click('@general-tab')
                ->assertSee('General')

                // Edit General Settings
                ->clear('@welcome-screen-url')
                ->type('@welcome-screen-url','asdfjkl;')
                ->click('@update-general')

                // Assert Successful Edits
                ->assertValue('@welcome-screen-url','asdfjkl;')

                // Revert General Settings to Original Values
                ->clear('@welcome-screen-url')
                ->type('@welcome-screen-url','ffqwefqweff')
                ->click('@update-general')

                // Assert Successful Reversion
                ->assertValue('@welcome-screen-url','ffqwefqweff')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the measurements functions of the org admin profile.
     *
     * @return void
     * @throws
     * @test
     * @group OrgAdmin
     * @group UNO
     * @group OrgAdminUnitsOfMeasure
     * @group AuthorKyle
     */
    public function OrgAdminUnitsOfMeasure()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Org Admin measurements set up and verification
            $browser->visit(new orgAdminPage)
                ->click('@profile-picture')
                ->click('@org-profiles-menu')
                ->pause(1000)
                ->assertSee('Org Profile')
                ->assertPathIs('/org/1/profile')
                ->click('@member-tab')
                ->assertSee('Units of Measure')

                // Edit measurements Settings
                ->select('@org-mass-unit-of-measure','grams')
                ->select('@org-length-unit-of-measure','inches')
                ->click('#list-members > h2')
                ->click('@update-profile')

                // Assert Successful Edits
                ->assertValue('@org-mass-unit-of-measure','grams')
                ->assertValue('@org-length-unit-of-measure','inches')

                // Revert measurements Settings to Original Values
                ->select('@org-mass-unit-of-measure','ounces')
                ->select('@org-length-unit-of-measure','cm')
                ->click('@update-profile')

                // Assert Successful Reversion
                ->assertValue('@org-mass-unit-of-measure','ounces')
                ->assertValue('@org-length-unit-of-measure','cm')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the localization functions of the org admin profile.
     *
     * @return void
     * @throws
     * @test
     * @group OrgAdmin
     * @group UNO
     * @group OrgAdminLocalization
     * @group AuthorKyle
     */
    public function OrgAdminLocalization()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Org Admin Localization set up and verification
            $browser->visit(new orgAdminPage)
                ->click('@profile-picture')
                ->click('@org-profiles-menu')
                ->pause(1000)
                ->assertSee('Org Profile')
                ->assertPathIs('/org/1/profile')
                ->click('@localization')
                ->assertSee('Localization')

                // Edit Localization Settings
                ->select('@default-country','NZ')
                ->select('@default-language','en')
                ->select('@default-timezone','America/Los_Angeles')
                ->click('@update-localization')

                // Assert Successful Edits
                ->assertValue('@default-country','NZ')
                ->assertValue('@default-language','en')
                ->assertValue('@default-timezone','America/Los_Angeles')

                // Revert Localization Settings to Original Values
                ->select('@default-country','US')
                ->select('@default-language','en')
                ->select('@default-timezone','America/Chicago')
                ->click('@update-localization')

                // Assert Successful Reversion
                ->assertValue('@default-country','US')
                ->assertValue('@default-language','en')
                ->assertValue('@default-timezone','America/Chicago')

                ->logoutUser();
        });
    }
}
