<?php

/**
 * isotopeReport DuskTestCase
 *
 * @category   DuskTestCases
 * @package    CoRA-DuskTestCases
 * @author     Kyle Hampton <kthampton@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use App\User;

// 13 Total seComparison Cases
class seComparison extends coraBaseTest
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
     * A Dusk test for invalid user login
     *
     * @return void
     * @throws
     * @test
     * @group invalidUser
     */
    public function invalidUserAttempt()
    {
        $user = $this->testAccounts["invalid-user"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('These credentials do not match our records');
        });
    }
    /**
     * A Dusk test for isotope project report as Anthro analysis
     *
     * @return void
     * @throws
     * @test
     * @group seComparisonAnalyst
     * @group seComparisonReport
     */
    public function seComparisonReportAnalyst()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            // Pathology elements search set up
            $browser->visit(new specimenPage)
                ->maximize()
                ->pause(1000)
                ->press('@leftsidebar-expand')
                ->pause(1000)
                ->press('@project-reports')
                ->press('@seComparisons')
                ->assertSee('Specimen Comparison Report')
                ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@accession')
                ->type('abc')
                ->assertSee('No data available')
                ->keys('@accession', ['{ARROW_DOWN}'])
                ->keys('@accession', ['{ARROW_DOWN}'])
                ->pause(1000)


//                test to make sure the field is only accpeting valid inputs
                ->press('@provenance-1')
                ->type('abc')
                ->assertSee('No data available')
//                checking the provenance1 field
                ->keys('@provenance-1', ['{ARROW_DOWN}'])
                ->keys('@provenance-1', ['{ARROW_DOWN}'])
                ->keys('@provenance-1', ['{ENTER}'])
                ->pause(1000)


//                test to make sure the field is only accpeting valid inputs
                ->press('@provenance-2')
                ->type('abc')
                ->assertSee('No data available')
//                checking the provenance2 field
                ->type('@provenance-2', '-2')
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@bone')
                ->type('abc')
                ->assertSee('No data available')
//                checking the bone field
                ->input('@bone', 'Femur')
                ->keys('@bone', ['{ARROW_DOWN}'])
                ->keys('@bone', ['{Enter}'])

//                test to make sure the field is only accepting valid inputs
                ->press('@side')
                ->type('abc')
                ->assertSee('No data available')
//                checking the bone field
                ->input('@side', 'Left')
                ->keys('@side', ['{ARROW_DOWN}'])
                ->keys('@side', ['{Enter}'])


                ->logoutUser();
        });
    }

    /**
     * A Dusk test for isotope project report as Manager
     *
     * @return void
     * @throws
     * @test
     * @group seComparisonReportManager
     * @group seComparisonReport
     */
    public function seComparisonReportManager()
    {
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            // Pathology elements search set up
            $browser->visit(new specimenPage)
                ->maximize()
                ->pause(1000)
                ->press('@leftsidebar-expand')
                ->pause(1000)
                ->press('@project-reports')
                ->press('@seComparisons')
                ->assertSee('Specimen Comparison Report')
                ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@accession')
                ->type('abc')
                ->assertSee('No data available')
                ->keys('@accession', ['{ARROW_DOWN}'])
                ->keys('@accession', ['{ARROW_DOWN}'])
                ->pause(1000)


//                test to make sure the field is only accpeting valid inputs
                ->press('@provenance-1')
                ->type('abc')
                ->assertSee('No data available')
//                checking the provenance1 field
                ->keys('@provenance-1', ['{ARROW_DOWN}'])
                ->keys('@provenance-1', ['{ARROW_DOWN}'])
                ->keys('@provenance-1', ['{ENTER}'])
                ->pause(1000)


//                test to make sure the field is only accpeting valid inputs
                ->press('@provenance-2')
                ->type('abc')
                ->assertSee('No data available')
//                checking the provenance2 field
                ->type('@provenance-2', '-2')
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@bone')
                ->type('abc')
                ->assertSee('No data available')
//                checking the bone field
                ->input('@bone', 'Femur')
                ->keys('@bone', ['{ARROW_DOWN}'])
                ->keys('@bone', ['{Enter}'])

//                test to make sure the field is only accepting valid inputs
                ->press('@side')
                ->type('abc')
                ->assertSee('No data available')
//                checking the bone field
                ->input('@side', 'Left')
                ->keys('@side', ['{ARROW_DOWN}'])
                ->keys('@side', ['{Enter}'])


                ->logoutUser();
        });
    }

    /**
     * A Dusk test for isotope project report as Admin
     *
     * @return void
     * @throws
     * @test
     * @group isotopeProjectReportAdmin
     * @group isotopeProjectReport
     */
    public function isotopeProjectReportAdmin()
    {
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            // Pathology elements search set up
            $browser->visit(new specimenPage)
                ->maximize()
                ->pause(1000)
                ->press('@leftsidebar-expand')
                ->pause(1000)
                ->press('@project-reports')
                ->press('@seComparisons')
                ->assertSee('Specimen Comparison Report')
                ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@accession')
                ->type('abc')
                ->assertSee('No data available')
                ->keys('@accession', ['{ARROW_DOWN}'])
                ->keys('@accession', ['{ARROW_DOWN}'])
                ->pause(1000)


//                test to make sure the field is only accpeting valid inputs
                ->press('@provenance-1')
                ->type('abc')
                ->assertSee('No data available')
//                checking the provenance1 field
                ->keys('@provenance-1', ['{ARROW_DOWN}'])
                ->keys('@provenance-1', ['{ARROW_DOWN}'])
                ->keys('@provenance-1', ['{ENTER}'])
                ->pause(1000)


//                test to make sure the field is only accpeting valid inputs
                ->press('@provenance-2')
                ->type('abc')
                ->assertSee('No data available')
//                checking the provenance2 field
                ->type('@provenance-2', '-2')
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@bone')
                ->type('abc')
                ->assertSee('No data available')
//                checking the bone field
                ->input('@bone', 'Femur')
                ->keys('@bone', ['{ARROW_DOWN}'])
                ->keys('@bone', ['{Enter}'])

//                test to make sure the field is only accepting valid inputs
                ->press('@side')
                ->type('abc')
                ->assertSee('No data available')
//                checking the bone field
                ->input('@side', 'Left')
                ->keys('@side', ['{ARROW_DOWN}'])
                ->keys('@side', ['{Enter}'])


                ->logoutUser();
        });
    }

}