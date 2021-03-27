<?php
/**
 * LoginTest DuskTestCase
 *
 * @category   DuskTestCases
 * @package    CoRA-DuskTestCases
 * @author     Ethan Fukuda<efukuda@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace Tests\Browser;

use Tests\Browser\Pages\specimenPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;

// 12 Total Test Cases
class loginTest4 extends coraBaseTest
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
     * A Dusk test to perform valid specimen edits to validate the existence of lower bound warnings for measurements.
     *
     * @return void
     * @throws
     * @test
     * @group dnaystr1
     * @group UNO
     * @group EditMeasurementsLowerBound
     * @group AuthorEthan
     */

    public function YstrTest()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            $browser->visit(new specimenPage)
                ->pause(5000)
                ->maximize()
                ->pause(2000)

                ->click('@leftSideBar-menu')
                ->pause(2000)
                ->click('@project-report-button')
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
            $browser
                ->pause(3000)

                ->click('@dna_ystr')
                ->pause(10000)
                ->assertSee('Accession Number')
                ->assertSee('Provenance 1')
                ->assertSee('Provenance 2')
                ->assertSee('Results Status')
                ->assertSee('Mito Sequence Number')
                ->assertSee('Mito Sequence Subgroup')
                ->assertSee('Request Dates From')
                ->assertSee('Request Dates To')
                ->assertSee('Receive Dates From')
                ->assertSee('Receive Dates To')

                ->pause(3000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform valid specimen edits to validate the existence of lower bound warnings for measurements.
     *
     * @return void
     * @throws
     * @test
     * @group DnaYstr2
     * @group UNO
     * @group EditMeasurementsLowerBound
     * @group AuthorKyle
     */

    public function Ystr2Test()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            $browser->visit(new specimenPage)
                ->pause(5000)
                ->maximize()
                ->pause(2000)

                ->click('@leftSideBar-menu')
                ->pause(2000)
                ->click('@project-report-button')
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
            $browser
                ->pause(3000)

                ->click('@dna_ystr')
                ->pause(10000)
                ->assertSee('Accession Number')
                ->assertSee('Bone')
                ->assertSee('Provenance 1')
                ->assertSee('Provenance 2')
                ->assertSee('Side')
                ->assertSee('Anomaly')
                ->pause(1000)

                ->type('@dna_ystr_accession', '2017-024')
                ->keys('@dna_ystr_accession', ['{ENTER}'])
                ->pause(1000)
                ->clear('@dna_ystr_accession')

                ->type('@dna_ystr_p1', 'G-01')
                ->keys('@dna_ystr_p1', ['{ENTER}'])
                ->pause(1000)
                ->clear('@dna_ystr_p1')

                ->type('@dna_ystr_p2', 'X-100')
                ->keys('@dna_ystr_p2', ['{ENTER}'])
                ->pause(1000)
                ->clear('@dna_ystr_p2')

                ->type('@dna_ystr_r', 'Pending')
                ->keys('@dna_ystr_r', ['{ENTER}'])
                ->pause(1000)
                ->clear('@dna_ystr_r')

                ->type('@dna_ystr_seq', '10-1')
                ->keys('@dna_ystr_seq', ['{ENTER}'])
                ->pause(1000)
                ->clear('@dna_ystr_seq')

                ->type('@dna_ystr_sub', '2')
                ->keys('@dna_ystr_sub', ['{ENTER}'])
                ->pause(1000)
                ->clear('@dna_ystr_sub')

                ->type('@dna_ystr_reqDF', '2020-12-12')
                ->keys('@dna_ystr_reqDF', ['{ENTER}'])
                ->pause(1000)
                ->clear('@dna_ystr_reqDF')

                ->type('@dna_ystr_reqDT', '2020-12-14')
                ->keys('@dna_ystr_reqDT', ['{ENTER}'])
                ->pause(1000)
                ->clear('@dna_ystr_reqDT')

                ->type('@dna_ystr_recDF', '2020-12-08')
                ->keys('@dna_ystr_recDF', ['{ENTER}'])
                ->pause(1000)
                ->clear('@dna_ystr_recDF')

                ->type('@dna_ystr_recDT', '2020-12-12')
                ->keys('@dna_ystr_recDT', ['{ENTER}'])
                ->pause(1000)
                ->clear('@dna_ystr_recDT')

                ->type('@dna_ystr_accession', '2017-024')
                ->keys('@dna_ystr_accession', ['{ENTER}'])
                ->pause(1000)
                ->press('@generate-button')
                ->pause(2000)

                //collapse and check visilibility
                ->press('@collapse-button')
                ->pause(4000)
                ->click('@column-visibility')
                ->pause(3000)
                ->press('@collapse-button')
                ->pause(4000)


//                Negative test for fields with type-able values
                ->type('@dna_ystr_accession', 'INVALID ENTRY')
                ->pause(1000)
                ->clear('@dna_ystr_accession')

                ->type('@dna_ystr_p1', 'INVALID ENTRY')
                ->pause(1000)
                ->assertSee('No data available')
                ->clear('@dna_ystr_p1')

                ->type('@dna_ystr_p2', 'INVALID ENTRY')
                ->pause(1000)
                ->assertSee('No data available')
                ->clear('@dna_ystr_p2')

                ->type('@dna_ystr_r', 'INVALID ENTRY')
                ->pause(1000)
                ->assertSee('No data available')
                ->clear('@dna_ystr_r')

                ->type('@dna_ystr_seq', 'INVALID ENTRY')
                ->pause(1000)
                ->assertSee('No data available')
                ->clear('@dna_ystr_seq')

                ->type('@dna_ystr_sub', 'INVALID ENTRY')
                ->pause(1000)
                ->assertSee('No data available')
                ->clear('@dna_ystr_sub')

                ->type('@dna_ystr_reqDF', 'INVALID ENTRY')
                ->pause(1000)
                ->assertSee('No data available')
                ->clear('@dna_ystr_reqDF')

                ->type('@dna_ystr_reqDT', 'INVALID ENTRY')
                ->pause(1000)
                ->assertSee('No data available')
                ->clear('@dna_ystr_reqDT')

                ->type('@dna_ystr_recDF', 'INVALID ENTRY')
                ->pause(1000)
                ->assertSee('No data available')
                ->clear('@dna_ystr_recDF')

                ->type('@dna_ystr_recDT', 'INVALID ENTRY')
                ->pause(1000)
                ->assertSee('No data available')
                ->clear('@dna_ystr_recDT')

                ->type('@dna_ystr_accession', 'INVALID ENTRY')
                ->pause(1000)
                ->assertSee('No data available')

                ->logoutUser();
        });
    }
}


