<?php

namespace Tests\Browser;

use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;



class newViaDentalChartTest extends coraBaseTest
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
    protected function setUp(): void
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
    public function tearDown(): void
    {
        session()->flush();

        parent::tearDown();
    }


    /**
     * Feature : Verifying the UI of New Via Dental Chart
     * Given The application is logged in successfully
     * And the user is on the home page
     * And user clicks on the side menu
     * And user clicks on Dental
     * And user clicks on New Via Dental Chart
     * When User fills in all the fields with valid information
     * And clicks on Save button
     * Then the inputs should be generated
     *
     *
     * @return void
     * @throws
     * @test
     * @group Sprint21
     * @group newViaDentalChartTest
     */
    public function newToothUITest()
    {
//        Test user login

        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(10000)
                //->assertSee('Welcome');

                // Skeletal elements search set up
                ->visit(new specimenPage)


                ->maximize()
                ->pause(3000)
                ->assertPresent('@leftSideBar-menu')
                ->assertVisible('@leftSideBar-menu')
                ->click('@leftSideBar-menu')
                ->pause(3000)
                ->assertPresent('@Dental')
                ->assertVisible('@Dental')
                ->click('@Dental')
                ->pause(1000)

//                Navigating to new via dental chart
                ->assertVisible('@New via Dental Chart')
                ->click('@New via Dental Chart')
                ->pause(500)

//              Filling in Valid information
//                ->assertVisible('@se-accession')
                ->click('@se-accession')
                ->keys('@se-accession', 'CIL 2003-116')
                ->keys('@se-accession','{enter}')

//             Filling in Valid information
                ->click('@se-provenance1')
                ->keys('@se-provenance1','G-01')
                ->keys('@se-provenance1','{enter}')
                ->pause(1000)

//            Filling in Valid information
//                ->assertVisible('@provenance2')
                ->click('@se-provenance2')
                ->keys('@se-provenance2','X-100')
                ->keys('@se-provenance2','{enter}')

//            Filling in Valid information
                ->click('@se-designator')
                ->keys('@se-designator','403')
                ->keys('@se-designator', '{enter}')

//               Filling in Valid information
//                ->click('@teeth')

//                Filling in Valid information
                ->click('@numbering-system')
                ->keys('@numbering-system','{arrow_down}')
                ->keys('@numbering-system','{enter}')
                ->pause(2000)

//                filling in valid information
                ->click('@tooth-selection')
                ->keys('@tooth-selection','{arrow_down}')
                ->keys('@tooth-selection','{enter}')


                ->click('@dental-codes')
                ->pause(1000)

//                Clicking on save button
                ->click('@save-button')
                ->pause(1000);


        });
    }
}

