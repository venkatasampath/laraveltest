<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use App\User;

// 12 Total Test Cases
class associationsTest extends coraBaseTest

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
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group LoginAssociationTest
     */
    public function LoginAssociationTest()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');
        });
    }

    /**
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group ArticulationCreateTest
     * @group Association
     * @group Articulation
     * @group AssociationAnalyst

     */

    public function ArticulationCreateTest()
    {
        // Test user login
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
                ->type('@cora-search-options', 'Bone')
                ->pause(2000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                ->pause(2000)
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Humerus')
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247A:202')
                ->press('@actions-button')
                ->pause(3000)
                //go to the articulation page
                ->click('@Associations')
                ->pause(3000)
                ->click('@Articulations')
                ->pause(3000)
                ->keys('@edit-button', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-articulation-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-articulation-menu', ['{ARROW_DOWN}'])
                ->keys('@se-articulation-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new articulation for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Association
     * @group ArticulationCreateManager
     * @group Articulation
     * @group AssociationManager
     */
      public function ArticulationCreateManager()
      {
          // Test user login
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
                  ->type('@cora-search-options', 'Bone')
                  ->pause(3000)
                  ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                  ->keys('@cora-search-options', ['{ENTER}'])
                  ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                  ->pause(3000)
                  ->press('@search-btn')
                  ->pause(40000)

                  // Search Result Assertions
                  ->assertSee('Specimen search by Bone: Humerus')
                  ->waitForLink('CIL 2003-116:G-27:X-184E:203')
                  ->assertSeeLink('CIL 2003-116:G-27:X-184E:203')

                  // Specimen Assertions
                  ->clickLink('CIL 2003-116:G-27:X-184E:203')
                  ->pause(1000)
                  ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

              $browser
                  ->pause(1000)
                  ->assertSee('CIL 2003-116:G-27:X-184E:203')
                  ->click('@Associations')
                  ->pause(3000)
                  ->click('@Articulations')
                  ->pause(3000)
                  //go to the articulation page
                  ->keys('@edit-button', ['{ENTER}'])
                  ->pause(3000)
                  ->keys('@se-articulation-menu', ['{ENTER}'])
                  ->pause(3000)
                  ->keys('@se-articulation-menu', ['{ARROW_DOWN}'])
                  ->keys('@se-articulation-menu', ['{ENTER}'])
                  ->pause(3000)
                  ->keys('@save-button', ['{ENTER}'])
                  ->pause(3000)
                  ->logoutUser();
          });
      }
    /**
     * A Dusk test to create a new articulation for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Association
     * @group ArticulationCreateOrgAdmin
     * @group Articulation
     * @group AssociationOrgAdmin
     *
     */
    public function ArticulationCreateOrgAdmin()
    {
        // Test user login
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
                ->type('@cora-search-options', 'Bone')
                ->pause(3000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                ->pause(3000)
                ->press('@search-btn')
                ->pause(40000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Humerus')
                ->waitForLink('CIL 2003-116:G-27:X-184E:203')
                ->assertSeeLink('CIL 2003-116:G-27:X-184E:203')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-27:X-184E:203')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-27:X-184E:203')
                ->click('@Associations')
                ->pause(3000)
                ->click('@Articulations')
                ->pause(3000)
                //go to the articulation page
                ->keys('@edit-button', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-articulation-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-articulation-menu', ['{ARROW_DOWN}'])
                ->keys('@se-articulation-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000)
                ->logoutUser();
        });
    }

    /**
     * A Dusk test to create a new pair for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Association
     * @group PairMatchingCreateTest
     * @group PairMatching
     * @group AssociationAnalyst

     */
    public function PairMatchingCreateTest()
    {
        // Test user login
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
                ->type('@cora-search-options', 'Bone')
                ->pause(3000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                ->pause(3000)
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions
                //->assertSee('Specimen search by Bone: Humerus')
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247A:202')
                ->press('@actions-button')
                ->pause(3000)

                //go to the pair matching page
                ->press('@Associations')
                ->pause(3000)
                ->press('@Pair Matching')
                ->pause(3000)

                ->keys('@edit-button', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-pairmatches-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-pairmatches-menu', ['{ARROW_DOWN}'])
                ->keys('@se-pairmatches-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new pair for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Association
     * @group PairMatching
     * @group PairMatchingCreateManager
     * @group AssociationManager
     */
    public function PairMatchingCreateManager()
    {
        // Test user login
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
                ->type('@cora-search-options', 'Bone')
                ->pause(3000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                ->pause(3000)
                ->press('@search-btn')
                ->pause(40000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Humerus')
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247A:202')
                ->press('@actions-button')
                ->pause(3000)

                //go to the pair matching page
                ->press('@Associations')
                ->pause(3000)
                ->press('@Pair Matching')
                ->pause(3000)

                ->keys('@edit-button', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-pairmatches-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-pairmatches-menu', ['{ARROW_DOWN}'])
                ->keys('@se-pairmatches-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new pair for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Association
     * @group PairMatchingCreateOrgAdmin
     * @group PairMatching
     * @group AssociationOrgAdmin
     */
    public function PairMatchingCreateOrgAdmin()
    {
        // Test user login
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
                ->type('@cora-search-options', 'Bone')
                ->pause(3000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                ->pause(3000)
                ->press('@search-btn')
                ->pause(40000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Humerus')
                ->waitForLink('CIL 2003-116:G-27:X-184E:203')
                ->assertSeeLink('CIL 2003-116:G-27:X-184E:203')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-27:X-184E:203')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-27:X-184E:203')
                ->press('@actions-button')
                ->pause(3000)

                //go to the pair matching page
                ->press('@Associations')
                ->pause(3000)
                ->press('@Pair Matching')
                ->pause(3000)

                ->keys('@edit-button', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-pairmatches-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-pairmatches-menu', ['{ARROW_DOWN}'])
                ->keys('@se-pairmatches-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000)
                ->logoutUser();
        });
    }

    /**
     * A Dusk test to create a new refit for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Association
     * @group RefitCreateTest
     * @group Refit
     * @group AssociationAnalyst
     */
    public function RefitCreateTest()
    {
        // Test user login
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
                ->type('@cora-search-options', 'Bone')
                ->pause(3000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->clear('@cora-search-options')
                ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                ->pause(3000)
                ->press('@search-btn')
                ->pause(40000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Humerus')
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247A:202')
                ->press('@actions-button')
                ->pause(3000)

                //go to the Refit page
                ->press('@Associations')
                ->pause(3000)
                ->press('@Refits')
                ->pause(3000)

                ->keys('@edit-button', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-refits-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-refits-menu', ['{ARROW_DOWN}'])
                ->keys('@se-refits-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new refit for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Association
     * @group RefitCreateManager
     * @group Refit
     * @group AssociationManager
     */
    public function RefitCreateManager()
    {
        // Test user login
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
                ->type('@cora-search-options', 'Bone')
                ->pause(3000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                ->pause(3000)
                ->press('@search-btn')
                ->pause(40000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Humerus')
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247A:202')
                ->press('@actions-button')
                ->pause(3000)

                //go to the Refit page
                ->press('@Associations')
                ->pause(3000)
                ->press('@Refits')
                ->pause(3000)

                ->keys('@edit-button', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-refits-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-refits-menu', ['{ARROW_DOWN}'])
                ->keys('@se-refits-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new refit for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Association
     * @group RefitCreateOrgAdmin
     * @group Refit
     * @group AssociationOrgAdmin
     */
     public function RefitCreateOrgAdmin()
     {
         // Test user login
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
                 ->type('@cora-search-options', 'Bone')
                 ->pause(3000)
                 ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                 ->keys('@cora-search-options', ['{ENTER}'])
                 ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                 ->pause(3000)
                 ->press('@search-btn')
                 ->pause(40000)

                 // Search Result Assertions
                 ->assertSee('Specimen search by Bone: Humerus')
                 ->waitForLink('CIL 2003-116:G-27:X-184E:203')
                 ->assertSeeLink('CIL 2003-116:G-27:X-184E:203')

                 // Specimen Assertions
                 ->clickLink('CIL 2003-116:G-27:X-184E:203')
                 ->pause(1000)
                 ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

             $browser
                 ->pause(1000)
                 ->assertSee('CIL 2003-116:G-27:X-184E:203')
                 ->press('@actions-button')
                 ->pause(3000)

                 //go to the Refit page
                 ->press('@Associations')
                 ->pause(3000)
                 ->press('@Refits')
                 ->pause(3000)

                 ->keys('@edit-button', ['{ENTER}'])
                 ->pause(3000)
                 ->keys('@se-refits-menu', ['{ENTER}'])
                 ->pause(3000)
                 ->keys('@se-refits-menu', ['{ARROW_DOWN}'])
                 ->keys('@se-refits-menu', ['{ENTER}'])
                 ->pause(3000)
                 ->keys('@save-button', ['{ENTER}'])
                 ->pause(3000)
                 ->logoutUser();
         });
     }
    /**
     * A Dusk test to create a new morphology for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Association
     * @group MorphologyCreateTest
     * @group Morphology
     * @group AssociationAnalyst
     */
    public function MorphologyCreateTest()
    {
        // Test user login
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
                ->type('@cora-search-options', 'Bone')
                ->pause(3000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                ->pause(3000)
                ->press('@search-btn')
                ->pause(40000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Humerus')
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247A:202')
                ->press('@actions-button')
                ->pause(3000)

                //go to the Morphology page
                ->press('@Associations')
                ->pause(3000)
                ->press('@Morphology')
                ->pause(3000)

                ->keys('@edit-button', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-morphology-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-morphology-menu', ['{ARROW_DOWN}'])
                ->keys('@se-morphology-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new morphology for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Association
     * @group MorphologyCreateManager
     * @group Morphology
     * @group AssociationManager
     */
    public function MorphologyCreateManager()
    {
        // Test user login
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
                ->type('@cora-search-options', 'Bone')
                ->pause(3000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                ->pause(3000)
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Humerus')
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247A:202')
                ->press('@actions-button')
                ->pause(3000)

                //go to the Morphology page
                ->press('@Associations')
                ->pause(3000)
                ->press('@Morphology')
                ->pause(3000)

                ->keys('@edit-button', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-morphology-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-morphology-menu', ['{ARROW_DOWN}'])
                ->keys('@se-morphology-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new morphology for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Association
     * @group MorphologyCreateOrgAdmin
     * @group Morphology
     * @group AssociationOrgAdmin
     */
    public function MorphologyCreateOrgAdmin()
    {
        // Test user login
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
                ->type('@cora-search-options', 'Bone')
                ->pause(3000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones', 'Humerus', ['{ENTER}'])
                ->pause(3000)
                ->press('@search-btn')
                ->pause(40000)

                // Search Result Assertions
                ->assertSee('Specimen search by Bone: Humerus')
                ->waitForLink('CIL 2003-116:G-27:X-184E:203')
                ->assertSeeLink('CIL 2003-116:G-27:X-184E:203')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-27:X-184E:203')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-27:X-184E:203')
                ->press('@actions-button')
                ->pause(3000)

                //go to the Morphology page
                ->press('@Associations')
                ->pause(3000)
                ->press('@Morphology')
                ->pause(3000)

                ->keys('@edit-button', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-morphology-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@se-morphology-menu', ['{ARROW_DOWN}'])
                ->keys('@se-morphology-menu', ['{ENTER}'])
                ->pause(3000)
                ->keys('@save-button', ['{ENTER}'])
                ->pause(3000)
                ->logoutUser();
        });
    }


}
