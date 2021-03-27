<?php

/**
 * SkeletalElementsCreateTest DuskTestCase
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

// 10 Total Test Cases
class createTest extends DuskTestCase
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
     * A Dusk test to create a valid specimen.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateSkeletalElement
     * @group AuthorKyle
     */
    public function CreateSkeletalElement()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];

        $this->browse(function ($browser) use ($user) {
            $newSkeletalElement = 'TEST'.rand(10000,99999);
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                //Create new specimen
                ->assertPathIs('/skeletalelements/create')
                ->select('@accession-number','54321')
                ->select('@provenance1','8888')
                ->select('@provenance2','7777')
                ->type('@designator',$newSkeletalElement)
                ->select('sb_id',rand(1,166))
                ->select('side','Left')
                ->select('completeness','Complete')
                ->pause(500)
                ->press('@se-save')
                ->pause(500)
                ->waitForText($newSkeletalElement)
                ->assertPathIs('/skeletalelements');


            // Search through specimens to find the newly created element
            $browser->visit(new specimenPage)
                ->select('@cora-search-options','SE-DN')
                ->pause(1000)
                ->type('@cora-search',$newSkeletalElement)
                ->click('@cora-search-button')
                ->pause(1000)
                ->assertSee('54321')
                ->assertSee('8888')
                ->assertSee('7777')
                ->assertSee('Left')
                ->assertSee($newSkeletalElement)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a valid specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateSkeletalElementManager
     * @group AuthorKyle
     */
    public function CreateSkeletalElementManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];

        $this->browse(function ($browser) use ($user) {
            $newSkeletalElement = 'TEST'.rand(10000,99999);
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                //Create new specimen
                ->assertPathIs('/skeletalelements/create')
                ->select('@accession-number','54321')
                ->select('@provenance1','8888')
                ->select('@provenance2','7777')
                ->type('@designator',$newSkeletalElement)
                ->select('sb_id',rand(1,166))
                ->select('side','Left')
                ->select('completeness','Complete')
                ->pause(500)
                ->press('@se-save')
                ->pause(500)
                ->waitForText($newSkeletalElement)
                ->assertPathIs('/skeletalelements');


            // Search through specimens to find the newly created element
            $browser->visit(new specimenPage)
                ->select('@cora-search-options','SE-DN')
                ->pause(1000)
                ->type('@cora-search',$newSkeletalElement)
                ->click('@cora-search-button')
                ->pause(1000)
                ->assertSee('54321')
                ->assertSee('8888')
                ->assertSee('7777')
                ->assertSee('Left')
                ->assertSee($newSkeletalElement)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a valid specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateSkeletalElementOrgAdmin
     * @group AuthorKyle
     */
    public function CreateSkeletalElementOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];

        $this->browse(function ($browser) use ($user) {
            $newSkeletalElement = 'TEST'.rand(10000,99999);
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                //Create new specimen
                ->assertPathIs('/skeletalelements/create')
                ->select('@accession-number','54321')
                ->select('@provenance1','8888')
                ->select('@provenance2','7777')
                ->type('@designator',$newSkeletalElement)
                ->select('sb_id',rand(1,166))
                ->select('side','Left')
                ->select('completeness','Complete')
                ->pause(500)
                ->press('@se-save')
                ->pause(500)
                ->waitForText($newSkeletalElement)
                ->assertPathIs('/skeletalelements');


            // Search through specimens to find the newly created element
            $browser->visit(new specimenPage)
                ->select('@cora-search-options','SE-DN')
                ->pause(1000)
                ->type('@cora-search',$newSkeletalElement)
                ->click('@cora-search-button')
                ->pause(1000)
                ->assertSee('54321')
                ->assertSee('8888')
                ->assertSee('7777')
                ->assertSee('Left')
                ->assertSee($newSkeletalElement)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a group of articulated specimens.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateGroup
     * @group AuthorKyle
     */
    public function CreateGroup()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $newSkeletalElement = ''.rand(10000,99999);
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new-group')
                ->pause(1000)

                // Create new specimen group
                ->assertPathIs('/skeletalelements/createbygroup')
                ->select('@se-grouping','Shoulder')
                ->type('@se-designator',$newSkeletalElement)
                ->select('@side-group','Left')
                ->select('@completeness-group','Complete')
                ->select('@se-trauma-select','18')
                ->select('@se-pathology-select','2')
                ->select('@se-taphonomy-select','4')
                ->click('@se-bone-group-save')
                ->pause(1000)

                // Verify the New Group was Created
                ->assertPathIs('/skeletalelements/storebygroup')
                ->assertSee('Specimens Created by Articulations Group')
                ->pause(1000)
                //->assertInputValue('@se-accession','55555')
                //->assertInputValue('@se-provenance1','134136')
                //->assertInputValue('@se-provenance2','4674567467')
                ->assertInputValue('@se-designator',$newSkeletalElement)
                ->assertSee('Left')
                ->assertSee('Complete')
                ->assertSee('Shoulder')
                ->assertSee('Clavicle')
                ->assertSee('Scapula')
                ->assertSee('Possible perimortem-Sharp force')
                ->assertSee('Density-Osteoporosis')
                ->assertSee('Bio-Adherent Materials-Crystals')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a group of articulated specimens for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateGroupManager
     * @group AuthorKyle
     */
    public function CreateGroupManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $newSkeletalElement = ''.rand(10000,99999);
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new-group')
                ->pause(1000)

                // Create new specimen group
                ->assertPathIs('/skeletalelements/createbygroup')
                ->select('@se-grouping','Shoulder')
                ->type('@se-designator',$newSkeletalElement)
                ->select('@side-group','Left')
                ->select('@completeness-group','Complete')
                ->select('@se-trauma-select','18')
                ->select('@se-pathology-select','2')
                ->select('@se-taphonomy-select','4')
                ->click('@se-bone-group-save')
                ->pause(1000)

                // Verify the New Group was Created
                ->assertPathIs('/skeletalelements/storebygroup')
                ->assertSee('Specimens Created by Articulations Group')
                ->pause(1000)
                //->assertInputValue('@se-accession','55555')
                //->assertInputValue('@se-provenance1','134136')
                //->assertInputValue('@se-provenance2','4674567467')
                ->assertInputValue('@se-designator',$newSkeletalElement)
                ->assertSee('Left')
                ->assertSee('Complete')
                ->assertSee('Shoulder')
                ->assertSee('Clavicle')
                ->assertSee('Scapula')
                ->assertSee('Possible perimortem-Sharp force')
                ->assertSee('Density-Osteoporosis')
                ->assertSee('Bio-Adherent Materials-Crystals')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a group of articulated specimens.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateGroupOrgAdmin
     * @group AuthorKyle
     */
    public function CreateGroupOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $newSkeletalElement = ''.rand(10000,99999);
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new-group')
                ->pause(1000)

                // Create new specimen group
                ->assertPathIs('/skeletalelements/createbygroup')
                ->select('@se-grouping','Shoulder')
                ->type('@se-designator',$newSkeletalElement)
                ->select('@side-group','Left')
                ->select('@completeness-group','Complete')
                ->select('@se-trauma-select','18')
                ->select('@se-pathology-select','2')
                ->select('@se-taphonomy-select','4')
                ->click('@se-bone-group-save')
                ->pause(1000)

                // Verify the New Group was Created
                ->assertPathIs('/skeletalelements/storebygroup')
                ->assertSee('Specimens Created by Articulations Group')
                ->pause(1000)
                //->assertInputValue('@se-accession','55555')
                //->assertInputValue('@se-provenance1','134136')
                //->assertInputValue('@se-provenance2','4674567467')
                ->assertInputValue('@se-designator',$newSkeletalElement)
                ->assertSee('Left')
                ->assertSee('Complete')
                ->assertSee('Shoulder')
                ->assertSee('Clavicle')
                ->assertSee('Scapula')
                ->assertSee('Possible perimortem-Sharp force')
                ->assertSee('Density-Osteoporosis')
                ->assertSee('Bio-Adherent Materials-Crystals')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal creation failure to validate the existence of duplicate creation attribute rules.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateFailDuplicate
     * @group AuthorKyle
     */
    public function CreateFailDuplicateElement()
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
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate a duplicate record cannot be created
                ->select('@accession-number', 'UNO 2016-212')
                ->select('@provenance1', 'G-01')
                ->select('@provenance2', 'X-233E')
                ->type('@designator', '401')
                ->select('sb_id','2')
                ->select('side','Left')
                ->select('completeness','Complete')
                ->pause(500)
                ->press('Save')
                ->pause(500)
                ->assertSee('Specimen add unsuccessful Duplicate composite key violation.')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal creation failure to validate the existence of duplicate creation attribute rules for a manager
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateFailDuplicateManager
     * @group AuthorKyle
     */
    public function CreateFailDuplicateElementManager()
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
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate a duplicate record cannot be created
                ->select('@accession-number', 'UNO 2016-212')
                ->select('@provenance1', 'G-01')
                ->select('@provenance2', 'X-233E')
                ->type('@designator', '401')
                ->select('sb_id','2')
                ->select('side','Left')
                ->select('completeness','Complete')
                ->pause(500)
                ->press('Save')
                ->pause(500)
                ->assertSee('Specimen add unsuccessful Duplicate composite key violation.')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal creation failure to validate the existence of duplicate creation attribute rules for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateFailDuplicateOrgAdmin
     * @group AuthorKyle
     */
    public function CreateFailDuplicateElementOrgAdmin()
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
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate a duplicate record cannot be created
                ->select('@accession-number', 'UNO 2016-212')
                ->select('@provenance1', 'G-01')
                ->select('@provenance2', 'X-233E')
                ->type('@designator', '401')
                ->select('sb_id','2')
                ->select('side','Left')
                ->select('completeness','Complete')
                ->pause(500)
                ->press('Save')
                ->pause(500)
                ->assertSee('Specimen add unsuccessful Duplicate composite key violation.')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal creation failure to validate the existence of accession number attribute rules.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateFailAccession
     * @group AuthorKyle
     */
    /*
    public function CreateFailAccession()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new LoginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new SkeletalElementsPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the accession number must be at least 3 characters
                ->type('@accession-number', '-1')
                ->press('Save')
                //#app > div.app-content > div > div > div > div > div.panel-body > form > div:nth-child(10) > div
                ->assertSee('The accession number must be at least 3 characters.')
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the accession number may only contain letters, numbers, dashes and spaces
                ->type('@accession-number', '###')
                ->press('Save')
                ->assertSee('The accession number may only contain letters, numbers, dashes and spaces.')
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the accession number must be at least 3 characters and the accession number may only contain letters, numbers, dashes and spaces
                ->type('@accession-number', '##')
                ->press('Save')
                ->assertSee('The accession number must be at least 3 characters.')
                ->assertSee('The accession number may only contain letters, numbers, dashes and spaces.')
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the accession number cannot be blank
                ->type('@accession-number', '')
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                ->logoutUser();
        });
    }
    */
    /**
     * A Dusk test to perform a skeletal creation failure to validate the existence of provenance 1 attribute rules.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateFailProvenance1
     * @group AuthorKyle
     */
    /*
    public function CreateFailProvenance1()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new LoginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new SkeletalElementsPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the provenance1 may only contain letters, numbers, dashes and spaces.
                ->type('@accession-number', 'TEST')
                ->type('@provenance1', '#')
                ->press('Save')
                ->assertSee('The provenance1 may only contain letters, numbers, dashes and spaces.')

                ->logoutUser();
        });
    }
    */
    /**
     * A Dusk test to perform a skeletal creation failure to validate the existence of provenance 2 attribute rules.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateFailProvenance2
     * @group AuthorKyle
     */
    /*
    public function CreateFailProvenance2()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new LoginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new SkeletalElementsPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the provenance2 may only contain letters, numbers, dashes and spaces.
                ->type('@accession-number', 'TEST')
                ->type('@provenance2', '#')
                ->press('Save')
                ->assertSee('The provenance2 may only contain letters, numbers, dashes and spaces.')

                ->logoutUser();
        });
    }
    */
    /**
     * A Dusk test to perform a skeletal creation failure to validate the existence of designator attribute rules.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateFailDesignator
     * @group AuthorKyle
     */
    public function CreateFailDesignator()
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
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the designator may only contain letters and numbers
                ->select('@accession-number', 'UNO 2016-212')
                ->type('@designator', '---')
                ->press('Save')
                ->assertSee('The designator may only contain letters and numbers.');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the designator is required
                ->type('@designator', '')
                ->press('Save')
                ->pause(1000)
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal creation failure to validate the existence of designator attribute rules for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateFailDesignatorManager
     * @group AuthorKyle
     */
    public function CreateFailDesignatorManager()
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
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the designator may only contain letters and numbers
                ->select('@accession-number', 'UNO 2016-212')
                ->type('@designator', '---')
                ->press('Save')
                ->assertSee('The designator may only contain letters and numbers.');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the designator is required
                ->type('@designator', '')
                ->press('Save')
                ->pause(1000)
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal creation failure to validate the existence of designator attribute rules for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsCreate
     * @group UNO
     * @group CreateFailDesignatorOrgAdmin
     * @group AuthorKyle
     */
    public function CreateFailDesignatorOrgAdmin()
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
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the designator may only contain letters and numbers
                ->select('@accession-number', 'UNO 2016-212')
                ->type('@designator', '---')
                ->press('Save')
                ->assertSee('The designator may only contain letters and numbers.');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->press('@se-new')
                ->pause(1000)

                // New Specimen Assertions
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                // Validate the designator is required
                ->type('@designator', '')
                ->press('Save')
                ->pause(1000)
                ->assertPathIs('/skeletalelements/create')
                ->assertSee('New Specimen')

                ->logoutUser();
        });
    }
}
