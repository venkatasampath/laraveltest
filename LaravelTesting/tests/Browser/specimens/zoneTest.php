<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use App\User;


// 2 Total Test Case
class zoneTest extends coraBaseTest
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
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group LoginZoneTest
     */
    public function LoginZoneTest()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');
        });
    }



    /**
     * A Dusk test to make sure invalid logins cannot access website
     *
     * @return void
     * @throws
     * @test
     * @group NegativeLoginZoneClassTest
     */
    public function NegativeLoginZoneClassTest()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser('invalidEmail@gmail.com', $user['password'])
                ->pause(3000)
                ->assertSee('These credentials do not match our records.');
        });
    }






    /**
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group ZoneCreateTest
     * @group Zone
     * @group ZoneClassification
     */
    public function ZoneCreateTest()
    {


        // Test user login//
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->pause(5000)
                ->loginUser($user['email'], $user['password'])
                ->pause(5000)
                ->assertSee('Welcome')
                ->pause(10000);

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(10000)
                ->maximize()
                ->clear('@cora-search-options')
                ->type('@cora-search-options', 'Bone')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(1000)

                ->keys('@cora-search-options-bones', 'Calcaneus', ['{ENTER}'])
                ->pause(1000)
                ->press('@search-btn')
                ->pause(1000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Calcaneus')
                ->waitForLink('CIL 2003-116:G-28:X-13A:501')
                ->assertSeeLink('CIL 2003-116:G-28:X-13A:501')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-28:X-13A:501')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(12000)
                ->assertSee('CIL 2003-116:G-28:X-13A:501')
                //go to the Zone Classification page
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ENTER}'])
                ->pause(2000)

                //uncheck all (checkbox), then reset
                ->keys('@edit-button', ['{ENTER}'])
                ->pause(2000)
                //uncheck all (checkbox)
                ->assertSee('Select All')
                ->pause(1000)
                ->check('@se-zone-checkbox')
                ->pause(2000)
                ->keys('@reset-button', ['{ENTER}'])
                ->pause(2000)
                ->keys('@edit-button', ['{ENTER}'])


                //collapse and uncollapse
                ->press('@se-zone-collapse')
                ->pause(1000)
                ->press('@se-zone-collapse')
                ->pause(1000)
                ->pause(4000)


                //Toggle switches. Update with dusk selector when working properly.
                ->assertSee('1 - Tuber calcis')
                ->check('@se-zone-Tuber-calcis')
                ->pause(1000)
                ->assertSee('2 - Distal portion of the body')
                ->check('@se-zone-Distal-portion-of-the-body')
                ->pause(1000)
                ->assertSee('4 - Proximal articulation')
                ->check('@se-zone-Proximal-articulation')
                ->pause(1000)
                ->assertSee('3 - Sustentaculum tali')
                ->check('@se-zone-Sustentaculum-tali')
                ->pause(1000)
                ->assertSee('5 - Proximal portion of the body')
                ->check('@se-zone-Proximal-portion-of-the-body')
                ->pause(1000)


                //uncheck all (individually)
                ->assertSee('1 - Tuber calcis')
                ->check('@se-zone-Tuber-calcis')
                ->pause(1000)
                ->assertSee('2 - Distal portion of the body')
                ->check('@se-zone-Distal-portion-of-the-body')
                ->pause(1000)
                ->assertSee('4 - Proximal articulation')
                ->check('@se-zone-Proximal-articulation')
                ->pause(1000)
                ->assertSee('3 - Sustentaculum tali')
                ->check('@se-zone-Sustentaculum-tali')
                ->pause(1000)
                ->assertSee('5 - Proximal portion of the body')
                ->check('@se-zone-Proximal-portion-of-the-body')
                ->pause(1000)

                //check all (checkbox)
                ->assertSee('Select All')
                ->check('@se-zone-select-all-checkbox')
                ->pause(1000)

                //Set back to original selections before save
                ->assertSee('1 - Tuber calcis')
                ->check('@se-zone-Tuber-calcis')
                ->pause(1000)
                ->assertSee('3 - Sustentaculum tali')
                ->check('@se-zone-Sustentaculum-tali')
                ->pause(1000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000);
        });
    }






    /**
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group ZoneCreateManager
     * @group Zone
     * @group ZoneClassification
     */
    public function ZoneCreateManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(10000)
                ->maximize()
                ->clear('@cora-search-options')
                ->type('@cora-search-options', 'Bone')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(1000)

                ->keys('@cora-search-options-bones', 'Calcaneus', ['{ENTER}'])
                ->pause(1000)
                ->press('@search-btn')
                ->pause(1000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Calcaneus')
                ->waitForLink('CIL 2003-116:G-28:X-13A:501')
                ->assertSeeLink('CIL 2003-116:G-28:X-13A:501')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-28:X-13A:501')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(12000)
                ->assertSee('CIL 2003-116:G-28:X-13A:501')
                //go to the Zone Classification page
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ENTER}'])
                ->pause(2000)

                //uncheck all (checkbox), then reset
                ->keys('@edit-button', ['{ENTER}'])
                ->pause(2000)
                //uncheck all (checkbox)
                ->assertSee('Select All')
                ->pause(1000)
                ->check('@se-zone-checkbox')
                ->pause(2000)
                ->keys('@reset-button', ['{ENTER}'])
                ->pause(2000)
                ->keys('@edit-button', ['{ENTER}'])


                //collapse and uncollapse
                ->press('@se-zone-collapse')
                ->pause(1000)
                ->press('@se-zone-collapse')
                ->pause(1000)
                ->pause(4000)

                //Toggle switches. Update with dusk selector when working properly.
                ->assertSee('1 - Tuber calcis')
                ->check('@se-zone-Tuber-calcis')
                ->pause(1000)
                ->assertSee('2 - Distal portion of the body')
                ->check('@se-zone-Distal-portion-of-the-body')
                ->pause(1000)
                ->assertSee('4 - Proximal articulation')
                ->check('@se-zone-Proximal-articulation')
                ->pause(1000)
                ->assertSee('3 - Sustentaculum tali')
                ->check('@se-zone-Sustentaculum-tali')
                ->pause(1000)
                ->assertSee('5 - Proximal portion of the body')
                ->check('@se-zone-Proximal-portion-of-the-body')
                ->pause(1000)


                //uncheck all (individually)
                ->assertSee('1 - Tuber calcis')
                ->check('@se-zone-Tuber-calcis')
                ->pause(1000)
                ->assertSee('2 - Distal portion of the body')
                ->check('@se-zone-Distal-portion-of-the-body')
                ->pause(1000)
                ->assertSee('4 - Proximal articulation')
                ->check('@se-zone-Proximal-articulation')
                ->pause(1000)
                ->assertSee('3 - Sustentaculum tali')
                ->check('@se-zone-Sustentaculum-tali')
                ->pause(1000)
                ->assertSee('5 - Proximal portion of the body')
                ->check('@se-zone-Proximal-portion-of-the-body')
                ->pause(1000)

                //check all (checkbox)
                ->assertSee('Select All')
                ->check('@se-zone-select-all-checkbox')
                ->pause(1000)

                //Set back to original selections before save
                ->assertSee('1 - Tuber calcis')
                ->check('@se-zone-Tuber-calcis')
                ->pause(1000)
                ->assertSee('3 - Sustentaculum tali')
                ->check('@se-zone-Sustentaculum-tali')
                ->pause(1000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000);
        });
    }






    /**
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group ZoneCreateOrgAdmin
     * @group Zone
     * @group ZoneClassification
     */
    public function ZoneCreateOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(10000)
                ->maximize()
                ->clear('@cora-search-options')
                ->type('@cora-search-options', 'Bone')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(1000)

                ->keys('@cora-search-options-bones', 'Calcaneus', ['{ENTER}'])
                ->pause(1000)
                ->press('@search-btn')
                ->pause(1000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Calcaneus')
                ->waitForLink('CIL 2003-116:G-28:X-13A:501')
                ->assertSeeLink('CIL 2003-116:G-28:X-13A:501')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-28:X-13A:501')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(12000)
                ->assertSee('CIL 2003-116:G-28:X-13A:501')
                //go to the Zone Classification page
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ARROW_DOWN}'])
                ->keys('@actions-button', ['{ENTER}'])
                ->pause(2000)

                //uncheck all (checkbox), then reset
                ->keys('@edit-button', ['{ENTER}'])
                ->pause(2000)
                //uncheck all (checkbox)
                ->assertSee('Select All')
                ->pause(1000)
                ->check('@se-zone-checkbox')
                ->pause(2000)
                ->keys('@reset-button', ['{ENTER}'])
                ->pause(2000)
                ->keys('@edit-button', ['{ENTER}'])


                //collapse and uncollapse
                ->press('@se-zone-collapse')
                ->pause(1000)
                ->press('@se-zone-collapse')
                ->pause(1000)
                ->pause(4000)

                //Toggle switches. Update with dusk selector when working properly.
                ->assertSee('1 - Tuber calcis')
                ->check('@se-zone-Tuber-calcis')
                ->pause(1000)
                ->assertSee('2 - Distal portion of the body')
                ->check('@se-zone-Distal-portion-of-the-body')
                ->pause(1000)
                ->assertSee('4 - Proximal articulation')
                ->check('@se-zone-Proximal-articulation')
                ->pause(1000)
                ->assertSee('3 - Sustentaculum tali')
                ->check('@se-zone-Sustentaculum-tali')
                ->pause(1000)
                ->assertSee('5 - Proximal portion of the body')
                ->check('@se-zone-Proximal-portion-of-the-body')
                ->pause(1000)


                //uncheck all (individually)
                ->assertSee('1 - Tuber calcis')
                ->check('@se-zone-Tuber-calcis')
                ->pause(1000)
                ->assertSee('2 - Distal portion of the body')
                ->check('@se-zone-Distal-portion-of-the-body')
                ->pause(1000)
                ->assertSee('4 - Proximal articulation')
                ->check('@se-zone-Proximal-articulation')
                ->pause(1000)
                ->assertSee('3 - Sustentaculum tali')
                ->check('@se-zone-Sustentaculum-tali')
                ->pause(1000)
                ->assertSee('5 - Proximal portion of the body')
                ->check('@se-zone-Proximal-portion-of-the-body')
                ->pause(1000)

                //check all (checkbox)
                ->assertSee('Select All')
                ->check('@se-zone-select-all-checkbox')
                ->pause(1000)

                //Set back to original selections before save
                ->assertSee('1 - Tuber calcis')
                ->check('@se-zone-Tuber-calcis')
                ->pause(1000)
                ->assertSee('3 - Sustentaculum tali')
                ->check('@se-zone-Sustentaculum-tali')
                ->pause(1000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000);
        });
    }
}
