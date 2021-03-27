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
class loginTest1 extends coraBaseTest
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
     * @group DnaYstrTest
     * @group UNO
     * @group DnaYstrTest
     * @group AuthorEthan
     */
    public function DnaYstrTest()
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
                ->clear('@cora-search-options')
                ->type('@cora-search-options', 'Bone')

                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones', 'Os coxa', ['{ENTER}'])

                ->keys('@cora-search-options-bones', ['{tab}'])
                ->pause(1000)
                ->press('@search-btn')

//                ->assertSee('Specimen search by Bone: Os coxa')
                ->waitForLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSeeLink('CIL 2003-116:G-28:X-13B:902')
                ->clickLink('CIL 2003-116:G-28:X-13B:902')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
            $browser
                ->pause(3000)
                ->click('@actions-button')
                ->click('@specimen-measurements-button')
                ->pause(3000)

                ->press('@specimen-measurements-collapse-button')
                ->pause(3000)
                ->press('@specimen-measurements-collapse-button')
                ->pause(3000)

                ->press('@specimen-measurements-edit-button')
                ->pause(3000)

                //Assigned Instruments section has no data so we do not currently have a test for it

                ->type('@Osc_01', '180')
                ->keys('@Osc_01', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_01')

                ->type('@Osc_02', '180')
                ->keys('@Osc_02', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_02')

                ->type('@Osc_03', '70')
                ->keys('@Osc_03', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_03')

                ->type('@Osc_04', '80')
                ->keys('@Osc_04', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_04')

                ->type('@Osc_05', '59')
                ->keys('@Osc_05', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_05')

                ->type('@Osc_06', '120')
                ->keys('@Osc_06', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_06')

                ->type('@Osc_07', '70')
                ->keys('@Osc_07', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_07')

                ->type('@Osc_08', '80')
                ->keys('@Osc_08', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_08')

                ->type('@Osc_09', '55')
                ->keys('@Osc_09', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_09')

                ->type('@Osc_10', '88')
                ->keys('@Osc_10', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_10')

                ->type('@Osc_11', '130')
                ->keys('@Osc_11', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_11')

                ->type('@Osc_12', '160')
                ->keys('@Osc_12', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_12')

                ->type('@Osc_13', '115')
                ->keys('@Osc_13', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_13')

                ->type('@Osc_14', '22')
                ->keys('@Osc_14', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_14')

                ->type('@Osc_15', '35')
                ->keys('@Osc_15', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_15')

                ->type('@Osc_16', '10')
                ->keys('@Osc_16', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_16')

                ->type('@Osc_17', '50')
                ->keys('@Osc_17', ['{ENTER}'])
                ->pause(1000)
                ->clear('@Osc_17')

                //Negative tests for minimum value
                ->type('@Osc_01', '0')
                ->keys('@Osc_01', ['{ENTER}'])
                ->pause(1000)
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_01')

                ->type('@Osc_02', '0')
                ->keys('@Osc_02', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_02')

                ->type('@Osc_03', '0')
                ->keys('@Osc_03', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_03')

                ->type('@Osc_04', '0')
                ->keys('@Osc_04', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_04')

                ->type('@Osc_05', '0')
                ->keys('@Osc_05', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_05')

                ->type('@Osc_06', '0')
                ->keys('@Osc_06', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_06')

                ->type('@Osc_07', '0')
                ->keys('@Osc_07', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_07')

                ->type('@Osc_08', '0')
                ->keys('@Osc_08', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_08')

                ->type('@Osc_09', '0')
                ->keys('@Osc_09', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_09')

                ->type('@Osc_10', '0')
                ->keys('@Osc_10', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_10')

                ->type('@Osc_11', '0')
                ->keys('@Osc_11', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_11')

                ->type('@Osc_12', '0')
                ->keys('@Osc_12', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_12')

                ->type('@Osc_13', '0')
                ->keys('@Osc_13', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_13')

                ->type('@Osc_14', '0')
                ->keys('@Osc_14', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_14')

                ->type('@Osc_15', '0')
                ->keys('@Osc_15', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_15')

                ->type('@Osc_16', '0')
                ->keys('@Osc_16', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_16')

                ->type('@Osc_17', '0')
                ->keys('@Osc_17', ['{ENTER}'])
                ->assertSee('Value is below minimum value')
                ->pause(1000)
                ->clear('@Osc_17')

                //Negative tests for maximum value
                ->type('@Osc_01', '1000')
                ->keys('@Osc_01', ['{ENTER}'])
                ->pause(1000)
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_01')

                ->type('@Osc_02', '1000')
                ->keys('@Osc_02', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_02')

                ->type('@Osc_03', '1000')
                ->keys('@Osc_03', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_03')

                ->type('@Osc_04', '1000')
                ->keys('@Osc_04', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_04')

                ->type('@Osc_05', '1000')
                ->keys('@Osc_05', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_05')

                ->type('@Osc_06', '1000')
                ->keys('@Osc_06', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_06')

                ->type('@Osc_07', '1000')
                ->keys('@Osc_07', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_07')

                ->type('@Osc_08', '1000')
                ->keys('@Osc_08', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_08')

                ->type('@Osc_09', '1000')
                ->keys('@Osc_09', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_09')

                ->type('@Osc_10', '1000')
                ->keys('@Osc_10', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_10')

                ->type('@Osc_11', '1000')
                ->keys('@Osc_11', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_11')

                ->type('@Osc_12', '1000')
                ->keys('@Osc_12', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_12')

                ->type('@Osc_13', '1000')
                ->keys('@Osc_13', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_13')

                ->type('@Osc_14', '1000')
                ->keys('@Osc_14', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_14')

                ->type('@Osc_15', '1000')
                ->keys('@Osc_15', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_15')

                ->type('@Osc_16', '1000')
                ->keys('@Osc_16', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_16')

                ->type('@Osc_17', '1000')
                ->keys('@Osc_17', ['{ENTER}'])
                ->assertSee('Value is above maximum value')
                ->pause(1000)
                ->clear('@Osc_17')
                ->logoutUser();
        });
    }
}
