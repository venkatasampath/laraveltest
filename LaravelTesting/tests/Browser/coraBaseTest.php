<?php

/**
 * CoraBaseTest DuskTestCase
 *
 * @category   DuskTestCases
 * @package    CoRA-DuskTestCases
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace Tests\Browser;

use Tests\Browser\Pages\homePage;
use Tests\Browser\Pages\loginPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class CoraBaseTest
 * @package Tests\Browser
 */
class coraBaseTest extends DuskTestCase
{
    /**
     * @var \string[][]
     */
    public $testAccounts = [
        "anthro-analyst" => [ "email"=>"test.anthro.analyst@unomaha.edu", "password"=>"!UnoSpr@2021"],
        "dna-analyst" => [ "email"=>"test.dna.analyst@unomaha.edu", "password"=>"!UnoSpr@2021"],
        "isotope-analyst" => [ "email"=>"test.isotope.analyst@unomaha.edu", "password"=>"!UnoSpr@2021"],
        "org-admin" => [ "email"=>"test.org.admin@unomaha.edu", "password"=>"!UnoSpr@2021"],
        "org-manager" => [ "email"=>"test.org.manager@unomaha.edu", "password"=>"!UnoSpr@2021"],
        "project-lead" => [ "email"=>"test.anthro.analyst.project.lead@unomaha.edu", "password"=>"!UnoSpr@2021"],
        "testuser" => ['email' => 'testuno@unomaha.edu', 'password' => '!UnoSpr@2021'],
        "invalid-user" => ['email' => 'userdoenotexist@unomaha.edu', 'password' => '!UnoSpr@2021'],
        "invalid-org-admin" => ['email' => 'test.org.admin@unomaha.edu', 'password' => 'Invalid!23'],
        "invalid-org-manager" => ['email' => 'test.org.manager@unomaha.edu', 'password' => 'Invalid!23'],
        "invalid-pswd" => ['email' => 'test.dna.analyst@unomaha.edu', 'password' => 'Invalid!23'],
        "blank-user" => ['email' => '', 'password' => ''],
    ];

    /**
     * Create a new CoraBaseTest instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Delete cookies from each CoraBaseTest instance.
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
     * Flush the session from each CoraBaseTest instance.
     * @throws \Throwable
     */
    public function tearDown():void
    {
        session()->flush();

        parent::tearDown();
    }

    /**
     * A basic browser test for CoRA.
     *
     * @return void
     * @throws
     * @test
     * @group Base
     * @group CoraTest
     */
    public function CoraTest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('CoRA');
        });
    }

    /**
     * A basic browser test for CoRA.
     *
     * @return void
     * @throws
     * @test
     * @group Base
     * @group About
     */
    public function AboutTest()
    {
        $user = $this->testAccounts["anthro-analyst"];

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome to CoRA');

            $browser->visit(new homePage)
                ->pause(3000)
                ->press('@profile-picture')
                ->pause(5000)
                ->press('@about_menu')
//
                ->pause(5000)
                ->assertSee('About')
                ->assertSee('About Browser')
                ->assertSee('Welcome')
                ->assertSee('EULA')

                ->logoutUser();
        });
    }

    /**
     * A basic browser test for CoRA.
     *
     * @return void
     * @throws
     * @test
     * @group Base
     * @group OnlineHelp
     */
    public function OnlineHelpTest()
    {
        $user = $this->testAccounts["anthro-analyst"];

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome to CoRA')
                ->pause(3000)
                ->clickLink('CoRA Online Help');

            $browser->pause(1000);

            // Get the last opened tab
            $window = collect($browser->driver->getWindowHandles())->last();

            // Switch to the tab
            $browser->driver->switchTo()->window($window);

            $browser->pause(1000);

            // Check if the path is correct
            $browser->assertSee('CoRA Docs')
                ->assertSee('What is CoRA?');

            // assert Path not working.
            //    ->assertPathIs('https://cora-docs.readthedocs.io/en/latest');
        });
    }

}
