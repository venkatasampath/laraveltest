<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;

class articulationReportTest extends coraBaseTest
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
     * A Dusk test to generate articulation report by Bone
     *
     * @return void
     * @throws
     * @test
     * @group articulationReport
     * @group articulationReportBone
     */
    public function articulationReportBone()
    {
        // Test user login

        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome')
                ->maximize()

                //Click on left menu
                ->click('@leftSideBar-menu')
                ->pause(2000)

                ->assertDontSee('reports')
                ->assertSee('Project Reports')
                ->pause(1000)
                ->visit('/reports/dashboard')
                ->pause(3000)
                //Report dashboard page
                ->assertSee('Project Reports Dashboard')
                ->assertSee('Articulations Report')
                //click articulation go button
                ->click('@articulations')
                ->pause(1000)
                ->click('@collapse-button')
                ->pause(2000)
                ->click('@collapse-button')
                ->assertSee('Accession Number')

                ->click('@bone-report')
                ->type('@bone-report', 'Clavicle')
                ->pause(1000)
                ->keys('@bone-report', ['{ENTER}'])
                ->pause(1000)
                ->click('@reset-button')
                ->pause(1000)
                ->click('@bone-report')
                ->type('@bone-report', 'Clavicle')
                ->pause(1000)
                ->keys('@bone-report', ['{ENTER}'])
                ->click('@bone-side-report')
                ->type('@bone-side-report', 'Left')
                ->keys('@bone-side-report', ['{ENTER}'])
                ->pause(1000)
                ->assertSee('Search for Specimens')

               ->pause(3000)
                ->click('@search-se-btn')
                ->pause(6000)
                ->assertSee('Specimens')
                ->click('@specimen-report')
                ->type('@specimen-report', 'CIL 2003-116:G-01:X-233E:601 :: Clavicle-Left')
                ->pause(1000)
                ->keys('@specimen-report', ['{ENTER}'])
                ->pause(3000)
                ->Click('@generate-button')
                ->pause(3000)
                ->Click('@column-visibility')
                ->pause(1000)
                ->assertSee('Created By')
                ->assertSee('Updated By')
                ->assertSee('Created By')

                ->pause(1000)
                ->assertSee('CIL 2003-116:G-29:X-254B:604')
                ->assertSee('Clavicle')
                ->assertSee('CIL 2003-116:G-29:X-254B:604')
                ->assertSee('Scapula')
                ->assertsee('Rows per page:')
                ->assertDontSee('Fibula')
                ->assertDontSee('aaa:G-29:X-254B:604')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to generate articulation report by Bone
     *
     * @return void
     * @throws
     * @test
     * @group articulationReport
     * @group articulationReportBoneManager
     */
    public function articulationReportBoneManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome')
                ->maximize()

                //Click on left menu
                ->click('@leftSideBar-menu')
                ->pause(2000)

                ->assertDontSee('reports')
                ->assertSee('Project Reports')
                ->pause(1000)
                ->visit('/reports/dashboard')
                ->pause(3000)
                //Report dashboard page
                ->assertSee('Project Reports Dashboard')
                ->assertSee('Articulations Report')
                //click articulation go button
                ->click('@articulations')
                ->pause(1000)
                ->click('@collapse-button')
                ->pause(2000)
                ->click('@collapse-button')
                ->assertSee('Accession Number')

                ->click('@bone-report')
                ->type('@bone-report', 'Clavicle')
                ->pause(1000)
                ->keys('@bone-report', ['{ENTER}'])
                ->pause(1000)
                ->click('@reset-button')
                ->pause(1000)
                ->click('@bone-report')
                ->type('@bone-report', 'Clavicle')
                ->pause(1000)
                ->keys('@bone-report', ['{ENTER}'])
                ->click('@bone-side-report')
                ->type('@bone-side-report', 'Left')
                ->keys('@bone-side-report', ['{ENTER}'])
                ->pause(1000)
                ->assertSee('Search for Specimens')

                ->pause(3000)
                ->click('@search-se-btn')
                ->pause(6000)
                ->assertSee('Specimens')
                ->click('@specimen-report')
                ->type('@specimen-report', 'CIL 2003-116:G-01:X-233E:601 :: Clavicle-Left')
                ->pause(1000)
                ->keys('@specimen-report', ['{ENTER}'])
                ->pause(3000)
                ->Click('@generate-button')
                ->pause(3000)
                ->Click('@column-visibility')
                ->pause(1000)
                ->assertSee('Created By')
                ->assertSee('Updated By')
                ->assertSee('Created By')

                ->pause(1000)
                ->assertSee('CIL 2003-116:G-29:X-254B:604')
                ->assertSee('Clavicle')
                ->assertSee('CIL 2003-116:G-29:X-254B:604')
                ->assertSee('Scapula')
                ->assertsee('Rows per page:')
                ->assertDontSee('Fibula')
                ->assertDontSee('aaa:G-29:X-254B:604')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to generate articulation report by Bone
     *
     * @return void
     * @throws
     * @test
     * @group articulationReport
     * @group articulationReportBoneAdmin
     */
    public function articulationReportBoneAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome')
                ->maximize()

                //Click on left menu
                ->click('@leftSideBar-menu')
                ->pause(2000)

                ->assertDontSee('reports')
                ->assertSee('Project Reports')
                ->pause(1000)
                ->visit('/reports/dashboard')
                ->pause(3000)
                //Report dashboard page
                ->assertSee('Project Reports Dashboard')
                ->assertSee('Articulations Report')
                //click articulation go button
                ->click('@articulations')
                ->pause(1000)
                ->click('@collapse-button')
                ->pause(2000)
                ->click('@collapse-button')
                ->assertSee('Accession Number')

                ->click('@bone-report')
                ->type('@bone-report', 'Clavicle')
                ->pause(1000)
                ->keys('@bone-report', ['{ENTER}'])
                ->pause(1000)
                ->click('@reset-button')
                ->pause(1000)
                ->click('@bone-report')
                ->type('@bone-report', 'Clavicle')
                ->pause(1000)
                ->keys('@bone-report', ['{ENTER}'])
                ->click('@bone-side-report')
                ->type('@bone-side-report', 'Left')
                ->keys('@bone-side-report', ['{ENTER}'])
                ->pause(1000)
                ->assertSee('Search for Specimens')

                ->pause(3000)
                ->click('@search-se-btn')
                ->pause(6000)
                ->assertSee('Specimens')
                ->click('@specimen-report')
                ->type('@specimen-report', 'CIL 2003-116:G-01:X-233E:601 :: Clavicle-Left')
                ->pause(1000)
                ->keys('@specimen-report', ['{ENTER}'])
                ->pause(3000)
                ->Click('@generate-button')
                ->pause(3000)
                ->Click('@column-visibility')
                ->pause(1000)
                ->assertSee('Created By')
                ->assertSee('Updated By')
                ->assertSee('Created By')

                ->pause(1000)
                ->assertSee('CIL 2003-116:G-29:X-254B:604')
                ->assertSee('Clavicle')
                ->assertSee('CIL 2003-116:G-29:X-254B:604')
                ->assertSee('Scapula')
                ->assertsee('Rows per page:')
                ->assertDontSee('Fibula')
                ->assertDontSee('aaa:G-29:X-254B:604')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to generate articulation report by Bone group
     *
     * @return void
     * @throws
     * @test
     * @group articulationReport
     * @group articulationReportBoneGroup
     */
    public function articulationReportBoneGroup()
    {
        // Test user login

        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome')
                ->maximize()

                //Click on left menu
                ->click('@leftSideBar-menu')
                ->pause(2000)

                ->assertDontSee('reports')
                ->assertSee('Project Reports')
                ->pause(1000)
                ->visit('/reports/dashboard')
                ->pause(2000)
                //Report dashboard page
                ->assertSee('Project Reports Dashboard')
                ->assertSee('Articulations Report')
                //click articulation go button
                ->click('@articulations')
                ->pause(1000)
                ->assertSee('Accession Number')

                ->click('@group-report')
                ->type('@group-report', 'Hand')
                ->keys('@group-report', ['{ENTER}'])
                ->pause(1000)
                ->click('@group-side-report')
                ->type('@group-side-report', 'Right')
                ->keys('@group-side-report', ['{ENTER}'])
                ->pause(1000)
                ->assertSee('Search for Specimens')

                ->pause(2000)
                ->click('@search-se-btn')
                ->pause(5000)
                ->assertSee('Specimens')
                ->click('@specimen-report')
                ->pause(2000)
                ->type('@specimen-report', 'CIL 2003-116:G-05:X-219C:304 :: Metacarpal 4-Right')
                ->pause(1000)
                ->keys('@specimen-report', ['{ENTER}'])
                ->pause(3000)
                ->Click('@generate-button')
                ->pause(3000)
                ->Click('@column-visibility')
                ->pause(1000)

                ->assertSee('Created By')
                ->assertSee('Updated By')
                ->assertSee('Created By')

                ->pause(1000)
                ->assertDontSee('CIL 2003-116:G-29:X-254B:604')
                ->assertDontSee('Clavicle')
                ->assertDontSee('CIL 2003-116:G-29:X-254B:604')
                ->assertDontSee('Scapula')

                ->assertSee('CIL 2003-116:G-05:X-219C:304')
                ->assertSee('Metacarpal 4')
                ->assertSee('CIL 2003-116:G-05:X-219C:306')
                ->assertSee('Metacarpal 5')

                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to generate articulation report by Bone group
     *
     * @return void
     * @throws
     * @test
     * @group articulationReport
     * @group articulationReportBoneGroupManager
     */
    public function articulationReportBoneGroupManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome')
                ->maximize()

                //Click on left menu
                ->click('@leftSideBar-menu')
                ->pause(2000)
                ->assertDontSee('reports')
                ->assertSee('Project Reports')
                ->pause(1000)
                ->visit('/reports/dashboard')
                ->pause(2000)
                //Report dashboard page
                ->assertSee('Project Reports Dashboard')
                ->assertSee('Articulations Report')
                //click articulation go button
                ->click('@articulations')
                ->pause(1000)
                ->assertSee('Accession Number')

                ->click('@group-report')
                ->type('@group-report', 'Hand')
                ->keys('@group-report', ['{ENTER}'])
                ->pause(1000)
                ->click('@group-side-report')
                ->type('@group-side-report', 'Right')
                ->keys('@group-side-report', ['{ENTER}'])
                ->pause(1000)
                ->assertSee('Search for Specimens')

                ->pause(2000)
                ->click('@search-se-btn')
                ->pause(5000)
                ->assertSee('Specimens')
                ->click('@specimen-report')
                ->pause(2000)
                ->type('@specimen-report', 'CIL 2003-116:G-05:X-219C:304 :: Metacarpal 4-Right')
                ->pause(1000)
                ->keys('@specimen-report', ['{ENTER}'])
                ->pause(3000)
                ->Click('@generate-button')
                ->pause(3000)
                ->Click('@column-visibility')
                ->pause(1000)

                ->assertSee('Created By')
                ->assertSee('Updated By')
                ->assertSee('Created By')

                ->pause(1000)
                ->assertDontSee('CIL 2003-116:G-29:X-254B:604')
                ->assertDontSee('Clavicle')
                ->assertDontSee('CIL 2003-116:G-29:X-254B:604')
                ->assertDontSee('Scapula')

                ->assertSee('CIL 2003-116:G-05:X-219C:304')
                ->assertSee('Metacarpal 4')
                ->assertSee('CIL 2003-116:G-05:X-219C:306')
                ->assertSee('Metacarpal 5')

                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to generate articulation report by Bone group
     *
     * @return void
     * @throws
     * @test
     * @group articulationReport
     * @group articulationReportBoneGroupAdmin
     */
    public function articulationReportBoneGroupAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome')
                ->maximize()

                //Click on left menu
                ->click('@leftSideBar-menu')
                ->pause(2000)
              
                ->assertDontSee('reports')
                ->assertSee('Project Reports')
                ->pause(1000)
                ->visit('/reports/dashboard')
                ->pause(2000)
                //Report dashboard page
                ->assertSee('Project Reports Dashboard')
                ->assertSee('Articulations Report')
                //click articulation go button
                ->click('@articulations')
                ->pause(1000)
                ->assertSee('Accession Number')

                ->click('@group-report')
                ->type('@group-report', 'Hand')
                ->keys('@group-report', ['{ENTER}'])
                ->pause(1000)
                ->click('@group-side-report')
                ->type('@group-side-report', 'Right')
                ->keys('@group-side-report', ['{ENTER}'])
                ->pause(1000)
                ->assertSee('Search for Specimens')

                ->pause(2000)
                ->click('@search-se-btn')
                ->pause(5000)
                ->assertSee('Specimens')
                ->click('@specimen-report')
                ->pause(2000)
                ->type('@specimen-report', 'CIL 2003-116:G-05:X-219C:304 :: Metacarpal 4-Right')
                ->pause(1000)
                ->keys('@specimen-report', ['{ENTER}'])
                ->pause(3000)
                ->Click('@generate-button')
                ->pause(3000)
                ->Click('@column-visibility')
                ->pause(1000)

                ->assertSee('Created By')
                ->assertSee('Updated By')
                ->assertSee('Created By')

                ->pause(1000)
                ->assertDontSee('CIL 2003-116:G-29:X-254B:604')
                ->assertDontSee('Clavicle')
                ->assertDontSee('CIL 2003-116:G-29:X-254B:604')
                ->assertDontSee('Scapula')

                ->assertSee('CIL 2003-116:G-05:X-219C:304')
                ->assertSee('Metacarpal 4')
                ->assertSee('CIL 2003-116:G-05:X-219C:306')
                ->assertSee('Metacarpal 5')

                ->pause(1000)


                ->logoutUser();
        });
    }
}