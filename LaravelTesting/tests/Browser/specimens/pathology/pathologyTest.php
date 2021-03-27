<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use App\User;

// 9 Total Test Cases
class pathologyTest extends DuskTestCase
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
     * A Dusk test to create a new trauma for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group CreateTrauma
     * @group AuthorKyle
     */
    public function CreateTrauma()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-traumas-menu')
                ->waitForLocation('/skeletalelements/1221/traumas')
                ->click('@create-button')
                ->assertSee('Create Trauma: ABC999-888-777-556')

                ->select('@se-trauma-zone','97')
                ->select('@se-trauma-trauma','2')
                ->type('@se-trauma-additional-info','TEST CREATE')
                ->click('@se-trauma-save')

                ->waitForLocation('/skeletalelements/1221/traumas')
                ->waitForText('Trauma successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new trauma for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group CreateTraumaManager
     * @group AuthorKyle
     */
    public function CreateTraumaManager()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->pause(1000)
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-traumas-menu')
                ->waitForLocation('/skeletalelements/1221/traumas')
                ->click('@create-button')
                ->assertSee('Create Trauma: ABC999-888-777-556')

                ->select('@se-trauma-zone','97')
                ->select('@se-trauma-trauma','2')
                ->type('@se-trauma-additional-info','TEST CREATE')
                ->click('@se-trauma-save')

                ->waitForLocation('/skeletalelements/1221/traumas')
                ->waitForText('Trauma successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new trauma for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group CreateTraumaOrgAdmin
     * @group AuthorKyle
     */
    public function CreateTraumaOrgAdmin()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-traumas-menu')
                ->waitForLocation('/skeletalelements/1221/traumas')
                ->click('@create-button')
                ->assertSee('Create Trauma: ABC999-888-777-556')

                ->select('@se-trauma-zone','97')
                ->select('@se-trauma-trauma','2')
                ->type('@se-trauma-additional-info','TEST CREATE')
                ->click('@se-trauma-save')

                ->waitForLocation('/skeletalelements/1221/traumas')
                ->waitForText('Trauma successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an existing trauma for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group EditTrauma
     * @group AuthorKyle
     */
    public function EditTrauma()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-traumas-menu')
                ->waitForLocation('/skeletalelements/1221/traumas')

                // Select the first listed trauma to edit
                ->click('#DataTables_Table_0 > tbody > tr > td.table-text.sorting_1 > div > a')
                ->assertSee('View Trauma: ABC999-888-777-556')

                ->click('@se-trauma-menu')
                ->click('@se-trauma-edit')

                ->select('@se-trauma-zone','98')
                ->select('@se-trauma-trauma','3')

                ->type('@se-trauma-additional-info','TEST EDIT')
                ->click('@se-trauma-save')
                ->waitForLocation('/skeletalelements/1221/traumas')
                ->waitForText('Trauma successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an existing trauma for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group EditTraumaManager
     * @group AuthorKyle
     */
    public function EditTraumaManager()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-traumas-menu')
                ->waitForLocation('/skeletalelements/1221/traumas')

                // Select the first listed trauma to edit
                ->click('#DataTables_Table_0 > tbody > tr > td.table-text.sorting_1 > div > a')
                ->assertSee('View Trauma: ABC999-888-777-556')

                ->click('@se-trauma-menu')
                ->click('@se-trauma-edit')

                ->select('@se-trauma-zone','98')
                ->select('@se-trauma-trauma','3')

                ->type('@se-trauma-additional-info','TEST EDIT')
                ->click('@se-trauma-save')
                ->waitForLocation('/skeletalelements/1221/traumas')
                ->waitForText('Trauma successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an existing trauma for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group EditTraumaOrgAdmin
     * @group AuthorKyle
     */
    public function EditTraumaOrgAdmin()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-traumas-menu')
                ->waitForLocation('/skeletalelements/1221/traumas')

                // Select the first listed trauma to edit
                ->click('#DataTables_Table_0 > tbody > tr > td.table-text.sorting_1 > div > a')
                ->assertSee('View Trauma: ABC999-888-777-556')

                ->click('@se-trauma-menu')
                ->click('@se-trauma-edit')

                ->select('@se-trauma-zone','98')
                ->select('@se-trauma-trauma','3')

                ->type('@se-trauma-additional-info','TEST EDIT')
                ->click('@se-trauma-save')
                ->waitForLocation('/skeletalelements/1221/traumas')
                ->waitForText('Trauma successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an existing trauma for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group DeleteTrauma
     * @group AuthorKyle
     */
    public function DeleteTrauma()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-traumas-menu')
                ->waitForLocation('/skeletalelements/1221/traumas')

                ->assertVisible('#DataTables_Table_0 > tbody > tr.odd')
                ->pause(1000)
                //->click('#form-delete-traumas-24 > a > i')
                //->acceptDialog()
                ->waitForLocation('/skeletalelements/1221/traumas')
                ->assertPathIs('/skeletalelements/1221/traumas')
                //->waitForText('Specimen Trauma successfully deleted!')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an existing trauma for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group DeleteTraumaManager
     * @group AuthorKyle
     */
    public function DeleteTraumaManager()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-traumas-menu')
                ->waitForLocation('/skeletalelements/1221/traumas')

                ->assertVisible('#DataTables_Table_0 > tbody > tr.odd')
                ->pause(1000)
                //->click('#form-delete-traumas-24 > a > i')
                //->acceptDialog()
                ->waitForLocation('/skeletalelements/1221/traumas')
                ->assertPathIs('/skeletalelements/1221/traumas')
                //->waitForText('Specimen Trauma successfully deleted!')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an existing trauma for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group DeleteTraumaOrgAdmin
     * @group AuthorKyle
     */
    public function DeleteTraumaOrgAdmin()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-traumas-menu')
                ->waitForLocation('/skeletalelements/1221/traumas')

                ->assertVisible('#DataTables_Table_0 > tbody > tr.odd')
                ->pause(1000)
                //->click('#form-delete-traumas-24 > a > i')
                //->acceptDialog()
                ->waitForLocation('/skeletalelements/1221/traumas')
                ->assertPathIs('/skeletalelements/1221/traumas')
                //->waitForText('Specimen Trauma successfully deleted!')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new pathology for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group CreatePathology
     * @group AuthorKyle
     */
    public function CreatePathology()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-pathologys-menu')
                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->click('@create-button')

                ->assertSee('Create Pathology: ABC999-888-777-556')

                // Create the new pathology
                ->select('@se-pathology-zone','97')
                ->select('@se-pathology','3')
                ->select('@se-pathology-additional-info','TEST CREATE')
                ->click('@se-pathology-save')

                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->waitForText('Pathology successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new pathology for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group CreatePathologyManager
     * @group AuthorKyle
     */
    public function CreatePathologyManager()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-pathologys-menu')
                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->click('@create-button')

                ->assertSee('Create Pathology: ABC999-888-777-556')

                // Create the new pathology
                ->select('@se-pathology-zone','97')
                ->select('@se-pathology','3')
                ->select('@se-pathology-additional-info','TEST CREATE')
                ->click('@se-pathology-save')

                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->waitForText('Pathology successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new pathology for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group CreatePathologyOrgAdmin
     * @group AuthorKyle
     */
    public function CreatePathologyOrgAdmin()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-pathologys-menu')
                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->click('@create-button')

                ->assertSee('Create Pathology: ABC999-888-777-556')

                // Create the new pathology
                ->select('@se-pathology-zone','97')
                ->select('@se-pathology','3')
                ->select('@se-pathology-additional-info','TEST CREATE')
                ->click('@se-pathology-save')

                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->waitForText('Pathology successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an existing pathology for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group EditPathology
     * @group AuthorKyle
     */
    public function EditPathology()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-pathologys-menu')
                ->waitForLocation('/skeletalelements/1221/pathologys')

                // Edit the specimen by creating an additional pathology
                ->click('@create-button')
                ->assertSee('Create Pathology: ABC999-888-777-556')
                ->select('@se-pathology-zone','98')
                ->select('@se-pathology','4')
                ->select('@se-pathology-additional-info','TEST Edit')

                // Verify the update to the specimen pathology was saved
                ->click('@se-pathology-save')
                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->waitForText('Pathology successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an existing pathology for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group EditPathologyManager
     * @group AuthorKyle
     */
    public function EditPathologyManager()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-pathologys-menu')
                ->waitForLocation('/skeletalelements/1221/pathologys')

                // Edit the specimen by creating an additional pathology
                ->click('@create-button')
                ->assertSee('Create Pathology: ABC999-888-777-556')
                ->select('@se-pathology-zone','98')
                ->select('@se-pathology','4')
                ->select('@se-pathology-additional-info','TEST Edit')

                // Verify the update to the specimen pathology was saved
                ->click('@se-pathology-save')
                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->waitForText('Pathology successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an existing pathology for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group EditPathologyOrgAdmin
     * @group AuthorKyle
     */
    public function EditPathologyOrgAdmin()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-pathologys-menu')
                ->waitForLocation('/skeletalelements/1221/pathologys')

                // Edit the specimen by creating an additional pathology
                ->click('@create-button')
                ->assertSee('Create Pathology: ABC999-888-777-556')
                ->select('@se-pathology-zone','98')
                ->select('@se-pathology','4')
                ->select('@se-pathology-additional-info','TEST Edit')

                // Verify the update to the specimen pathology was saved
                ->click('@se-pathology-save')
                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->waitForText('Pathology successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an existing pathology for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group DeletePathology
     * @group AuthorKyle
     */
    public function DeletePathology()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-pathologys-menu')
                ->waitForLocation('/skeletalelements/1221/pathologys')

                // Delete the previously edited pathology
                ->assertVisible('#DataTables_Table_0 > tbody > tr.odd')
                ->pause(1000)
                //->click('#form-delete-pathologys-40 > a > i')
                //->acceptDialog()
                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->assertPathIs('/skeletalelements/1221/pathologys')
                //->waitForText('Specimen Pathology successfully deleted!')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an existing pathology for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group DeletePathologyManager
     * @group AuthorKyle
     */
    public function DeletePathologyManager()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-pathologys-menu')
                ->waitForLocation('/skeletalelements/1221/pathologys')

                // Delete the previously edited pathology
                ->assertVisible('#DataTables_Table_0 > tbody > tr.odd')
                ->pause(1000)
                //->click('#form-delete-pathologys-40 > a > i')
                //->acceptDialog()
                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->assertPathIs('/skeletalelements/1221/pathologys')
                //->waitForText('Specimen Pathology successfully deleted!')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an existing pathology for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group DeletePathologyOrgAdmin
     * @group AuthorKyle
     */
    public function DeletePathologyOrgAdmin()
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
                ->waitForLink('ABC999-888-777-556')
                ->assertSeeLink('ABC999-888-777-556')
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-556')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-pathologys-menu')
                ->waitForLocation('/skeletalelements/1221/pathologys')

                // Delete the previously edited pathology
                ->assertVisible('#DataTables_Table_0 > tbody > tr.odd')
                ->pause(1000)
                //->click('#form-delete-pathologys-40 > a > i')
                //->acceptDialog()
                ->waitForLocation('/skeletalelements/1221/pathologys')
                ->assertPathIs('/skeletalelements/1221/pathologys')
                //->waitForText('Specimen Pathology successfully deleted!')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new anomaly for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group CreateAnomaly
     * @group AuthorKyle
     */
    public function CreateAnomaly()
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
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-anomalys-menu')
                ->waitForLocation('/skeletalelements/1220/anomalys')
                ->click('@se-anomalys-menu')
                ->click('@se-anomalys-edit-button')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')

                // Create and save the new anomaly
                ->select('@se-anomaly-list','51')
                ->click('@se-anomaly-save')
                ->acceptDialog()

                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->waitForText('Anomalies successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new anomaly for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group CreateAnomalyManager
     * @group AuthorKyle
     */
    public function CreateAnomalyManager()
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
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-anomalys-menu')
                ->waitForLocation('/skeletalelements/1220/anomalys')
                ->click('@se-anomalys-menu')
                ->click('@se-anomalys-edit-button')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')

                // Create and save the new anomaly
                ->select('@se-anomaly-list','51')
                ->click('@se-anomaly-save')
                ->acceptDialog()

                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->waitForText('Anomalies successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a new anomaly for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group CreateAnomalyOrgAdmin
     * @group AuthorKyle
     */
    public function CreateAnomalyOrgAdmin()
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
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-anomalys-menu')
                ->waitForLocation('/skeletalelements/1220/anomalys')
                ->click('@se-anomalys-menu')
                ->click('@se-anomalys-edit-button')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')

                // Create and save the new anomaly
                ->select('@se-anomaly-list','51')
                ->click('@se-anomaly-save')
                ->acceptDialog()

                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->waitForText('Anomalies successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an existing pathology for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group EditAnomaly
     * @group AuthorKyle
     */
    public function EditAnomaly()
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
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-anomalys-menu')
                ->waitForLocation('/skeletalelements/1220/anomalys')
                ->click('@se-anomalys-menu')
                ->click('@se-anomalys-edit-button')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')

                // Edit and save the specimen by adding a new anomaly
                ->select('@se-anomaly-list','52')
                ->click('@se-anomaly-save')
                ->acceptDialog()

                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->waitForText('Anomalies successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an existing pathology for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group EditAnomalyManager
     * @group AuthorKyle
     */
    public function EditAnomalyManager()
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
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-anomalys-menu')
                ->waitForLocation('/skeletalelements/1220/anomalys')
                ->click('@se-anomalys-menu')
                ->click('@se-anomalys-edit-button')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')

                // Edit and save the specimen by adding a new anomaly
                ->select('@se-anomaly-list','52')
                ->click('@se-anomaly-save')
                ->acceptDialog()

                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->waitForText('Anomalies successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an existing pathology for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group EditAnomalyOrgAdmin
     * @group AuthorKyle
     */
    public function EditAnomalyOrgAdmin()
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
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-anomalys-menu')
                ->waitForLocation('/skeletalelements/1220/anomalys')
                ->click('@se-anomalys-menu')
                ->click('@se-anomalys-edit-button')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')

                // Edit and save the specimen by adding a new anomaly
                ->select('@se-anomaly-list','52')
                ->click('@se-anomaly-save')
                ->acceptDialog()

                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->waitForText('Anomalies successfully associated/created')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an existing anomaly for a specimen.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group DeleteAnomaly
     * @group AuthorKyle
     */
    public function DeleteAnomaly()
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
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-anomalys-menu')
                ->waitForLocation('/skeletalelements/1220/anomalys')
                ->click('@se-anomalys-menu')
                ->click('@se-anomalys-edit-button')

                // Delete the first anomaly for the specimen
                ->assertVisible('@se-anomaly-list')
                ->pause(1000)
                //->click('#form-delete-pathologys-40 > a > i')
                //->acceptDialog()
                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')
                //->waitForText('Specimen Pathology successfully deleted!')
                //->click('#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > div > div.col-lg-12.form-group.anomalys > span > span.selection > span > ul > li:nth-child(1) > span')
                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an existing anomaly for a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group DeleteAnomalyManager
     * @group AuthorKyle
     */
    public function DeleteAnomalyManager()
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
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-anomalys-menu')
                ->waitForLocation('/skeletalelements/1220/anomalys')
                ->click('@se-anomalys-menu')
                ->click('@se-anomalys-edit-button')

                // Delete the first anomaly for the specimen
                ->assertVisible('@se-anomaly-list')
                ->pause(1000)
                //->click('#form-delete-pathologys-40 > a > i')
                //->acceptDialog()
                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')
                //->waitForText('Specimen Pathology successfully deleted!')
                //->click('#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > div > div.col-lg-12.form-group.anomalys > span > span.selection > span > ul > li:nth-child(1) > span')
                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an existing anomaly for a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Pathology
     * @group UNO
     * @group DeleteAnomalyOrgAdmin
     * @group AuthorKyle
     */
    public function DeleteAnomalyOrgAdmin()
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
                ->assertSee('Radius')
                ->assertSee('Left')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sampled')

                // Specimen Assertions
                ->clickLink('ABC999-888-777-555')
                ->assertSee('View Specimen - ABC999-888-777-555')
                ->click('@se-details-menu')

                ->mouseover('@se-pathology-menu')
                ->click('@se-anomalys-menu')
                ->waitForLocation('/skeletalelements/1220/anomalys')
                ->click('@se-anomalys-menu')
                ->click('@se-anomalys-edit-button')

                // Delete the first anomaly for the specimen
                ->assertVisible('@se-anomaly-list')
                ->pause(1000)
                //->click('#form-delete-pathologys-40 > a > i')
                //->acceptDialog()
                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')
                //->waitForText('Specimen Pathology successfully deleted!')
                //->click('#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > div > div.col-lg-12.form-group.anomalys > span > span.selection > span > ul > li:nth-child(1) > span')
                ->waitForLocation('/skeletalelements/1220/associateanomalys')
                ->assertPathIs('/skeletalelements/1220/associateanomalys')

                ->logoutUser();
        });
    }
}
