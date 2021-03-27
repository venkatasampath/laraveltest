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

// 13 Total Test Cases
class specimen_SearchTest extends coraBaseTest
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
     * A Dusk test for invalid user login
     *
     * @return void
     * @throws
     * @test
     * @group invalidUser
     */
    public function invalidUserAttempt()
    {
        $user = $this->testAccounts["invalid-user"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('These credentials do not match our records');
        });
    }
    /**
     * A Dusk test to validate a skeletal search criteria
     *
     * @return void
     * @throws
     * @test
     * @group AnalystSpecimenSearchAll
     * @group AnalystSpecimenSearch

     */
    public function SearchCriteria()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000);

            $browser->visit(new specimenPage)
                ->pause(5000)
//              checking invalid input results
                ->press('@cora-search-options')
                ->input('@cora-search-options', '123')
                ->assertSee('No data available')
                ->clear('@cora-search-options')
                ->press('@cora-search-options')
                ->pause(1000)
                //Check Search By Options
                ->assertSee('Bone')
                ->assertSee('Composite Key')
                ->assertSee('Accession')
                ->assertSee('Provenance 1')
                ->assertSee('Provenance 2')
                ->assertSee('Designator')
                ->assertSee('Individual Number')
                ->assertSee('Tags')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to validate a skeletal search criteria for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ManagerSpecimenSearch
     * @group ManagerSearchOptions
     * @group SkeletalElementsSearch
     * @group UNO
     * @group managerSE_search
     * @group SearchCriteriaManager
     * @group AuthorKyle
     */
    public function SearchCriteriaManager()
    {
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            $browser->visit(new specimenPage)
                ->pause(5000)
//              checking invalid input results
                ->press('@cora-search-options')
                ->input('@cora-search-options', '123')
                ->assertSee('No data available')
                ->clear('@cora-search-options')
                ->press('@cora-search-options')
                ->pause(1000)
                //Check Search By Options
                ->assertSee('Bone')
                ->assertSee('Composite Key')
                ->assertSee('Accession')
                ->assertSee('Provenance 1')
                ->assertSee('Provenance 2')
                ->assertSee('Designator')
                ->assertSee('Individual Number')
                ->assertSee('Tags')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to validate a skeletal search criteria for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group AdminSpecimenSearch
     * @group AdminSearchOptions
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchCriteriaOrgAdmin
     * @group AuthorKyle
     */
    public function SearchCriteriaOrgAdmin()
    {
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');

            $browser->visit(new specimenPage)
                ->pause(5000)
                ->press('@cora-search-options')
//              checking invalid input results
                ->press('@cora-search-options')
                ->input('@cora-search-options', '123')
                ->assertSee('No data available')
                ->clear('@cora-search-options')
                ->pause(1000)
                //Check Search By Options
                ->assertSee('Bone')
                ->assertSee('Composite Key')
                ->assertSee('Accession')
                ->assertSee('Provenance 1')
                ->assertSee('Provenance 2')
                ->assertSee('Designator')
                ->assertSee('Individual Number')
                ->assertSee('Tags')
                ->logoutUser();
        });
    }

    /**
     * A Dusk test to perform a skeletal search by provenance 1 and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group clearTest
     * @group AnalystSpecimenSearch
     * @group AnalystProvenance1Search
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userSE_search
     * @group SE
     * @group SearchProvenance1
     * @group AuthorKyle
     * @group Failure1
     */
    public function SearchProvenance1()
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
                ->type('@cora-search-options','Provenance 1')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
