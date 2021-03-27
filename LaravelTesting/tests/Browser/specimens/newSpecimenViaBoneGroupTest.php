<?php

namespace Tests\Browser;

use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;



class newSpecimenViaBoneGroupTest extends coraBaseTest
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
     *
     *
     * @return void
     * @throws
     * @test
     * @group Sprint21
     * @group newSpecimenViaBoneGroup
     */
    public function newSpecimenViaBoneGroupTest()
    {
//        Test user login

        $user = $this->testAccounts["anthro-analyst"];
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
                ->assertPresent('@Specimen')
                ->assertVisible('@Specimen')
                ->click('@Specimen')
                ->pause(1000)

//                Navigating to new specimen via bone group
//                ->assertVisible('@New via Bone Group')
                ->click('@New via Bone Group')
                ->pause(2000)

//              Filling in Valid information
//                ->assertVisible('@se-accession')
                ->click('@se-bone-grouping')
                ->keys('@se-bone-grouping', '{arrow_down}')
                ->keys('@se-bone-grouping','{enter}')
                ->pause(3000)

//                Filling in Valid information
                ->click('@se-completeness')
                ->keys('@se-completeness','{arrow_down}')
                ->keys('@se-completeness','{enter}')
                ->pause(2000)

//                Clicking on next button
                ->click('@se-next')
                ->pause(2000)

//                entering accession number
                ->click('@se-accession')
                ->keys('@se-accession','{arrow_down}')
                ->keys('@se-accession','{enter}')
                ->pause(1000)

//                Filling in Valid information
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

//            Clicking on next button
                ->click('@se-next1')
                ->pause(2000)

//              selecting taphonomies
//                ->click('@se-taphonomys')
//                ->pause(500)
//                ->click('@se-taphonomy')
//                ->keys('@se-taphonomys','Adherent Materials-Aluminium')
//                ->keys('@se-taphonomys', '{arrow_down}')
//                ->keys('@se-taphonomys','{enter}')

//                selecting pathologies
//                ->click('@se-pathologys')
//                ->keys('@se-pathologys','{arrow_down}')
//                ->keys('@se-pathologys','{enter}')

//                ->click('@se-traumas')
//                ->keys('@se-traumas','{arrow_down}')
//                ->keys('@se-traumas','{enter}')
//                ->pause(2000)

//            clicking on save button
                ->click('@save-button')
                ->pause(2000);


        });
    }
}

