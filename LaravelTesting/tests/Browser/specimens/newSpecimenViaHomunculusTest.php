<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use App\User;


// 2 Total Test Case
class newSpecimenViaHomunculusTest extends coraBaseTest
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
     * @group LoginNewHomunculusTest
     */
    public function LoginNewHomunculusTest()
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
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group newSpecimenViaHomunculusOrgAdmin
     */
    public function newSpecimenViaHomunculusOrgAdmin()
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


                ->maximize()
                ->pause(2000)
                ->assertPresent('@leftsidebar-expand')
                ->assertVisible('@leftsidebar-expand')
                ->click('@leftsidebar-expand')
                ->pause(1000)
                ->visit('/skeletalelements/createbygroup')
//                ->assertVisible('New via Homunculus')
//                ->click('@New via Homunculus')
                ->pause(1000)
                ->pause(1000)




                ->click('@se-bone-grouping')
                ->keys('@se-bone-grouping', ['{ARROW_DOWN}'])
                ->keys('@se-bone-grouping', ['{ARROW_DOWN}'])
                ->keys('@se-bone-grouping',['{ENTER}'])
                ->pause(5000)



                //side
                ->click('@se-side')
                ->pause(2000)
                ->keys('@se-side', ['{ARROW_DOWN}'])
                ->pause(300)
                ->keys('@se-side', ['{ARROW_DOWN}'])
                ->pause(300)
                ->keys('@se-side', ['{ARROW_DOWN}'])
                ->pause(300)
                ->keys('@se-side', ['{ENTER}'])
                ->pause(2000)


                ->click('@se-completeness')
                ->pause(2000)
                ->keys('@se-completeness', ['{ARROW_DOWN}'])
                ->pause(300)
                ->keys('@se-completeness', ['{ARROW_DOWN}'])
                ->pause(300)
                ->keys('@se-completeness', ['{ENTER}'])
                ->pause(2000)


                ->pause(2000)

                ->assertVisible('@se-next')
                ->click('@se-next')
                ->pause(2000)
                ->pause(2000)

                ->click('@se-accession')
                ->pause(300)
                ->keys('@se-accession', ['{ARROW_DOWN}'])
                ->pause(300)
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)


                ->click('@se-provenance1')
                ->pause(300)
                ->keys('@se-provenance1', ['{ARROW_DOWN}'])
                ->pause(300)
                ->keys('@se-provenance1', ['{ENTER}'])
                ->pause(2000)

                ->click('@se-provenance2')
                ->pause(300)
                ->keys('@se-provenance2', ['{ARROW_DOWN}'])
                ->pause(300)
                ->keys('@se-provenance2', ['{ENTER}'])
                ->pause(2000)




                ->type('@se-designator', '403')
                ->keys('@se-designator', ['{ENTER}'])
                ->pause(2000)


                ->assertVisible('@se-next1')
                ->click('@se-next1')
                ->pause(2000)

                ->assertVisible('@save-button')
                ->click('@save-button')
                ->pause(2000);
        });
    }
}
