<?php
/**
 * LoginTest DuskTestCase
 *
 * @category   DuskTestCases
 * @package    CoRA-DuskTestCases
 * @author     Kyle Hampton<kthampton@unomaha.edu>
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
class loginTest2 extends coraBaseTest
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
     * @group Anomaly1234
     * @group UNO
     * @group EditMeasurementsLowerBound
     * @group AuthorEthan
     */

    public function AnomalyPageTest()
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

                ->click('@anomaly_as')
                ->pause(10000)
                ->assertSee('Accession Number')
                ->assertSee('Bone')
                ->assertSee('Provenance 1')
                ->assertSee('Provenance 2')
                ->assertSee('Side')
                ->assertSee('Anomaly')

                ->pause(3000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to generate a report on the Project Anomaly page.
     *
     * @return void
     * @throws
     * @test
     * @group Anomaly1212
     * @group UNO
     * @group GenearateAnomalyReport
     * @group AuthorEthan
     */

    public function AnomalyFieldsTest()
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
                ->click('@leftsidebar-expand')
                ->pause(1000)

                ->maximize()
                ->pause(1000)

                ->assertSee('Project Reports')

                ->press('@Project Reports')

                ->pause(1000)
                ->click('@anomaly_as')
                ->pause(10000)
                ->assertSee('Accession Number')
                ->assertSee('Bone')
                ->assertSee('Provenance 1')
                ->assertSee('Provenance 2')
                ->assertSee('Side')
                ->assertSee('Anomaly')
                ->pause(1000)

                ->type('@anomaly_bone', 'Clavicle')
                ->keys('@anomaly_bone', ['{ENTER}'])
                ->pause(1000)

                ->type('@anomaly_accessions', '2017-024')
                ->keys('@anomaly_accessions', ['{ENTER}'])
                ->pause(1000)
                ->clear('@anomaly_accessions')
                ->type('@anomaly_p1', 'G-01')
                ->keys('@anomaly_p1', ['{ENTER}'])
                ->pause(1000)
                ->clear('@anomaly_p1')
                ->type('@anomaly_p2', 'X-100')
                ->keys('@anomaly_p2', ['{ENTER}'])
                ->pause(1000)
                ->clear('@anomaly_p2')
                ->type('@anomaly_a', 'Rhomboid fossa')
                ->keys('@anomaly_a', ['{ENTER}'])
                ->pause(1000)
                ->clear('@anomaly_a')
                ->type('@anomaly_side', 'Left')
                ->keys('@anomaly_side', ['{ENTER}'])
                ->pause(1000)
                ->pause(2000)
                ->clear('@anomaly_side')
                ->pause(2000)

                ->clear('@anomaly_accessions')
                ->clear('@anomaly_p1')
                ->clear('@anomaly_p2')
                ->pause(2000)
                ->type('@anomaly_a', 'Rhomboid fossa')
                ->pause(2000)
                ->clear('@anomaly_a')
                ->press('@generate-button')
                ->pause(2000)

                //collapse and check visilibility
                ->press('@collapse-button')
                ->pause(4000)
                ->click('@column-visibility')
                ->pause(3000)


//                Negative test for fields with type-able values
                ->press('@collapse-button')
                ->pause(4000)
                ->type('@anomaly_bone', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->pause(1000)
                ->clear('@anomaly_bone')
                ->pause(1000)
                ->type('@anomaly_p1', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->clear('@anomaly_p1')
                ->pause(1000)
                ->type('@anomaly_p2', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->clear('@anomaly_p2')
                ->pause(1000)
                ->type('@anomaly_accessions', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->clear('@anomaly_accessions')
                ->pause(1000)
                ->type('@anomaly_side', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->clear('@anomaly_side')
                ->pause(1000)
                ->type('@anomaly_a', 'INVALID ENTRY')
                ->assertSee('No data available')
                ->clear('@anomaly_a')
                ->pause(1000)


                ->logoutUser();
        });
    }
}