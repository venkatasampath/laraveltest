<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use App\User;


// 2 Total Test Case
class zoneReportTest extends coraBaseTest
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
     * @group ProjectZoneReport
     */
    public function LoginZoneTest()
    {
        $user = $this->testAccounts["anthro-analyst"];
//        $user = $this->testAccounts["org-admin"];
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
     * @group NegativeLoginZoneTest
     * @group ProjectZoneReport
     */
    public function NegativeLoginZoneTest()
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
     * @group ZoneReportTest
     * @group Zone
     * @group ProjectZoneReport
     */
    public function ZoneReportTest()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(10000)
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->click('@leftsidebar-expand')
                ->pause(1000)

                ->assertSee('Project Reports')
                ->click('@Project Reports')
                ->pause(1000)

                ->press('@zones')
                ->pause(1000)

                //reset fields
                ->maximize()
                ->pause(1000)


                ->clear('@se-zone-bone')
                ->type('@se-zone-bone', 'Accessory rib')
                ->pause(1000)
                ->keys('@se-zone-bone', ['{ENTER}'])
                ->pause(1000)



                //zone select
                ->assertPresent('@se-zone-zone')
                ->pause(5000)
                ->click('@se-zone-zoneTextCombo')
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ENTER}'])
                ->pause(3000)
                ->press('@reset-button')
                ->pause(2000)




                //filling all fields and generating report
                ->clear('@se-zone-accession')
                ->type('@se-zone-accession', 'CIL 2003-116')
                ->pause(1000)
                ->keys('@se-zone-accession', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-provenance1')
                ->type('@se-zone-provenance1', 'G-01')
                ->pause(1000)
                ->keys('@se-zone-provenance1', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-provenance2')
                ->type('@se-zone-provenance2', 'X-299C')
                ->pause(1000)
                ->keys('@se-zone-provenance2', ['{ENTER}'])
                ->pause(1000)



                ->clear('@se-zone-bone')
                ->type('@se-zone-bone', 'Accessory rib')
                ->pause(1000)
                ->keys('@se-zone-bone', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-side')
                ->type('@se-zone-side', 'Left')
                ->pause(1000)
                ->keys('@se-zone-side', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-search')
                ->keys('@se-zone-search', ['{ARROW_DOWN}'])
                ->pause(500)
                ->keys('@se-zone-search', ['{ARROW_DOWN}'])
                ->pause(500)
                ->keys('@se-zone-search', ['{ENTER}'])
                ->pause(2000)

                //zone based on bone select
                ->click('@se-zone-zoneTextCombo')
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ENTER}'])
                ->pause(1000)
                ->press('@generate-button')
                ->pause(2000)

                //collapse and check visibility
                ->press('@collapse-button')
                ->pause(4000)
                ->click('@column-visibility')
                ->pause(3000)



                //Negative test for fields with type-able values
                ->press('@collapse-button')
                ->pause(4000)
                ->press('@reset-button')
                ->type('@se-zone-accession', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->pause(1000)
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-provenance1', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-provenance2', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-bone', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-side', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-search', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)


                ->pause(5000);
        });
    }










    /**
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group ZoneReportOrgAdmin
     * @group Zone
     * @group ProjectZoneReport
     */
    public function ZoneReportOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(10000)
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->click('@leftsidebar-expand')
                ->pause(1000)

                ->assertSee('Project Reports')
                ->click('@Project Reports')
                ->pause(1000)

                ->press('@zones')
                ->pause(1000)

                //reset fields
                ->maximize()
                ->pause(1000)


                ->clear('@se-zone-bone')
                ->type('@se-zone-bone', 'Accessory rib')
                ->pause(1000)
                ->keys('@se-zone-bone', ['{ENTER}'])
                ->pause(1000)



                //zone select check box --> change to dusk selector after merge
                ->assertPresent('@se-zone-zone')
                ->pause(5000)
                ->click('@se-zone-zoneTextCombo')
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ENTER}'])
                ->pause(3000)
                ->press('@reset-button')
                ->pause(2000)




                //filling all fields and generating report
                ->clear('@se-zone-accession')
                ->type('@se-zone-accession', 'CIL 2003-116')
                ->pause(1000)
                ->keys('@se-zone-accession', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-provenance1')
                ->type('@se-zone-provenance1', 'G-01')
                ->pause(1000)
                ->keys('@se-zone-provenance1', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-provenance2')
                ->type('@se-zone-provenance2', 'X-299C')
                ->pause(1000)
                ->keys('@se-zone-provenance2', ['{ENTER}'])
                ->pause(1000)



                ->clear('@se-zone-bone')
                ->type('@se-zone-bone', 'Accessory rib')
                ->pause(1000)
                ->keys('@se-zone-bone', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-side')
                ->type('@se-zone-side', 'Left')
                ->pause(1000)
                ->keys('@se-zone-side', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-search')
                ->keys('@se-zone-search', ['{ARROW_DOWN}'])
                ->pause(500)
                ->keys('@se-zone-search', ['{ARROW_DOWN}'])
                ->pause(500)
                ->keys('@se-zone-search', ['{ENTER}'])
                ->pause(2000)

                //zone based on bone select
                ->click('@se-zone-zoneTextCombo')
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ENTER}'])
                ->pause(1000)
                ->press('@generate-button')
                ->pause(2000)

                //collapse and check visibility
                ->press('@collapse-button')
                ->pause(4000)
                ->click('@column-visibility')
                ->pause(3000)



                //Negative test for fields with type-able values
                ->press('@collapse-button')
                ->pause(4000)
                ->press('@reset-button')
                ->type('@se-zone-accession', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->pause(1000)
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-provenance1', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-provenance2', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-bone', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-side', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-search', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)


                ->pause(5000);
        });
    }









    /**
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group ZoneReportManager
     * @group Zone
     * @group ProjectZoneReport
     */
    public function ZoneReportManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(10000)
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->click('@leftsidebar-expand')
                ->pause(1000)

                ->assertSee('Project Reports')
                ->click('@Project Reports')
                ->pause(1000)

                ->press('@zones')
                ->pause(1000)

                //reset fields
                ->maximize()
                ->pause(1000)


                ->clear('@se-zone-bone')
                ->type('@se-zone-bone', 'Accessory rib')
                ->pause(1000)
                ->keys('@se-zone-bone', ['{ENTER}'])
                ->pause(1000)



                //zone select check box
                ->assertPresent('@se-zone-zone')
                ->pause(5000)
                ->click('@se-zone-zoneTextCombo')
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ENTER}'])
                ->pause(3000)
                ->press('@reset-button')
                ->pause(2000)




                //filling all fields and generating report
                ->clear('@se-zone-accession')
                ->type('@se-zone-accession', 'CIL 2003-116')
                ->pause(1000)
                ->keys('@se-zone-accession', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-provenance1')
                ->type('@se-zone-provenance1', 'G-01')
                ->pause(1000)
                ->keys('@se-zone-provenance1', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-provenance2')
                ->type('@se-zone-provenance2', 'X-299C')
                ->pause(1000)
                ->keys('@se-zone-provenance2', ['{ENTER}'])
                ->pause(1000)



                ->clear('@se-zone-bone')
                ->type('@se-zone-bone', 'Accessory rib')
                ->pause(1000)
                ->keys('@se-zone-bone', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-side')
                ->type('@se-zone-side', 'Left')
                ->pause(1000)
                ->keys('@se-zone-side', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-zone-search')
                ->keys('@se-zone-search', ['{ARROW_DOWN}'])
                ->pause(500)
                ->keys('@se-zone-search', ['{ARROW_DOWN}'])
                ->pause(500)
                ->keys('@se-zone-search', ['{ENTER}'])
                ->pause(2000)

                //zone based on bone select
                ->click('@se-zone-zoneTextCombo')
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-zone-zone', ['{ENTER}'])
                ->pause(1000)
                ->press('@generate-button')
                ->pause(2000)

                //collapse and check visibility
                ->press('@collapse-button')
                ->pause(4000)
                ->click('@column-visibility')
                ->pause(3000)



                //Negative test for fields with type-able values
                ->press('@collapse-button')
                ->pause(4000)
                ->press('@reset-button')
                ->type('@se-zone-accession', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->pause(1000)
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-provenance1', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-provenance2', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-bone', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-side', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)
                ->type('@se-zone-search', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->press('@reset-button')
                ->pause(1000)


                ->pause(5000);
        });
    }

}