//              checking invalid input results
                ->press('@cora-search-options-provenance1')
                ->input('@cora-search-options-provenance1', '123')
                ->assertSee('No data available')
                ->clear('@cora-search-options')
                ->keys('@cora-search-options-provenance1','G-04',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance1',['{tab}'])
                ->press('@search-btn')
                ->pause(60000)

                // Search Result Assertions for cranium CIL 2003-116:G-04:X-56A:101
                ->waitForLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSeeLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-04:X-56A:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-04:X-56A:101')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-04', '@specimen')
                ->assertVue('form.provenance2','X-56A', '@specimen')
                ->assertInputValue('@designator', '101')
                ->assertVue('form.sb_id','18','@specimen')
                ->assertVue('form.side', 'Middle', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }

    /**
     * A Dusk test to perform a skeletal search by composite key and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group clearTest
     * @group AnalystCompositeSearch
     * @group AnalystSpecimenSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userSE_search
     * @group SE
     * @group SearchCompositeKey
     * @group AuthorKyle
     */
    public function SearchCompositeKey()
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
                ->type('@cora-search-options','Composite Key')
                ->pause(1000)
                ->clear('@cora-search-options')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','CIL 2003-116:G-25:X-247A:202')
                ->keys('@cora-search','{enter}')
                ->pause(50000)
//
//                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSee('Humerus')
                ->assertSee('Right')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(500)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
