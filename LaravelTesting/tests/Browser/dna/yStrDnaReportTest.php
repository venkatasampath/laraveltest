<?php

namespace Tests\Browser;

use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;



class yStrDnaReportTest extends coraBaseTest
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
     * Feature : Verifying the UI of yStrDnaReport
     * Given The application is logged in successfully
     * And the user is on the home page
     * And user clicks on the side menu
     * And user clicks on DNA
     * And user clicks on yStrDnaReport
     * When User fills in all the fields with valid information
     * And clicks on Generate button
     * Then the report should be generated
     *
     *
     * @return void
     * @throws
     * @test
     * @group yStrDnaOrgAdminTest
     */
    public function yStrDnaOrgAdminTest()
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
                ->pause(2000)
                ->assertPresent('@leftSideBar-menu')
                ->assertVisible('@leftSideBar-menu')
                ->click('@leftSideBar-menu')
                ->pause(1000)
                ->assertPresent('@DNA')
                ->assertVisible('@DNA')
                ->click('@DNA')
                ->pause(1000)

//                Navigating to mito DNA report
                ->assertVisible('@yStr DNA Report')
                ->click('@yStr DNA Report')
                ->pause(500)

//              selecting accession number
                ->assertVisible('@accession')
                ->click('@accession')
                ->keys('@accession', 'CIL 2003-116')
                ->keys('@accession','{enter}')

//             selecting provenance1
                ->click('@dna_ystr_p1')
                ->keys('@dna_ystr_p1','G-01')
                ->keys('@dna_ystr_p1','{enter}')
                ->pause(1000)

//            selecting provenance2
//                ->assertVisible('@provenance2')
                ->click('@dna_ystr_p2')
                ->keys('@dna_ystr_p2','X-100')

//            selecting results status
                ->click('@dna_ystr_r')
                ->keys('@dna_ystr_r','Pending')
                ->keys('@dna_ystr_r', '{enter}')

//              selecting ystr sequence number
                ->assertVisible('@dna_ystr_seq')
                ->click('@dna_ystr_seq')
                ->keys('@dna_ystr_seq', '{arrow_down}')
                ->keys('@dna_ystr_seq','{enter}')
                ->pause(1000)

//             selecting ystr subsequence subgroup
                ->assertVisible('sequence-number')
                ->click('@dna_ystr_sub')
                ->keys('@dna_ystr_sub','{arrow_down}')
                ->keys('@dna_ystr_sub','{enter}')

//                selecting dates
//                ->click('@request-dates-from')
                ->keys('@request-dates-from', '2015-06-19')
                ->keys('@request-dates-from','{enter}')
                ->pause(1000)

//                selecting the dates
                ->keys('@dna_ystr_reqDT', '2017-09-10')
                ->keys('@dna_ystr_reqDT','{enter}')
                ->pause(1000)

                ->keys('@receive-date-start', '2019-10-19')
                ->keys('@receive-date-start', '{enter')
                ->pause(1000)

                ->keys('@receive-date-end', '2020-06-19')
                ->keys('@receive-date-end', '{enter')
                ->pause(1000)

//              clicking on generate button
                ->click('@generate-button')
                ->script('window.scrollTo(0,500);')
                ->pause(1000);




        });
    }
}

