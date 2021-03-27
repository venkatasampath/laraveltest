<?php

/**
 * SkeletalElementsSearchTest DuskTestCase
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

// 12 Total seComparison Cases
class Actions_BiologicalProfile extends coraBaseTest
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
     * A Dusk test for invalid user login password
     *
     * @return void
     * @throws
     * @test
     * @group invalidUserPassword
     */
    public function invalidUserAttempt()
    {
        $user = $this->testAccounts["invalid-pswd"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('These credentials do not match our records');
        });
    }

    /**
     * A Dusk test to make a composite key search and check biological profile with age under actions
     *
     * @return void
     * @throws
     * @test
     * @group AnthroAge
     * @group BiologicalProfile
     * @group AnalystBioProfile
     */
    public function BiologicalProfileAge()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000);
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Composite Key')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','CIL 2003-116:G-25:X-247A:202')
                ->keys('@cora-search','{enter}')
                ->pause(5000)
//
//                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')


//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(500)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

//
            $browser
                ->pause(500)
                ->maximize()
                ->press('@biological-profile')
                ->press('@age')
                ->pause(2000)
                ->assertsee('Methods')
                ->logoutUser();

        });

    }
    /**
     * A Dusk test to make a provenance 1 search and check biological profile with sex under actions
     *
     * @return void
     * @throws
     * @test
     * @group AnthroSex
     * @group BiologicalProfile
     * @group AnalystBioProfile

     */
    public function BiologicalProfileSex()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000);
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options', 'Provenance 1')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance1', 'G-04', ['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance1', ['{tab}'])
                ->press('@search-btn')
                ->pause(60000)
                // Search Result Assertions for cranium CIL 2003-116:G-04:X-56A:101
                ->waitForLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSeeLink('CIL 2003-116:G-04:X-56A:101')
                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-04:X-56A:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last())
                ->pause(3000)
                ->maximize()
                ->press('@biological-profile')
                ->press('@sex')
                ->pause(2000)
                ->assertsee('Methods')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to make a composite key search and check biological profile with ancestry under actions
     *
     * @return void
     * @throws
     * @test
     * @group AnthroAncestry
     * @group BiologicalProfile
     * @group AnalystBioProfile

     */
    public function BiologicalProfileAncestry()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000);
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Composite Key')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','CIL 2003-116:G-25:X-247A:202')
                ->keys('@cora-search','{enter}')
                ->pause(50000)
//
//                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')


//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(500)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last())
                ->pause(3000)
                ->maximize()
                ->press('@biological-profile')
                ->press('@ancestry')
                ->pause(2000)
                ->assertsee('Methods')

                ->logoutUser();

        });

    }
    /**
     * A Dusk test to perform a skeletal search by bone and validate the results for biological profile with stature
     *
     * @return void
     * @throws
     * @test
     * @group AnthroStature
     * @group BiologicalProfile
     * @group AnalystBioProfile
     */
    public function BiologicalProfileStature()
    {
        // seComparison user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Bone')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones','Os coxa',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-bones',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)
                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Os coxa')
                ->waitForLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSeeLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-28:X-13B:902')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last())
                ->pause(3000)
                ->maximize()
                ->press('@biological-profile')
                ->press('@stature')
                ->pause(2000)
                ->assertsee('Methods')

                ->logoutUser();

        });

    }

    /**
     * A Dusk test to make manager a composite key search and check biological profile with age under actions
     *
     * @return void
     * @throws
     * @test
     * @group ManagerAge
     * @group BiologicalProfile
     * @group ManagerBioProfile

     */
    public function ManagerBiologicalProfileAge()
    {
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000);
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Composite Key')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','CIL 2003-116:G-25:X-247A:202')
                ->keys('@cora-search','{enter}')
                ->pause(50000)
//
//                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')