//
            $browser
                ->pause(500)
                ->assertSee('CIL 2003-116:G-25:X-247A:202 :: Humerus-Right')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-25', '@specimen')
                ->assertVue('form.provenance2','X-247A', '@specimen')
                ->assertInputValue('@designator', '202')
                ->assertVue('form.sb_id','37','@specimen')
                ->assertVue('form.side', 'Right', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', null , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')
                ->assertSee('Comments')
                ->assertSee('Leave a comment')


                ->logoutUser();

        });
    }

    /**
     * A Dusk test to perform a skeletal search by provenance 2 and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group AnalystSpecimenSearch
     * @group AnalystProvenance2Search
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userSE_search
     * @group SE
     * @group SearchProvenance2
     * @group AuthorKyle
     */
    public function SearchProvenance2()
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
                ->type('@cora-search-options','Provenance 2')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance2','X-232G',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance2',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)

                // Search Result Assertions for os coxa CIL 2003-116:G-25:X-232G:903
                ->waitForLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSeeLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')  //assertsee more items

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-232G:903')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-232G:903')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-25', '@specimen')
                ->assertVue('form.provenance2','X-232G', '@specimen')
                ->assertInputValue('@designator', '903')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Unsided', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', null , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();

        });
    }
    /**
     * A Dusk test to perform a skeletal search by designator and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group AnalystSpecimenSearch
     * @group AnalystDesignatorSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userSE_search
     * @group SE
     * @group SearchDesignator
     * @group AuthorKyle
     */
    public function SearchDesignator()
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
                ->type('@cora-search-options','Designator')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','101')
                ->keys('@cora-search','{enter}')
                ->pause(50000)

                // Search Result Assertions
                ->waitForLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSeeLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247C:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247C:101')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-25', '@specimen')
                ->assertVue('form.provenance2','X-247C', '@specimen')
                ->assertInputValue('@designator', '101')
                ->assertVue('form.sb_id','18','@specimen')
                ->assertVue('form.side', 'Middle', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-86', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();

        });
    }
    /**
     * A Dusk test to perform a skeletal search by individual number and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group AnalystSpecimenSearch
     * @group AnalystIndividualNumberSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userSE_search
     * @group SE
     * @group SearchIndividualNumber
     * @group AuthorKyle
     */
    public function SearchIndividualNumber()
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
                ->type('@cora-search-options','Individual Number')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-individual-number','CIL 2003-116-I-136',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-individual-number',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)
                // Search Result Assertions
                ->assertSee('Specimen search by Individual Number: CIL 2003-116-I-136')
                ->waitForLink('CIL 2003-116:G-01:X-234A:202')
                ->assertSeeLink('CIL 2003-116:G-01:X-234A:202')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-01:X-234A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-01:X-234A:202')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-01', '@specimen')
                ->assertVue('form.provenance2','X-234A', '@specimen')
                ->assertInputValue('@designator', '202')
                ->assertVue('form.sb_id','37','@specimen')
                ->assertVue('form.side', 'Right', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', true, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-136', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();

        });
    }
    /**
     * A Dusk test to perform a skeletal search by bone and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group AnalystSpecimenSearch
     * @group AnalystBoneSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userSE_search
     * @group SE
     * @group SearchBone
     * @group AuthorKyle
     */
    public function SearchBone()
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
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-28:X-13B:902')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-28', '@specimen')
                ->assertVue('form.provenance2','X-13B', '@specimen')
                ->assertInputValue('@designator', '902')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', null , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-286', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();

        });
    }
    /**
     * A Dusk test to perform a skeletal search by accession number and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group AnalystSpecimenSearch
     * @group AnalystAccessionNumberSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userSE_search
     * @group SE
     * @group SearchAccession
     * @group AuthorKyle
     */
    public function SearchAccession()
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
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(60000)
                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2018-337::X-100:201')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2018-337::X-100:201')
                ->assertVue('form.accession_number','CIL 2018-337', '@specimen')
                ->assertVue('form.provenance1',null, '@specimen')
                ->assertVue('form.provenance2','X-100', '@specimen')
                ->assertInputValue('@designator', '201')
                ->assertVue('form.sb_id','37','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', null, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by tags and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group AnalystSpecimenSearch
     * @group AnalystTagsSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userSE_Search
     * @group SearchTags
     * @group AuthorKyle
     */
    public function SearchTags()
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
                ->type('@cora-search-options','Tags')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-tags',['{ENTER}'])
                ->pause(1000)
                ->assertSee('No data available')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by composite key and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ManagerSpecimenSearch
     * @group ManagerCompositeSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group managerSE_search
     * @group SearchCompositeKeyManager
     * @group AuthorKyle
     */
    public function SearchCompositeKeyManager()
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
                ->assertSee('Humerus')
                ->assertSee('Right')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')
//
//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
//
            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247A:202')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-25', '@specimen')
                ->assertVue('form.provenance2','X-247A', '@specimen')
                ->assertInputValue('@designator', '202')
                ->assertVue('form.sb_id','37','@specimen')
                ->assertVue('form.side', 'Right', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', null , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by provenance 1 and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ManagerSpecimenSearch
     * @group ManagerCompositeSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group managerSE_search
     * @group SearchProvenance1Manager
     * @group AuthorKyle
     */
    public function SearchProvenance1Manager()
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
                ->type('@cora-search-options','Provenance 1')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance1','G-04',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance1',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)

                // Search Result Assertions for cranium CIL 2003-116:G-04:X-56A:101
                ->waitForLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSeeLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-04:X-56A:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-04:X-56A:101')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-04', '@specimen')
                ->assertVue('form.provenance2','X-56A', '@specimen')
                ->assertInputValue('@designator', '101')
                ->assertVue('form.sb_id','18','@specimen')
                ->assertVue('form.side', 'Middle', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by provenance 2 and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ManagerSpecimenSearch
     * @group ManagerProvenance2Search
     * @group SkeletalElementsSearch
     * @group UNO
     * @group managerSE_search
     * @group SearchProvenance2Manager
     * @group AuthorKyle
     */
    public function SearchProvenance2Manager()
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
                ->type('@cora-search-options','Provenance 2')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance2','X-232G',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance2',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)

                // Search Result Assertions for os coxa CIL 2003-116:G-25:X-232G:903
                ->waitForLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSeeLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-232G:903')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(2000)
                ->assertSee('CIL 2003-116:G-25:X-232G:903')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-25', '@specimen')
                ->assertVue('form.provenance2','X-232G', '@specimen')
                ->assertInputValue('@designator', '903')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Unsided', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', null , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
            ;
        });
    }
    /**
     * A Dusk test to perform a skeletal search by designator and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ManagerSpecimenSearch
     * @group ManagerDesignatorSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group managerSE_search
     * @group SearchDesignatorManager
     * @group AuthorKyle
     */
    public function SearchDesignatorManager()
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
                ->type('@cora-search-options','Designator')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','101')
                ->keys('@cora-search','{enter}')
                ->pause(50000)

                // Search Result Assertions
                ->waitForLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSeeLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247C:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247C:101')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-25', '@specimen')
                ->assertVue('form.provenance2','X-247C', '@specimen')
                ->assertInputValue('@designator', '101')
                ->assertVue('form.sb_id','18','@specimen')
                ->assertVue('form.side', 'Middle', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-86', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by individual number and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ManagerSpecimenSearch
     * @group ManagerIndividualNumberSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group managerSE_search
     * @group SearchIndividualNumberManager
     * @group AuthorKyle
     */
    public function SearchIndividualNumberManager()
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
                ->type('@cora-search-options','Individual Number')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-individual-number','CIL 2003-116-I-136',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-individual-number',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)
                // Search Result Assertions
                ->assertSee('Specimen search by Individual Number: CIL 2003-116-I-136')
                ->waitForLink('CIL 2003-116:G-01:X-234A:202')
                ->assertSeeLink('CIL 2003-116:G-01:X-234A:202')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-01:X-234A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-01:X-234A:202')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-01', '@specimen')
                ->assertVue('form.provenance2','X-234A', '@specimen')
                ->assertInputValue('@designator', '202')
                ->assertVue('form.sb_id','37','@specimen')
                ->assertVue('form.side', 'Right', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', true, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-136', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();

        });
    }
    /**
     * A Dusk test to perform a skeletal search by bone and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ManagerSpecimenSearch
     * @group ManagerBoneSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group managerSE_search
     * @group SearchBoneManager
     * @group AuthorKyle
     */
    public function SearchBoneManager()
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
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-28:X-13B:902')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-28', '@specimen')
                ->assertVue('form.provenance2','X-13B', '@specimen')
                ->assertInputValue('@designator', '902')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', null , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-286', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by accession number and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ManagerSpecimenSearch
     * @group ManagerAccessionNumberSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group managerSE_search
     * @group SearchAccessionManager
     * @group AuthorKyle
     */
    public function SearchAccessionManager()
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
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)
                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2018-337::X-100:201')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2018-337::X-100:201')
                ->assertVue('form.accession_number','CIL 2018-337', '@specimen')
                ->assertVue('form.provenance1',null, '@specimen')
                ->assertVue('form.provenance2','X-100', '@specimen')
                ->assertInputValue('@designator', '201')
                ->assertVue('form.sb_id','37','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', null, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by tags and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ManagerSpecimenSearch
     * @group ManagerTagsSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgManger_SE_Search
     * @group SearchTagsManager
     * @group AuthorKyle
     */
    public function SearchTagsManager()
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
                ->type('@cora-search-options','Tags')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-tags',['{ENTER}'])
                ->pause(1000)
                ->assertSee('No data available')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by composite key and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group AdminSpecimenSearch
     * @group AdminCompositeSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchCompositeKeyOrgAdmin
     * @group AuthorKyle
     */
    public function SearchCompositeKeyOrgAdmin()
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
                ->assertSee('Humerus')
                ->assertSee('Right')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')
//
//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
//
            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247A:202')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-25', '@specimen')
                ->assertVue('form.provenance2','X-247A', '@specimen')
                ->assertInputValue('@designator', '202')
                ->assertVue('form.sb_id','37','@specimen')
                ->assertVue('form.side', 'Right', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', null , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by provenance 1 and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group AdminSpecimenSearch
     * @group AdminProvenance1Search
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchProvenance1OrgAdmin
     * @group AuthorKyle
     */
    public function SearchProvenance1OrgAdmin()
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
                ->type('@cora-search-options','Provenance 1')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance1','G-04',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance1',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)

                // Search Result Assertions for cranium CIL 2003-116:G-04:X-56A:101
                ->waitForLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSeeLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-04:X-56A:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-04:X-56A:101')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-04', '@specimen')
                ->assertVue('form.provenance2','X-56A', '@specimen')
                ->assertInputValue('@designator', '101')
                ->assertVue('form.sb_id','18','@specimen')
                ->assertVue('form.side', 'Middle', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by provenance 2 and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group AdminSpecimenSearch
     * @group AdminProvenance2Search
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchProvenance2OrgAdmin
     * @group AuthorKyle
     */
    public function SearchProvenance2OrgAdmin()
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
                ->type('@cora-search-options','Provenance 2')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance2','X-232G',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance2',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)

                // Search Result Assertions for os coxa CIL 2003-116:G-25:X-232G:903
                ->waitForLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSeeLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-232G:903')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-232G:903')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-25', '@specimen')
                ->assertVue('form.provenance2','X-232G', '@specimen')
                ->assertInputValue('@designator', '903')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Unsided', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', null , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
            ;
        });
    }
    /**
     * A Dusk test to perform a skeletal search by designator and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group AdminSpecimenSearch
     * @group AdminDesignatorSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchDesignatorOrgAdmin
     * @group AuthorKyle
     */
    public function SearchDesignatorOrgAdmin()
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
                ->type('@cora-search-options','Designator')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','101')
                ->keys('@cora-search','{enter}')
                ->pause(50000)

                // Search Result Assertions
                ->waitForLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSeeLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247C:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-25:X-247C:101')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-25', '@specimen')
                ->assertVue('form.provenance2','X-247C', '@specimen')
                ->assertInputValue('@designator', '101')
                ->assertVue('form.sb_id','18','@specimen')
                ->assertVue('form.side', 'Middle', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-86', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();

        });
    }
    /**
     * A Dusk test to perform a skeletal search by individual number and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group AdminSpecimenSearch
     * @group AdminIndividualNumberSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchIndividualNumberOrgAdmin
     * @group AuthorKyle
     */
    public function SearchIndividualNumberOrgAdmin()
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
                ->type('@cora-search-options','Individual Number')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-individual-number','CIL 2003-116-I-136',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-individual-number',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)
                // Search Result Assertions
                ->assertSee('Specimen search by Individual Number: CIL 2003-116-I-136')
                ->waitForLink('CIL 2003-116:G-01:X-234A:202')
                ->assertSeeLink('CIL 2003-116:G-01:X-234A:202')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-01:X-234A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-01:X-234A:202')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-01', '@specimen')
                ->assertVue('form.provenance2','X-234A', '@specimen')
                ->assertInputValue('@designator', '202')
                ->assertVue('form.sb_id','37','@specimen')
                ->assertVue('form.side', 'Right', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', true, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-136', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();

        });
    }
    /**
     * A Dusk test to perform a skeletal search by bone and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group AdminSpecimenSearch
     * @group AdminBoneSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchBoneOrgAdmin
     * @group AuthorKyle
     */
    public function SearchBoneOrgAdmin()
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
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2003-116:G-28:X-13B:902')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-28', '@specimen')
                ->assertVue('form.provenance2','X-13B', '@specimen')
                ->assertInputValue('@designator', '902')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Incomplete', '@specimen')
                ->assertVue('form.measured', null, '@specimen')
                ->assertVue('form.dna_sampled', null , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-286', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();

        });
    }
    /**
     * A Dusk test to perform a skeletal search by accession number and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group AdminSpecimenSearch
     * @group AdminAccessionNumber
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchAccessionOrgAdmin
     * @group AuthorKyle
     */
    public function SearchAccessionOrgAdmin()
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
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(50000)
                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2018-337::X-100:201')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('CIL 2018-337::X-100:201')
                ->assertVue('form.accession_number','CIL 2018-337', '@specimen')
                ->assertVue('form.provenance1',null, '@specimen')
                ->assertVue('form.provenance2','X-100', '@specimen')
                ->assertInputValue('@designator', '201')
                ->assertVue('form.sb_id','37','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', null, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', null, '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by tags and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group AdminSpecimenSearch
     * @group AdminTagsSearch
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchAccessionOrgAdmin
     * @group AuthorKyle
     */
    public function SearchTagsOrgAdmin()
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
                ->type('@cora-search-options','Tags')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-tags',['{ENTER}'])
                ->pause(1000)
                ->assertSee('No data available')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the column sort functions and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsSearchOrgAdmin
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group ResultPage
     * @group SearchSortOrgAdmin
     * @group AuthorKyle
     */
    public function SearchSortOrgAdmin()
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
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Key Sort Assertions
                ->click('@se-key-sort')
                ->waitForText('ABC999')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('ABC999')
                ->assertSeeLink('ABC999-888-777-555')


                // Bone Sort Assertions
                ->click('@se-bone-sort')
                ->waitForText('Humerus')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSeeLink('ABC999-888-777-555')

                // Side Sort Assertions
                ->click('@se-side-sort')
                ->waitForText('Left')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('Left')
                ->assertSeeLink('ABC999-888-777-555')

                // DNA Sampled Sort Assertions
                ->click('@se-DNA-sampled-sort')
                ->waitForText('Humerus')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/searchgo')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the search filter box and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @AnalystSearchFilterBox
     * @group AnalystSearchFilterBox
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userDNA_search
     * @group ResultPage
     * @group SearchFilterBox
     * @group AuthorKyle
     */
    public function SearchFilterBox()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(500)
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(500)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(1000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')


                // Filter box assertions (not working)
                ->type('@cora-search-datatable','Left')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertDontSee('Middle')
                ->assertDontSee('Right')
                ->assertDontSee('Unsided')

                ->type('@se-search-box','Humerus')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertDontSee('CIL 2018-337::X-100:604')

                ->type('@se-search-box','314')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertDontSee('CIL 2018-337::X-100:1000')
                ->assertDontSee('CIL 2018-337::X-100:203')

                ->logoutUser();

        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the search filter box and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ManagerSearchFilterBox
     * @group SkeletalElementsSearch
     * @group UNO
     * @group managerSE_search
     * @group ResultPage
     * @group SearchFilterBoxManager
     * @group AuthorKyle
     */
    public function SearchFilterBoxManager()
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
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')


                // Filter box assertions
                ->type('@cora-search-datatable','Left')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertDontSee('Middle')
                ->assertDontSee('Right')
                ->assertDontSee('Unsided')

                ->type('@se-search-box','Humerus')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertDontSee('CIL 2018-337::X-100:604')

                ->type('@se-search-box','314')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertDontSee('CIL 2018-337::X-100:1000')
                ->assertDontSee('CIL 2018-337::X-100:203')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the search filter box and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group ResultPage
     * @group SearchFilterBoxOrgAdmin
     * @group AuthorKyle
     */
    public function SearchFilterBoxOrgAdmin()
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
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')


                // Filter box assertions
                ->type('@cora-search-datatable','Left')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertDontSee('Middle')
                ->assertDontSee('Right')
                ->assertDontSee('Unsided')

                ->type('@se-search-box','Humerus')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertDontSee('CIL 2018-337::X-100:604')

                ->type('@se-search-box','314')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertDontSee('CIL 2018-337::X-100:1000')
                ->assertDontSee('CIL 2018-337::X-100:203')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the column sort functions and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group AnalystColumnVisibility
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userSE_search
     * @group ResultPage
     * @group SearchSort
     * @group AuthorKyle
     */
    public function SearchSort()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(1000)
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(1000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Key Sort Assertions
                ->click('@se-key-sort')
                ->waitForText('ABC999')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('ABC999')
                ->assertSeeLink('ABC999-888-777-555')


                // Bone Sort Assertions
                ->click('@se-bone-sort')
                ->waitForText('Humerus')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSeeLink('ABC999-888-777-555')

                // Side Sort Assertions
                ->click('@se-side-sort')
                ->waitForText('Left')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('Left')
                ->assertSeeLink('ABC999-888-777-555')

                // DNA Sampled Sort Assertions
                ->click('@se-DNA-sampled-sort')
                ->waitForText('Humerus')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/searchgo')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the column sort functions and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsSearchManager
     * @group UNO
     * @group managerSE_search
     * @group ResultPage
     * @group SearchSortManager
     * @group AuthorKyle
     */
    public function SearchSortManager()
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
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')

                // Key Sort Assertions
                ->click('@se-key-sort')
                ->waitForText('ABC999')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('ABC999')
                ->assertSeeLink('ABC999-888-777-555')


                // Bone Sort Assertions
                ->click('@se-bone-sort')
                ->waitForText('Humerus')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSeeLink('ABC999-888-777-555')

                // Side Sort Assertions
                ->click('@se-side-sort')
                ->waitForText('Left')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('Left')
                ->assertSeeLink('ABC999-888-777-555')

                // DNA Sampled Sort Assertions
                ->click('@se-DNA-sampled-sort')
                ->waitForText('Humerus')
                ->waitForLink('ABC999-888-777-555')
                ->assertSee('Humerus')
                ->assertSeeLink('ABC999-888-777-555')
                ->assertPathIs('/skeletalelements/searchgo')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the show entries functions and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group AnalystShowEntries
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userSE_search
     * @group ResultPage
     * @group SearchEntries
     * @group AuthorKyle
     */
    public function SearchEntries()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(1000)
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(1000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')
                ->assertSee('1-100 of ')

                // Search Entries Assertions
                ->click('@se-entries25')
                ->waitForText('1 to 25 of')
                ->click('@se-entries50')
                ->waitForText('1 to 50 of')
                ->click('@se-entries100')
                ->waitForText('1 to 100 of')


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the show entries functions and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsSearch
     * @group UNO
     * @group managerSE_search
     * @group ResultPage
     * @group SearchEntriesManager
     * @group AuthorKyle
     */
    public function SearchEntriesManager()
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
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(35000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')
                ->assertSee('1-100 of ')

                // Search Entries Assertions
                ->click('@se-entries25')
                ->waitForText('Showing 1 to 25 of')
                ->click('@se-entries50')
                ->waitForText('Showing 1 to 50 of')
                ->click('@se-entries100')
                ->waitForText('Showing 1 to 100 of')


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the show entries functions and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group ResultPage
     * @group SearchEntriesOrgAdmin
     * @group AuthorKyle
     */
    public function SearchEntriesOrgAdmin()
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
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(35000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')


                // Search Entries Assertions
                ->click('@se-entries25')
                ->waitForText('Showing 1 to 25 of')
                ->click('@se-entries50')
                ->waitForText('Showing 1 to 50 of')
                ->click('@se-entries100')
                ->waitForText('Showing 1 to 100 of')


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the pagination functions and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group AnalystPagination
     * @group SkeletalElementsSearch
     * @group UNO
     * @group userSE_search
     * @group ResultPage
     * @group SearchPages
     * @group AuthorKyle
     */
    public function SearchPages()
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
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(35000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')
                ->assertSee('1-100 of ')

                // Search Pagination Assertions
                ->click('@se-next')
                ->pause(5000)
                ->waitForText('101-118 of 118')
                ->click('@se-firstpage')
                ->pause(5000)
                ->waitForText('1-100 of 118')
                ->click('@se-lastpage')
                ->pause(5000)
                ->waitForText('101-118 of 118')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the pagination functions and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsSearch
     * @group UNO
     * @group managerSE_search
     * @group ResultPage
     * @group SearchPagesManager
     * @group AuthorKyle
     */
    public function SearchPagesManager()
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
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(35000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')
                ->assertSee('1-100 of ')

                // Search Pagination Assertions
                ->click('@se-next')
                ->pause(5000)
                ->waitForText('101-118 of 118')
                ->click('@se-firstpage')
                ->pause(5000)
                ->waitForText('1-100 of 118')
                ->click('@se-lastpage')
                ->pause(5000)
                ->waitForText('101-118 of 118')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search utilizing the pagination functions and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsSearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group ResultPage
     * @group SearchPagesOrgAdmin
     * @group AuthorKyle
     */
    public function SearchPagesOrgAdmin()
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
                ->pause(1000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(35000)

                // Search Result Assertions
                ->assertSee('Specimen search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('DNA Sample Number')
                ->assertSee('1-100 of ')

                // Search Pagination Assertions
                ->click('@se-next')
                ->pause(5000)
                ->waitForText('101-118 of 118')
                ->click('@se-firstpage')
                ->pause(5000)
                ->waitForText('1-100 of 118')
                ->click('@se-lastpage')
                ->pause(5000)
                ->waitForText('101-118 of 118')

                ->logoutUser();
        });
    }

}
