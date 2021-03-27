<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use App\User;


// 2 Total Test Case
class traumaReportTest extends coraBaseTest
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
     * @group LoginTraumaTest
     * @group ProjectTraumaReport
     */
    public function LoginTraumaTest()
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
     * @group NegativeLoginTraumaTest
     * @group ProjectTraumaReport
     */
    public function NegativeLoginTraumaTest()
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
     * @group traumaReportTest
     * @group trauma
     * @group ProjectTraumaReport
     */
    public function traumaReportTest()
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


                ->press('@traumas')
                ->pause(1000)

                ->maximize()
                ->pause(1000)


                ->click('@se-trauma-select-new')
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ENTER}'])
                ->pause(2000)
                ->press('@reset-button')
                ->pause(1000)
                ->press('@edit-button')
                ->pause(1000)


                //generate report
                ->clear('@se-trauma-accession')
                ->type('@se-trauma-accession', '2016-230')
                ->pause(1000)
                ->keys('@se-trauma-accession', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-trauma-provenance1')
                ->type('@se-trauma-provenance1', 'X-134')
                ->pause(1000)
                ->keys('@se-trauma-provenance1', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-trauma-provenance2')
                ->type('@se-trauma-provenance2', '')
                ->pause(1000)
                ->keys('@se-trauma-provenance2', ['{ENTER}'])
                ->pause(1000)



                ->clear('@se-trauma-bone')
                ->type('@se-trauma-bone', 'Humerus')
                ->pause(1000)
                ->keys('@se-trauma-bone', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-trauma-side')
                ->type('@se-trauma-side', 'Left')
                ->pause(1000)
                ->keys('@se-trauma-side', ['{ENTER}'])
                ->pause(1000)

                ->click('@se-trauma-select-new')
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ENTER}'])
                ->pause(2000)

                ->pause(2000)
                ->press('@generate-button')
                ->pause(2000)

                //collapse
                ->press('@collapse-button')
                ->pause(4000)

                ->click('@column-visibility')
                ->pause(1000)

                ->pause(15000);
        });
    }










    /**
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group traumaReportOrgAdmin
     * @group trauma
     * @group ProjectTraumaReport
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

                ->press('@traumas')
                ->pause(1000)

                //reset fields
                ->maximize()
                ->pause(1000)

                ->click('@se-trauma-select-new')
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ENTER}'])
                ->pause(2000)
                ->press('@reset-button')
                ->pause(1000)
                ->press('@edit-button')
                ->pause(1000)


                //generate report
                ->clear('@se-trauma-accession')
                ->type('@se-trauma-accession', '2016-230')
                ->pause(1000)
                ->keys('@se-trauma-accession', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-trauma-provenance1')
                ->type('@se-trauma-provenance1', 'X-134')
                ->pause(1000)
                ->keys('@se-trauma-provenance1', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-trauma-provenance2')
                ->type('@se-trauma-provenance2', '')
                ->pause(1000)
                ->keys('@se-trauma-provenance2', ['{ENTER}'])
                ->pause(1000)




                ->clear('@se-trauma-bone')
                ->type('@se-trauma-bone', 'Humerus')
                ->pause(1000)
                ->keys('@se-trauma-bone', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-trauma-side')
                ->type('@se-trauma-side', 'Left')
                ->pause(1000)
                ->keys('@se-trauma-side', ['{ENTER}'])
                ->pause(1000)

                ->click('@se-trauma-select-new')
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ENTER}'])
                ->pause(2000)

                ->pause(2000)
                ->press('@generate-button')
                ->pause(2000)

                //collapse
                ->press('@collapse-button')
                ->pause(4000)

                ->click('@column-visibility')
                ->pause(1000)

                ->pause(15000);
        });
    }









    /**
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group traumaReportManager
     * @group trauma
     * @group ProjectTraumaReport
     */
    public function traumaReportManager()
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
                ->pause(4000)

                ->assertSee('Project Reports')
                ->click('@Project Reports')
                ->pause(1000)

                ->press('@traumas')
                ->pause(1000)

                //reset fields
                ->maximize()
                ->pause(1000)

                ->click('@se-trauma-select-new')
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ENTER}'])
                ->pause(2000)
                ->press('@reset-button')
                ->pause(1000)
                ->press('@edit-button')
                ->pause(1000)


                //generate report
                ->clear('@se-trauma-accession')
                ->type('@se-trauma-accession', '2016-230')
                ->pause(1000)
                ->keys('@se-trauma-accession', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-trauma-provenance1')
                ->type('@se-trauma-provenance1', 'X-134')
                ->pause(1000)
                ->keys('@se-trauma-provenance1', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-trauma-provenance2')
                ->type('@se-trauma-provenance2', '')
                ->pause(1000)
                ->keys('@se-trauma-provenance2', ['{ENTER}'])
                ->pause(1000)




                ->clear('@se-trauma-bone')
                ->type('@se-trauma-bone', 'Humerus')
                ->pause(1000)
                ->keys('@se-trauma-bone', ['{ENTER}'])
                ->pause(1000)

                ->clear('@se-trauma-side')
                ->type('@se-trauma-side', 'Left')
                ->pause(1000)
                ->keys('@se-trauma-side', ['{ENTER}'])
                ->pause(1000)

                ->click('@se-trauma-select-new')
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ARROW_DOWN}'])
                ->keys('@se-trauma-select', ['{ENTER}'])
                ->pause(2000)

                ->pause(2000)
                ->press('@generate-button')
                ->pause(2000)

                //collapse
                ->press('@collapse-button')
                ->pause(4000)

                ->click('@column-visibility')
                ->pause(1000)

                ->pause(15000)
//                ->logoutUser();
            ;
        });
    }

}