//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(500)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last())
                ->maximize()
                ->press('@biological-profile')
                ->press('@age')
                ->pause(2000)
                ->assertsee('Methods')

                ->logoutuser();

        });

    }
    /**
     * A Dusk test to make manager a provenance 1 search and check biological profile with sex under actions
     *
     * @return void
     * @throws
     * @test
     * @group ManagerSex
     * @group BiologicalProfile
     * @group ManagerBioProfile

     */
    public function ManagerBiologicalProfileSex()
    {
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000);
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options', 'Provenance 1')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance1', 'G-04', ['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance1', ['{tab}'])
                ->press('@search-btn')
                ->pause(60000)
                // Search Result Assertions for cranium CIL 2003-116:G-04:X-56A:101
                ->waitForLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSeeLink('CIL 2003-116:G-04:X-56A:101')
                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-04:X-56A:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last())
                ->pause(3000)
                ->maximize()
                ->press('@biological-profile')
                ->press('@age')
                ->pause(2000)
                ->assertsee('Methods')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to make a manager composite key search and check biological profile with ancestry under actions
     *
     * @return void
     * @throws
     * @test
     * @group ManagerAncestry
     * @group BiologicalProfile
     * @group ManagerBioProfile

     */
    public function ManagerBiologicalProfileAncestry()
    {
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000);
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Composite Key')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','CIL 2003-116:G-25:X-247A:202')
                ->keys('@cora-search','{enter}')
                ->pause(50000)
//
//                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')


//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(500)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last())
                ->pause(3000)
                ->maximize()
                ->press('@biological-profile')
                ->press('@ancestry')
                ->pause(2000)
                ->assertsee('Methods')

                ->logoutUser();

        });

    }
    /**
     * A Dusk test to perform manager a skeletal search by bone and validate the results for biological profile with stature
     *
     * @return void
     * @throws
     * @test
     * @group ManagerStature
     * @group BiologicalProfile
     * @group ManagerBioProfile
     */
    public function ManagerBiologicalProfileStature()
    {
        // seComparison user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Bone')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones','Os coxa',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-bones',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)
                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Os coxa')
                ->waitForLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSeeLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-28:X-13B:902')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last())
                ->pause(3000)
                ->maximize()
                ->press('@biological-profile')
                ->press('@stature')
                ->pause(2000)
                ->assertsee('Methods')

                ->logoutUser();

        });

    }

    /**
     * A Dusk test to make a composite key search and check biological profile with age under actions
     *
     * @return void
     * @throws
     * @test
     * @group AdminAge
     * @group BiologicalProfile
     * @group AdminBioProfile

     */
    public function AdminBiologicalProfileAge()
    {
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000);
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Composite Key')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','CIL 2003-116:G-25:X-247A:202')
                ->keys('@cora-search','{enter}')
                ->pause(50000)
//
//                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')


//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(500)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last())
                ->pause(3000)
                ->maximize()
                ->press('@biological-profile')
                ->press('@age')
                ->pause(2000)
                ->assertsee('Methods')

                ->logoutuser();

        });

    }
    /**
     * A Dusk test to make admin a provenance 1 search and check biological profile with sex under actions
     *
     * @return void
     * @throws
     * @test
     * @group AdminSex
     * @group BiologicalProfile
     * @group AdminBioProfile

     */
    public function AdminBiologicalProfileSex()
    {
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000);
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options', 'Provenance 1')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance1', 'G-04', ['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance1', ['{tab}'])
                ->press('@search-btn')
                ->pause(60000)
                // Search Result Assertions for cranium CIL 2003-116:G-04:X-56A:101
                ->waitForLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSeeLink('CIL 2003-116:G-04:X-56A:101')
                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-04:X-56A:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last())
                ->pause(3000)
                ->maximize()
                ->press('@biological-profile')
                ->press('@sex')
                ->pause(2000)
                ->assertsee('Methods')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to make admin a composite key search and check biological profile with ancestry under actions
     *
     * @return void
     * @throws
     * @test
     * @group AdminAncestry
     * @group BiologicalProfile
     * @group AdminBioProfile

     */
    public function AdminBiologicalProfileAncestry()
    {
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000);
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Composite Key')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','CIL 2003-116:G-25:X-247A:202')
                ->keys('@cora-search','{enter}')
                ->pause(50000)
//
//                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')


//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(500)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last())
                ->pause(3000)
                ->maximize()
                ->press('@biological-profile')
                ->press('@ancestry')
                ->pause(2000)
                ->assertsee('Methods')

                ->logoutUser();

        });

    }
    /**
     * A Dusk test to perform admin skeletal search by bone and validate the results for biological profile with stature
     *
     * @return void
     * @throws
     * @test
     * @group AdminStature
     * @group BiologicalProfile
     * @group AdminBioProfile
     *
     */
    public function AdminBiologicalProfileStature()
    {
        // seComparison user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Bone')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones','Os coxa',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-bones',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)
                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Os coxa')
                ->waitForLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSeeLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-28:X-13B:902')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last())
                ->pause(3000)
                ->maximize()
                ->press('@biological-profile')
                ->press('@stature')
                ->pause(2000)
                ->assertsee('Methods')

                ->logoutUser();

        });

    }}
