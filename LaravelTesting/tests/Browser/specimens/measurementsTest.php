<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use App\User;

// 4 Total Test Cases
class measurementsTest extends DuskTestCase
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
     * A Dusk test to perform valid specimen edits to validate the existence of lower bound warnings for measurements.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group UNO
     * @group EditMeasurementsLowerBound
     * @group AuthorKyle
     */
    public function EditMeasurementsLowerBound()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','272')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 2 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-1','48')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 3 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-2','37')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 4 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-3','16')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 5 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-4','12')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 6 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-5','35')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 7 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-6','34')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 8 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-7','12')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 9 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-8','17')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform valid specimen edits to validate the existence of lower bound warnings for measurements for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group UNO
     * @group EditMeasurementsLowerBoundManager
     * @group AuthorKyle
     */
    public function EditMeasurementsLowerBoundManager()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','272')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 2 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-1','48')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 3 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-2','37')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 4 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-3','16')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 5 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-4','12')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 6 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-5','35')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 7 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-6','34')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 8 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-7','12')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 9 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-8','17')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform valid specimen edits to validate the existence of lower bound warnings for measurements for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group UNO
     * @group EditMeasurementsLowerBoundOrgAdmin
     * @group AuthorKyle
     */
    public function EditMeasurementsLowerBoundOrgAdmin()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','272')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 2 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-1','48')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 3 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-2','37')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 4 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-3','16')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 5 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-4','12')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 6 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-5','35')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 7 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-6','34')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 8 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-7','12')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 9 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-8','17')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform valid specimen edits to validate the existence of upper bound warnings for measurements.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group UNO
     * @group EditMeasurementsUpperBound
     * @group AuthorKyle
     */
    public function EditMeasurementsUpperBound()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','776')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 2 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-1','150')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 3 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-2','116')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 4 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-3','60')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 5 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-4','48')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 6 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-5','110')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 7 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-6','104')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 8 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-7','48')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 9 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-8','62')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform valid specimen edits to validate the existence of upper bound warnings for measurements for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group UNO
     * @group EditMeasurementsUpperBoundManager
     * @group AuthorKyle
     */
    public function EditMeasurementsUpperBoundManager()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','776')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 2 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-1','150')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 3 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-2','116')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 4 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-3','60')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 5 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-4','48')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 6 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-5','110')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 7 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-6','104')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 8 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-7','48')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 9 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-8','62')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform valid specimen edits to validate the existence of upper bound warnings for measurements for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group UNO
     * @group EditMeasurementsUpperBoundOrgAdmin
     * @group AuthorKyle
     */
    public function EditMeasurementsUpperBoundOrgAdmin()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','776')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 2 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-1','150')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 3 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-2','116')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 4 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-3','60')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 5 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-4','48')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 6 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-5','110')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 7 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-6','104')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 8 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-7','48')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                // Box 9 Test
                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-2')
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->type('@se-measurement-8','62')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->acceptDialog()
                ->pause(500)
                ->assertSee('View Measurements: ABC999-888-777-555')
                ->assertSee('Measurements association was successful')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to failed edits of specimen measurement values to validate the existence of maximum value limits for measurements.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group UNO
     * @group EditMeasurementsMax
     * @group AuthorKyle
     */
    public function EditMeasurementsMax()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','777')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 2 Test
                ->type('@se-measurement-1','151')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 3 Test
                ->type('@se-measurement-2','117')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 4 Test
                ->type('@se-measurement-3','61')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 5 Test
                ->type('@se-measurement-4','49')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 6 Test
                ->type('@se-measurement-5','111')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 7 Test
                ->type('@se-measurement-6','105')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 8 Test
                ->type('@se-measurement-7','49')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 9 Test
                ->type('@se-measurement-8','63')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to failed edits of specimen measurement values to validate the existence of maximum value limits for measurements for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group UNO
     * @group EditMeasurementsMaxManager
     * @group AuthorKyle
     */
    public function EditMeasurementsMaxManager()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','777')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 2 Test
                ->type('@se-measurement-1','151')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 3 Test
                ->type('@se-measurement-2','117')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 4 Test
                ->type('@se-measurement-3','61')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 5 Test
                ->type('@se-measurement-4','49')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 6 Test
                ->type('@se-measurement-5','111')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 7 Test
                ->type('@se-measurement-6','105')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 8 Test
                ->type('@se-measurement-7','49')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 9 Test
                ->type('@se-measurement-8','63')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to failed edits of specimen measurement values to validate the existence of maximum value limits for measurements for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group UNO
     * @group EditMeasurementsMaxOrgAdmin
     * @group AuthorKyle
     */
    public function EditMeasurementsMaxOrgAdmin()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','777')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 2 Test
                ->type('@se-measurement-1','151')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 3 Test
                ->type('@se-measurement-2','117')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 4 Test
                ->type('@se-measurement-3','61')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 5 Test
                ->type('@se-measurement-4','49')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 6 Test
                ->type('@se-measurement-5','111')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 7 Test
                ->type('@se-measurement-6','105')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 8 Test
                ->type('@se-measurement-7','49')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 9 Test
                ->type('@se-measurement-8','63')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to failed edits of specimen measurement values to validate the existence of negative value exclusions for measurements.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group this
     * @group EditMeasurementsNegative
     * @group AuthorKyle
     */
    public function EditMeasurementsNegative()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 2 Test
                ->type('@se-measurement-1','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 3 Test
                ->type('@se-measurement-2','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 4 Test
                ->type('@se-measurement-3','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 5 Test
                ->type('@se-measurement-4','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 6 Test
                ->type('@se-measurement-5','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 7 Test
                ->type('@se-measurement-6','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 8 Test
                ->type('@se-measurement-7','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 9 Test
                ->type('@se-measurement-8','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to failed edits of specimen measurement values to validate the existence of negative value exclusions for measurements for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group this
     * @group EditMeasurementsNegativeManager
     * @group AuthorKyle
     */
    public function EditMeasurementsNegativeManager()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 2 Test
                ->type('@se-measurement-1','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 3 Test
                ->type('@se-measurement-2','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 4 Test
                ->type('@se-measurement-3','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 5 Test
                ->type('@se-measurement-4','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 6 Test
                ->type('@se-measurement-5','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 7 Test
                ->type('@se-measurement-6','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 8 Test
                ->type('@se-measurement-7','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 9 Test
                ->type('@se-measurement-8','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to failed edits of specimen measurement values to validate the existence of negative value exclusions for measurements for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Measurements
     * @group this
     * @group EditMeasurementsNegativeOrgAdmin
     * @group AuthorKyle
     */
    public function EditMeasurementsNegativeOrgAdmin()
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

                // Click through the menu to be able to edit the specimen
                ->click('@se-details-menu')
                ->click('@se-measurements-menu')
                ->assertSee('View Measurements: ABC999-888-777-555')

                ->click('@se-measurement-menu')
                ->click('@se-measurements-edit-button-1')
                ->assertSee('Edit Measurements: ABC999-888-777-555')

                // Box 1 Test
                ->type('@se-measurement-0','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 2 Test
                ->type('@se-measurement-1','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 3 Test
                ->type('@se-measurement-2','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 4 Test
                ->type('@se-measurement-3','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 5 Test
                ->type('@se-measurement-4','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 6 Test
                ->type('@se-measurement-5','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 7 Test
                ->type('@se-measurement-6','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 8 Test
                ->type('@se-measurement-7','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                // Box 9 Test
                ->type('@se-measurement-8','-1')
                ->click('@se-measurement-save')
                ->pause(500)
                ->acceptDialog()
                ->pause(500)
                ->assertSee('Edit Measurements: ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/1220/measurements/edit')

                ->logoutUser();
        });
    }
}
