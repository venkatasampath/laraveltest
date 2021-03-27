<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use App\User;

// 4 Total Test Cases
class taphonomyTest extends DuskTestCase
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
     * A Dusk test to create a singular taphonomy for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group CreateTaphonomy
     * @group AuthorKyle
     */
    public function CreateTaphonomy()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Add and Save a new taphonomy
                ->select('@se-taphonomy-list','Adherent Materials-Iron')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a singular taphonomy for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group CreateTaphonomyManager
     * @group AuthorKyle
     */
    public function CreateTaphonomyManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Add and Save a new taphonomy
                ->select('@se-taphonomy-list','Adherent Materials-Iron')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a singular taphonomy for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group CreateTaphonomyOrgAdmin
     * @group AuthorKyle
     */
    public function CreateTaphonomyOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Add and Save a new taphonomy
                ->select('@se-taphonomy-list','Adherent Materials-Iron')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a multiple taphonomies for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group CreateTaphonomyMultiple
     * @group AuthorKyle
     */
    public function CreateTaphonomyMultiple()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Add and Save a multiple new taphonomies
                ->select('@se-taphonomy-list','General Color-Natural')
                ->select('@se-taphonomy-list','Human Modification-Other')
                ->select('@se-taphonomy-list','Physical-Weathering')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a multiple taphonomies for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group CreateTaphonomyMultipleManager
     * @group AuthorKyle
     */
    public function CreateTaphonomyMultipleManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Add and Save a multiple new taphonomies
                ->select('@se-taphonomy-list','General Color-Natural')
                ->select('@se-taphonomy-list','Human Modification-Other')
                ->select('@se-taphonomy-list','Physical-Weathering')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a multiple taphonomies for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group CreateTaphonomyMultipleOrgAdmin
     * @group AuthorKyle
     */
    public function CreateTaphonomyMultipleOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Add and Save a multiple new taphonomies
                ->select('@se-taphonomy-list','General Color-Natural')
                ->select('@se-taphonomy-list','Human Modification-Other')
                ->select('@se-taphonomy-list','Physical-Weathering')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete a singular taphonomy for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group DeleteTaphonomy
     * @group AuthorKyle
     */
    public function DeleteTaphonomy()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Delete and Save an existing taphonomy
                ->keys('#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > div > div.col-lg-12.form-group.taphonomys > span > span.selection > span > ul > li > input','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete a singular taphonomy for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group DeleteTaphonomyManager
     * @group AuthorKyle
     */
    public function DeleteTaphonomyManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Delete and Save an existing taphonomy
                ->keys('#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > div > div.col-lg-12.form-group.taphonomys > span > span.selection > span > ul > li > input','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete a singular taphonomy for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group DeleteTaphonomyOrgAdmin
     * @group AuthorKyle
     */
    public function DeleteTaphonomyOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Delete and Save an existing taphonomy
                ->keys('#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > div > div.col-lg-12.form-group.taphonomys > span > span.selection > span > ul > li > input','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete multiple taphonomies for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group DeleteTaphonomyMultiple
     * @group AuthorKyle
     */
    public function DeleteTaphonomyMultiple()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Delete and Save multiple taphonomies
                ->keys('#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > div > div.col-lg-12.form-group.taphonomys > span > span.selection > span > ul > li > input','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete multiple taphonomies for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group DeleteTaphonomyMultipleManager
     * @group AuthorKyle
     */
    public function DeleteTaphonomyMultipleManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Delete and Save multiple taphonomies
                ->keys('#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > div > div.col-lg-12.form-group.taphonomys > span > span.selection > span > ul > li > input','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete multiple taphonomies for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Taphonomy
     * @group UNO
     * @group DeleteTaphonomyMultipleOrgAdmin
     * @group AuthorKyle
     */
    public function DeleteTaphonomyMultipleOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->select('@search-type-selector','SE-P1')
                ->pause(1000)
                ->type('@cora-search','888')
                ->keys('@cora-search','{enter}')

                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('ABC999-888-777-555')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')
                ->click('@se-taphonomys-menu')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/taphonomys')

                // Open Edit Functions
                ->click('@se-taphonomys-menu')
                ->click('@taphonomy-actions-edit')
                ->assertSee('Taphonomies: ABC999-888-777-555')
                ->assertSee('Save')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                // Delete and Save multiple taphonomies
                ->keys('#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > div > div.col-lg-12.form-group.taphonomys > span > span.selection > span > ul > li > input','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}','{backspace}')
                ->click('@se-taphonomy-save')
                ->acceptDialog()
                ->assertSee('Taphonomies successfully associated')
                ->assertPathIs('/skeletalelements/1220/associatetaphonomys')

                ->logoutUser();
        });
    }
}
