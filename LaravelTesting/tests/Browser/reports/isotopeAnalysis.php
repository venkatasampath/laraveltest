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
class isotopeAnalysis extends coraBaseTest
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
     * @group isotopeProjectReportAnalyst
     * @group isotopeProjectReport
     */
    public function isotopeProjectReportAnalyst()
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
                ->press('@isotopes')
                ->assertSee('Isotopes Report')
                ->pause(2000)

//                test to make sure the field is only accepting valid inputs
                ->press('@accession')
                ->type('abc')
                ->assertSee('No data available')
                ->keys('@accession', ['{ARROW_DOWN}'])
                ->keys('@accession', ['{Enter}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@provenance-1')
                ->type('abc')
                ->assertSee('No data available')
//                checking the provenance1 field
                ->keys('@provenance-1', ['{ARROW_DOWN}'])
                ->keys('@provenance-1', ['{ARROW_DOWN}'])
                ->keys('@provenance-1', ['{ENTER}'])
                ->pause(1000)


//                test to make sure the field is only accepting valid inputs
                ->press('@accession')
                ->type('abc')
                ->assertSee('No data available')
//                checking the provenance2 field
                ->type('@provenance-2', '-2')
                ->pause(1000)

//                checking the batch-id field
                ->press('@batch-id')
                ->assertSee('No data available')
                ->pause(2000)

//                test to make sure the field is only accepting valid inputs
                ->press('@collagen-yield-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Collagen Yield From field using keyboard arrow button
                ->keys('@collagen-yield-from', ['{ARROW_DOWN}'])
                ->keys('@collagen-yield-from', ['{ARROW_DOWN}'])
                ->keys('@collagen-yield-from', ['{ENTER}'])
                ->pause(2000)

//                test to make sure the field is only accepting valid inputs
                ->press('@collagen-yield-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Collagen Yield to field
                ->type('@collagen-yield-to', '2')
                ->pause(2000)

//                test to make sure the field is only accepting valid inputs
                ->press('@collagen-weight-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Collagen weight From field
                ->type('@collagen-weight-from', '3')
                ->pause(2000)

//                test to make sure the field is only accepting valid inputs
                ->press('@collagen-weight-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Collagen weight to field
                ->keys('@collagen-weight-to', ['{ARROW_DOWN}'])
                ->keys('@collagen-weight-to', ['{ARROW_DOWN}'])
                ->keys('@collagen-weight-to', ['{ARROW_DOWN}'])
                ->keys('@collagen-yield-to', ['{ENTER}'])
                ->pause(2000)

//                test to make sure the field is only accepting valid inputs
                ->press('@carbon-weight-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the carbon weight from field
                ->keys('@carbon-weight-from', ['{ARROW_DOWN}'])
                ->keys('@carbon-weight-from', ['{ARROW_DOWN}'])
                ->keys('@carbon-weight-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@carbon-weight-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the carbon weight to field
                ->type('@carbon-weight-to', '-1')
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@nitrogen-weight-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the nitrogen weight from field
                ->keys('@nitrogen-weight-from', ['{ARROW_DOWN}'])
                ->keys('@nitrogen-weight-from', ['{ARROW_DOWN}'])
                ->keys('@nitrogen-weight-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@nitrogen-weight-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the nitrogen weight to field
                ->keys('@nitrogen-weight-to', ['{ARROW_DOWN}'])
                ->keys('@nitrogen-weight-to', ['{ARROW_DOWN}'])
                ->keys('@nitrogen-weight-to', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@oxygen-weight-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the oxygen weight from field
                ->keys('@oxygen-weight-from', ['{ARROW_UP}'])
                ->keys('@oxygen-weight-from', ['{ARROW_UP}'])
                ->keys('@oxygen-weight-from', ['{ARROW_UP}'])
                ->keys('@oxygen-weight-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@oxygen-weight-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the oxygen weight TO field
                ->type('@oxygen-weight-to', '-4')
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@sulfur-weight-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the sulphur weight from field
                ->keys('@sulfur-weight-from', ['{ARROW_UP}'])
                ->keys('@sulfur-weight-from', ['{ARROW_UP}'])
                ->keys('@sulfur-weight-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@sulfur-weight-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the sulphur weight to field
                ->keys('@sulfur-weight-to', ['{ARROW_UP}'])
                ->keys('@sulfur-weight-to', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@carbon-percentage-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the carbon percentage from field
                ->keys('@carbon-percentage-from', ['{ARROW_UP}'])
                ->keys('@carbon-percentage-from', ['{ARROW_UP}'])
                ->keys('@carbon-percentage-from', ['{ARROW_UP}'])
                ->keys('@carbon-percentage-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@carbon-percentage-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the carbon percentage to field
                ->type('@carbon-percentage-to', '0')
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@nitrogen-percentage-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the nitrogen percentage from field
                ->keys('@nitrogen-percentage-from', ['{ARROW_UP}'])
                ->keys('@nitrogen-percentage-from', ['{ARROW_UP}'])
                ->keys('@nitrogen-percentage-from', ['{ARROW_UP}'])
                ->keys('@nitrogen-percentage-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@nitrogen-percentage-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the nitrogen percentage to field
                ->keys('@nitrogen-percentage-to', ['{ARROW_UP}'])
                ->keys('@nitrogen-percentage-to', ['{ARROW_UP}'])
                ->keys('@nitrogen-percentage-to', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@oxygen-percentage-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Oxygen Percentage From from field
                ->type('@oxygen-percentage-from', '-5')
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@oxygen-percentage-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Oxygen Percentage From to field
                ->keys('@oxygen-percentage-to', ['{ARROW_DOWN}'])
                ->keys('@oxygen-percentage-to', ['{ARROW_DOWN}'])
                ->keys('@oxygen-percentage-to', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@sulfur-percentage-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the sulphur Percentage from field
                ->keys('@sulfur-percentage-from', ['{ARROW_DOWN}'])
                ->keys('@sulfur-percentage-from', ['{ARROW_DOWN}'])
                ->keys('@sulfur-percentage-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@sulfur-percentage-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the sulphur Percentage to field
                ->type('@sulfur-percentage-to', '2')
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@carbon-to-nitrogen-ratio-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Carbon to Nitrogen Ratio From field
                ->keys('@carbon-to-nitrogen-ratio-from', ['{ARROW_DOWN}'])
                ->keys('@carbon-to-nitrogen-ratio-from', ['{ARROW_DOWN}'])
                ->keys('@carbon-to-nitrogen-ratio-from', ['{ARROW_DOWN}'])
                ->keys('@carbon-to-nitrogen-ratio-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@carbon-to-nitrogen-ratio-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Carbon to Nitrogen Ratio to field
                ->keys('@carbon-to-nitrogen-ratio-to', ['{ARROW_DOWN}'])
                ->keys('@carbon-to-nitrogen-ratio-to', ['{ARROW_DOWN}'])
                ->keys('@carbon-to-nitrogen-ratio-to', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@carbon-to-oxygen-ratio-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Carbon to oxygen Ratio From field
                ->type('@carbon-to-oxygen-ratio-from', '-1')
                ->pause(1000)

//                test to make sure the field is only accepting valid inputs
                ->press('@carbon-to-oxygen-ratio-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Carbon to oxygen Ratio to field
                ->keys('@carbon-to-oxygen-ratio-to', ['{ARROW_UP}'])
                ->keys('@carbon-to-oxygen-ratio-to', ['{ARROW_UP}'])
                ->keys('@carbon-to-oxygen-ratio-to', ['{ENTER}'])
                ->pause(1000)
                ->press('@generate-button')
                ->pause(10000)
                ->assertSee('Key')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Bone Group')
                ->assertSee('Individual Number')
                ->assertSee('Result Confidence')
                ->assertSee('Sample Number')
                ->assertSee('Collagen Yield')
                ->assertSee('Collagen Weight')
                ->assertSee('Carbon Weight')
                ->assertSee('Nitrogen Weight')
                ->assertSee('Oxygen Weight')
                ->assertSee('Sulfur Weight')
                ->assertSee('Carbon Percentage')
                ->assertSee('Nitrogen Percentage')
                ->assertSee('Sulfur Percentage')
                ->assertSee('Oxygen Percentage')
                ->assertSee('Carbon to Nitrogen Ratio')
                ->press('@reset-button')
                ->pause(1000)
                ->press('@collapse-button')
                ->pause(1000)
                ->logoutUser();
        });
    }

    /**
     * A Dusk test for isotope project report as Manager
     *
     * @return void
     * @throws
     * @test
     * @group isotopeProjectReportManager
     * @group isotopeProjectReport
     */
            public function isotopeProjectReportManager()
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
                        ->press('@isotopes')
                        ->assertSee('Isotopes Report')
                        ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@accession')
                        ->type('abc')
                        ->assertSee('No data available')
                        ->keys('@accession', ['{ARROW_DOWN}'])
                        ->keys('@accession', ['{Enter}'])
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
                        ->press('@accession')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the provenance2 field
                        ->type('@provenance-2', '-2')
                        ->pause(1000)

//                checking the batch-id field
                        ->press('@batch-id')
                        ->assertSee('No data available')
                        ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@collagen-yield-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the Collagen Yield From field using keyboard arrow button
                        ->keys('@collagen-yield-from', ['{ARROW_DOWN}'])
                        ->keys('@collagen-yield-from', ['{ARROW_DOWN}'])
                        ->keys('@collagen-yield-from', ['{ENTER}'])
                        ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@collagen-yield-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the Collagen Yield to field
                        ->type('@collagen-yield-to', '2')
                        ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@collagen-weight-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the Collagen weight From field
                        ->type('@collagen-weight-from', '3')
                        ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@collagen-weight-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the Collagen weight to field
                        ->keys('@collagen-weight-to', ['{ARROW_DOWN}'])
                        ->keys('@collagen-weight-to', ['{ARROW_DOWN}'])
                        ->keys('@collagen-weight-to', ['{ARROW_DOWN}'])
                        ->keys('@collagen-yield-to', ['{ENTER}'])
                        ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@carbon-weight-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the carbon weight from field
                        ->keys('@carbon-weight-from', ['{ARROW_DOWN}'])
                        ->keys('@carbon-weight-from', ['{ARROW_DOWN}'])
                        ->keys('@carbon-weight-from', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@carbon-weight-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the carbon weight to field
                        ->type('@carbon-weight-to', '-1')
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@nitrogen-weight-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the nitrogen weight from field
                        ->keys('@nitrogen-weight-from', ['{ARROW_DOWN}'])
                        ->keys('@nitrogen-weight-from', ['{ARROW_DOWN}'])
                        ->keys('@nitrogen-weight-from', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@nitrogen-weight-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the nitrogen weight to field
                        ->keys('@nitrogen-weight-to', ['{ARROW_DOWN}'])
                        ->keys('@nitrogen-weight-to', ['{ARROW_DOWN}'])
                        ->keys('@nitrogen-weight-to', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@oxygen-weight-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the oxygen weight from field
                        ->keys('@oxygen-weight-from', ['{ARROW_UP}'])
                        ->keys('@oxygen-weight-from', ['{ARROW_UP}'])
                        ->keys('@oxygen-weight-from', ['{ARROW_UP}'])
                        ->keys('@oxygen-weight-from', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@oxygen-weight-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the oxygen weight TO field
                        ->type('@oxygen-weight-to', '-4')
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@sulfur-weight-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the sulphur weight from field
                        ->keys('@sulfur-weight-from', ['{ARROW_UP}'])
                        ->keys('@sulfur-weight-from', ['{ARROW_UP}'])
                        ->keys('@sulfur-weight-from', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@sulfur-weight-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the sulphur weight to field
                        ->keys('@sulfur-weight-to', ['{ARROW_UP}'])
                        ->keys('@sulfur-weight-to', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@carbon-percentage-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the carbon percentage from field
                        ->keys('@carbon-percentage-from', ['{ARROW_UP}'])
                        ->keys('@carbon-percentage-from', ['{ARROW_UP}'])
                        ->keys('@carbon-percentage-from', ['{ARROW_UP}'])
                        ->keys('@carbon-percentage-from', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@carbon-percentage-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the carbon percentage to field
                        ->type('@carbon-percentage-to', '0')
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@nitrogen-percentage-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the nitrogen percentage from field
                        ->keys('@nitrogen-percentage-from', ['{ARROW_UP}'])
                        ->keys('@nitrogen-percentage-from', ['{ARROW_UP}'])
                        ->keys('@nitrogen-percentage-from', ['{ARROW_UP}'])
                        ->keys('@nitrogen-percentage-from', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@nitrogen-percentage-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the nitrogen percentage to field
                        ->keys('@nitrogen-percentage-to', ['{ARROW_UP}'])
                        ->keys('@nitrogen-percentage-to', ['{ARROW_UP}'])
                        ->keys('@nitrogen-percentage-to', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@oxygen-percentage-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the Oxygen Percentage From from field
                        ->type('@oxygen-percentage-from', '-5')
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@oxygen-percentage-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the Oxygen Percentage From to field
                        ->keys('@oxygen-percentage-to', ['{ARROW_DOWN}'])
                        ->keys('@oxygen-percentage-to', ['{ARROW_DOWN}'])
                        ->keys('@oxygen-percentage-to', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@sulfur-percentage-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the sulphur Percentage from field
                        ->keys('@sulfur-percentage-from', ['{ARROW_DOWN}'])
                        ->keys('@sulfur-percentage-from', ['{ARROW_DOWN}'])
                        ->keys('@sulfur-percentage-from', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@sulfur-percentage-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the sulphur Percentage to field
                        ->type('@sulfur-percentage-to', '2')
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@carbon-to-nitrogen-ratio-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the Carbon to Nitrogen Ratio From field
                        ->keys('@carbon-to-nitrogen-ratio-from', ['{ARROW_DOWN}'])
                        ->keys('@carbon-to-nitrogen-ratio-from', ['{ARROW_DOWN}'])
                        ->keys('@carbon-to-nitrogen-ratio-from', ['{ARROW_DOWN}'])
                        ->keys('@carbon-to-nitrogen-ratio-from', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@carbon-to-nitrogen-ratio-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the Carbon to Nitrogen Ratio to field
                        ->keys('@carbon-to-nitrogen-ratio-to', ['{ARROW_DOWN}'])
                        ->keys('@carbon-to-nitrogen-ratio-to', ['{ARROW_DOWN}'])
                        ->keys('@carbon-to-nitrogen-ratio-to', ['{ENTER}'])
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@carbon-to-oxygen-ratio-from')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the Carbon to oxygen Ratio From field
                        ->type('@carbon-to-oxygen-ratio-from', '-1')
                        ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                        ->press('@carbon-to-oxygen-ratio-to')
                        ->type('abc')
                        ->assertSee('No data available')
//                checking the Carbon to oxygen Ratio to field
                        ->keys('@carbon-to-oxygen-ratio-to', ['{ARROW_UP}'])
                        ->keys('@carbon-to-oxygen-ratio-to', ['{ARROW_UP}'])
                        ->keys('@carbon-to-oxygen-ratio-to', ['{ENTER}'])
                        ->pause(1000)


                        ->press('@generate-button')
                        ->pause(10000)
                        ->assertSee('Key')
                        ->assertSee('Bone')
                        ->assertSee('Side')
                        ->assertSee('Bone Group')
                        ->assertSee('Individual Number')
                        ->assertSee('Result Confidence')
                        ->assertSee('Sample Number')
                        ->assertSee('Collagen Yield')
                        ->assertSee('Collagen Weight')
                        ->assertSee('Carbon Weight')
                        ->assertSee('Nitrogen Weight')
                        ->assertSee('Oxygen Weight')
                        ->assertSee('Sulfur Weight')
                        ->assertSee('Carbon Percentage')
                        ->assertSee('Nitrogen Percentage')
                        ->assertSee('Sulfur Percentage')
                        ->assertSee('Oxygen Percentage')
                        ->assertSee('Carbon to Nitrogen Ratio')

                        ->press('@reset-button')
                        ->pause(1000)
                        ->press('@collapse-button')
                        ->pause(1000)
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
                ->press('@isotopes')
                ->assertSee('Isotopes Report')
                ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@accession')
                ->type('abc')
                ->assertSee('No data available')
                ->keys('@accession', ['{ARROW_DOWN}'])
                ->keys('@accession', ['{Enter}'])
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
                ->press('@accession')
                ->type('abc')
                ->assertSee('No data available')
//                checking the provenance2 field
                ->type('@provenance-2', '-2')
                ->pause(1000)

//                checking the batch-id field
                ->press('@batch-id')
                ->assertSee('No data available')
                ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@collagen-yield-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Collagen Yield From field using keyboard arrow button
                ->keys('@collagen-yield-from', ['{ARROW_DOWN}'])
                ->keys('@collagen-yield-from', ['{ARROW_DOWN}'])
                ->keys('@collagen-yield-from', ['{ENTER}'])
                ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@collagen-yield-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Collagen Yield to field
                ->type('@collagen-yield-to', '2')
                ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@collagen-weight-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Collagen weight From field
                ->type('@collagen-weight-from', '3')
                ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@collagen-weight-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Collagen weight to field
                ->keys('@collagen-weight-to', ['{ARROW_DOWN}'])
                ->keys('@collagen-weight-to', ['{ARROW_DOWN}'])
                ->keys('@collagen-weight-to', ['{ARROW_DOWN}'])
                ->keys('@collagen-yield-to', ['{ENTER}'])
                ->pause(2000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@carbon-weight-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the carbon weight from field
                ->keys('@carbon-weight-from', ['{ARROW_DOWN}'])
                ->keys('@carbon-weight-from', ['{ARROW_DOWN}'])
                ->keys('@carbon-weight-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@carbon-weight-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the carbon weight to field
                ->type('@carbon-weight-to', '-1')
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@nitrogen-weight-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the nitrogen weight from field
                ->keys('@nitrogen-weight-from', ['{ARROW_DOWN}'])
                ->keys('@nitrogen-weight-from', ['{ARROW_DOWN}'])
                ->keys('@nitrogen-weight-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@nitrogen-weight-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the nitrogen weight to field
                ->keys('@nitrogen-weight-to', ['{ARROW_DOWN}'])
                ->keys('@nitrogen-weight-to', ['{ARROW_DOWN}'])
                ->keys('@nitrogen-weight-to', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@oxygen-weight-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the oxygen weight from field
                ->keys('@oxygen-weight-from', ['{ARROW_UP}'])
                ->keys('@oxygen-weight-from', ['{ARROW_UP}'])
                ->keys('@oxygen-weight-from', ['{ARROW_UP}'])
                ->keys('@oxygen-weight-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@oxygen-weight-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the oxygen weight TO field
                ->type('@oxygen-weight-to', '-4')
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@sulfur-weight-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the sulphur weight from field
                ->keys('@sulfur-weight-from', ['{ARROW_UP}'])
                ->keys('@sulfur-weight-from', ['{ARROW_UP}'])
                ->keys('@sulfur-weight-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@sulfur-weight-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the sulphur weight to field
                ->keys('@sulfur-weight-to', ['{ARROW_UP}'])
                ->keys('@sulfur-weight-to', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@carbon-percentage-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the carbon percentage from field
                ->keys('@carbon-percentage-from', ['{ARROW_UP}'])
                ->keys('@carbon-percentage-from', ['{ARROW_UP}'])
                ->keys('@carbon-percentage-from', ['{ARROW_UP}'])
                ->keys('@carbon-percentage-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@carbon-percentage-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the carbon percentage to field
                ->type('@carbon-percentage-to', '0')
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@nitrogen-percentage-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the nitrogen percentage from field
                ->keys('@nitrogen-percentage-from', ['{ARROW_UP}'])
                ->keys('@nitrogen-percentage-from', ['{ARROW_UP}'])
                ->keys('@nitrogen-percentage-from', ['{ARROW_UP}'])
                ->keys('@nitrogen-percentage-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@nitrogen-percentage-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the nitrogen percentage to field
                ->keys('@nitrogen-percentage-to', ['{ARROW_UP}'])
                ->keys('@nitrogen-percentage-to', ['{ARROW_UP}'])
                ->keys('@nitrogen-percentage-to', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@oxygen-percentage-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Oxygen Percentage From from field
                ->type('@oxygen-percentage-from', '-5')
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@oxygen-percentage-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Oxygen Percentage From to field
                ->keys('@oxygen-percentage-to', ['{ARROW_DOWN}'])
                ->keys('@oxygen-percentage-to', ['{ARROW_DOWN}'])
                ->keys('@oxygen-percentage-to', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@sulfur-percentage-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the sulphur Percentage from field
                ->keys('@sulfur-percentage-from', ['{ARROW_DOWN}'])
                ->keys('@sulfur-percentage-from', ['{ARROW_DOWN}'])
                ->keys('@sulfur-percentage-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@sulfur-percentage-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the sulphur Percentage to field
                ->type('@sulfur-percentage-to', '2')
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@carbon-to-nitrogen-ratio-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Carbon to Nitrogen Ratio From field
                ->keys('@carbon-to-nitrogen-ratio-from', ['{ARROW_DOWN}'])
                ->keys('@carbon-to-nitrogen-ratio-from', ['{ARROW_DOWN}'])
                ->keys('@carbon-to-nitrogen-ratio-from', ['{ARROW_DOWN}'])
                ->keys('@carbon-to-nitrogen-ratio-from', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@carbon-to-nitrogen-ratio-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Carbon to Nitrogen Ratio to field
                ->keys('@carbon-to-nitrogen-ratio-to', ['{ARROW_DOWN}'])
                ->keys('@carbon-to-nitrogen-ratio-to', ['{ARROW_DOWN}'])
                ->keys('@carbon-to-nitrogen-ratio-to', ['{ENTER}'])
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@carbon-to-oxygen-ratio-from')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Carbon to oxygen Ratio From field
                ->type('@carbon-to-oxygen-ratio-from', '-1')
                ->pause(1000)

//                test to make sure the field is only accpeting valid inputs
                ->press('@carbon-to-oxygen-ratio-to')
                ->type('abc')
                ->assertSee('No data available')
//                checking the Carbon to oxygen Ratio to field
                ->keys('@carbon-to-oxygen-ratio-to', ['{ARROW_UP}'])
                ->keys('@carbon-to-oxygen-ratio-to', ['{ARROW_UP}'])
                ->keys('@carbon-to-oxygen-ratio-to', ['{ENTER}'])
                ->pause(1000)


                ->press('@generate-button')
                ->pause(10000)
                ->assertSee('Key')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Bone Group')
                ->assertSee('Individual Number')
                ->assertSee('Result Confidence')
                ->assertSee('Sample Number')
                ->assertSee('Collagen Yield')
                ->assertSee('Collagen Weight')
                ->assertSee('Carbon Weight')
                ->assertSee('Nitrogen Weight')
                ->assertSee('Oxygen Weight')
                ->assertSee('Sulfur Weight')
                ->assertSee('Carbon Percentage')
                ->assertSee('Nitrogen Percentage')
                ->assertSee('Sulfur Percentage')
                ->assertSee('Oxygen Percentage')
                ->assertSee('Carbon to Nitrogen Ratio')

                ->press('@reset-button')
                ->pause(1000)
                ->press('@collapse-button')
                ->pause(1000)
                ->logoutUser();
        });
    }

}