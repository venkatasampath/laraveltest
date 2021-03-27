<?php

/**
 * DNASearchTest DuskTestCase
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
class searchTest extends coraBaseTest
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
     * A Dusk test to perform a skeletal search by external ID and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group userDNA_search
     * @group SE
     * @group SearchExternalID
     * @group AuthorKyle
     */
    public function SearchExternalID()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','External #')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->clear('@cora-search')
                ->type('@cora-search','201')
                ->keys('@cora-search','{enter}')
                ->pause(5000)

                // Search Result Assertions
                ->assertSee('DNA search by External Number: 201')
                ->waitForText('No data available')

                ->logoutUser();

        });
    }
    /**
     * A Dusk test to perform a skeletal search by external ID and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group managerDNA_search
     * @group SearchExternalIDManager
     * @group AuthorKyle
     */
    public function SearchExternalIDManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','External #')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->clear('@cora-search')
                ->type('@cora-search','201')
                ->keys('@cora-search','{enter}')
                ->pause(5000)

                // Search Result Assertions
                ->assertSee('DNA search by External Number: 201')
                ->waitForText('No data available')

                ->logoutUser();
            ;
        });
    }
    /**
     * A Dusk test to perform a skeletal search by external ID and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group orgAdmin_DNA_Search
     * @group SearchExternalIDOrgAdmin
     * @group AuthorKyle
     */
    public function SearchExternalIDOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','External #')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->clear('@cora-search')
                ->type('@cora-search','201')
                ->keys('@cora-search','{enter}')
                ->pause(5000)

                // Search Result Assertions
                ->assertSee('DNA search by External Number: 201')
                ->waitForText('No data available')

                ->logoutUser();

        });
    }
    /**
     * A Dusk test to perform a skeletal search by bone DNA and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group userDNA_search
     * @group DNA
     * @group SearchBoneDNA
     * @group AuthorKyle
     */
    public function SearchBoneDNA()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Bone')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones','Os coxa',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-bones',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)
                // Search Result Assertions
                ->assertSee('DNA search by Bone: Os coxa')
                ->waitForLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSeeLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-28:X-13B:902')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-28:X-13B:902')
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
     * A Dusk test to perform a skeletal search by bone DNA and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group managerDNA_search
     * @group SearchBoneDNAManager
     * @group AuthorKyle
     */
    public function SearchBoneDNAManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Bone')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones','Os coxa',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-bones',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)
                // Search Result Assertions
                ->assertSee('DNA search by Bone: Os coxa')
                ->waitForLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSeeLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-28:X-13B:902')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-28:X-13B:902')
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
     * A Dusk test to perform a skeletal search by bone DNA and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group orgAdmin_DNA_Search
     * @group SearchBoneDNAOrgAdmin
     * @group AuthorKyle
     */
    public function SearchBoneDNAOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Bone')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-bones','Os coxa',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-bones',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)
                // Search Result Assertions
                ->assertSee('DNA search by Bone: Os coxa')
                ->waitForLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSeeLink('CIL 2003-116:G-28:X-13B:902')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-28:X-13B:902')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-28:X-13B:902')
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
     * A Dusk test to perform a skeletal search by composite key DNA and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group userDNA_search
     * @group DNA
     * @group SearchCompositeKeyDNA
     * @group AuthorKyle
     */
    public function SearchCompositeKeyDNA()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Composite Key')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','CIL 2003-116:G-25:X-247A:202')
                ->keys('@cora-search','{enter}')
                ->pause(30000)
//
//                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSee('Humerus')
                ->assertSee('Right')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')
//
//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
//
            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-25:X-247A:202')
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
     * A Dusk test to perform a skeletal search by composite key DNA and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group managerDNA_search
     * @group SearchCompositeKeyDNAManager
     * @group AuthorKyle
     */
    public function SearchCompositeKeyDNAManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Composite Key')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','CIL 2003-116:G-25:X-247A:202')
                ->keys('@cora-search','{enter}')
                ->pause(30000)
//
//                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSee('Humerus')
                ->assertSee('Right')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')
//
//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
//
            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-25:X-247A:202')
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
     * A Dusk test to perform a skeletal search by composite key DNA and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group orgAdmin_DNA_Search
     * @group SearchCompositeKeyDNAOrgAdmin
     * @group AuthorKyle
     */
    public function SearchCompositeKeyDNAOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Composite Key')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','CIL 2003-116:G-25:X-247A:202')
                ->keys('@cora-search','{enter}')
                ->pause(30000)
//
//                // Search Result Assertions for humerus ABC999-888-777-555
                ->waitForLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSeeLink('CIL 2003-116:G-25:X-247A:202')
                ->assertSee('Humerus')
                ->assertSee('Right')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')
//
//                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247A:202')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
//
            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-25:X-247A:202')
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
     * A Dusk test to perform a skeletal search by accession number DNA and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group userDNA_search
     * @group DNA
     * @group SearchAccessionDNA
     * @group AuthorKyle
     */
    public function SearchAccessionDNA()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)
                // Search Result Assertions
                ->assertSee('DNA search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2018-337::X-100:201')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2018-337::X-100:201')
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
     * A Dusk test to perform a skeletal search by accession number DNA and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group managerDNA_search
     * @group SearchAccessionDNAManager
     * @group AuthorKyle
     */
    public function SearchAccessionDNAManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)
                // Search Result Assertions
                ->assertSee('DNA search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2018-337::X-100:201')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2018-337::X-100:201')
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
     * A Dusk test to perform a skeletal search by accession number DNA and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group orgAdmin_DNA_Search
     * @group SearchAccessionDNAOrgAdmin
     * @group AuthorKyle
     */
    public function SearchAccessionDNAOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2018-337',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)
                // Search Result Assertions
                ->assertSee('DNA search by Accession Number: CIL 2018-337')
                ->waitForLink('CIL 2018-337::X-100:201')
                ->assertSeeLink('CIL 2018-337::X-100:201')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2018-337::X-100:201')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2018-337::X-100:201')
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
     * A Dusk test to perform a skeletal search by provenance 1 and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch123
     * @group UNO
     * @group userSE_search
     * @group SE
     * @group SearchProvenance1
     * @group AuthorKyle
     */
    public function SearchProvenance1DNA()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Provenance 1')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance1','G-04',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance1',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions for cranium CIL 2003-116:G-04:X-56A:101
                ->waitForLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSeeLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-04:X-56A:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-04:X-56A:101')
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
     * A Dusk test to perform a skeletal search by provenance 2 and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch1
     * @group UNO
     * @group userSE_search
     * @group SE
     * @group SearchProvenance2
     * @group AuthorKyle
     */
    public function SearchProvenance2DNA()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Provenance 2')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance2','X-232G',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance2',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions for os coxa CIL 2003-116:G-25:X-232G:903
                ->waitForLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSeeLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // DNA Assertions
                ->clickLink('CIL 2003-116:G-25:X-232G:903')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-25:X-232G:903')
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
     * @group DNASearch1
     * @group UNO
     * @group userSE_search
     * @group SE
     * @group SearchDesignator
     * @group AuthorKyle
     */
    public function SearchDesignatorDNA()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Designator')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','101')
                ->keys('@cora-search','{enter}')
                ->pause(30000)

                // Search Result Assertions
                ->waitForLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSeeLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-25:X-247C:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-25:X-247C:101')
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
     * A Dusk test to perform a skeletal search by tags and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group userSE_Search
     * @group SearchTags
     * @group AuthorKyle
     */
    public function SearchTagsDNA()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Tags')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-tags',['{ENTER}'])
                ->pause(1000)
                ->assertSee('No data available')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by provenance 1 and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group managerSE_search
     * @group SearchProvenance1Manager
     * @group AuthorKyle
     */
    public function SearchProvenance1DNAManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Provenance 1')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance1','G-04',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance1',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions for cranium CIL 2003-116:G-04:X-56A:101
                ->waitForLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSeeLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // Specimen Assertions
                ->clickLink('CIL 2003-116:G-04:X-56A:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-04:X-56A:101')
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
     * @group DNASearch
     * @group UNO
     * @group managerSE_search
     * @group SearchProvenance2Manager
     * @group AuthorKyle
     */
    public function SearchProvenance2DNAManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Provenance 2')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance2','X-232G',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance2',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions for os coxa CIL 2003-116:G-25:X-232G:903
                ->waitForLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSeeLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // DNA Assertions
                ->clickLink('CIL 2003-116:G-25:X-232G:903')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(2000)
                ->assertSee('View Specimen - CIL 2003-116:G-25:X-232G:903')
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
     * @group DNASearch
     * @group UNO
     * @group managerSE_search
     * @group SearchDesignatorManager
     * @group AuthorKyle
     */
    public function SearchDesignatorDNAManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Designator')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','101')
                ->keys('@cora-search','{enter}')
                ->pause(30000)

                // Search Result Assertions
                ->waitForLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSeeLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // DNA Assertions
                ->clickLink('CIL 2003-116:G-25:X-247C:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-25:X-247C:101')
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
     * A Dusk test to perform a skeletal search by tags and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group orgManger_SE_Search
     * @group SearchTagsManager
     * @group AuthorKyle
     */
    public function SearchTagsDNAManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Tags')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-tags',['{ENTER}'])
                ->pause(1000)
                ->assertSee('No data available')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by provenance 1 and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchProvenance1OrgAdmin
     * @group AuthorKyle
     */
    public function SearchProvenance1DNAOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Provenance 1')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance1','G-04',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance1',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions for cranium CIL 2003-116:G-04:X-56A:101
                ->waitForLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSeeLink('CIL 2003-116:G-04:X-56A:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // DNA Assertions
                ->clickLink('CIL 2003-116:G-04:X-56A:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-04:X-56A:101')
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
     * @group DNASearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchProvenance2OrgAdmin
     * @group AuthorKyle
     */
    public function SearchProvenance2DNAOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Provenance 2')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)
                ->keys('@cora-search-options-provenance2','X-232G',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-provenance2',['{tab}'])
                ->press('@search-btn')
                ->pause(30000)

                // Search Result Assertions for os coxa CIL 2003-116:G-25:X-232G:903
                ->waitForLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSeeLink('CIL 2003-116:G-25:X-232G:903')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // DNA Assertions
                ->clickLink('CIL 2003-116:G-25:X-232G:903')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-25:X-232G:903')
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
     * @group DNASearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchDesignatorOrgAdmin
     * @group AuthorKyle
     */
    public function SearchDesignatorDNAOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Designator')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','101')
                ->keys('@cora-search','{enter}')
                ->pause(30000)

                // Search Result Assertions
                ->waitForLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSeeLink('CIL 2003-116:G-25:X-247C:101')
                ->assertSee('Key')
                ->assertSee('Bone Group')
                ->assertSee('Bone')
                ->assertSee('Side')
                ->assertSee('Sample Number')

                // DNA Assertions
                ->clickLink('CIL 2003-116:G-25:X-247C:101')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-25:X-247C:101')
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
     * A Dusk test to perform a skeletal search by tags and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group orgAdmin_SE_Search
     * @group SearchAccessionOrgAdmin
     * @group AuthorKyle
     */
    public function SearchTagsDNAOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Tags')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-tags',['{ENTER}'])
                ->pause(1000)
                ->assertSee('No data available')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by sample number DNA and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group userDNA_search
     * @group DNA
     * @group SearchSampleNumberDNA
     * @group AuthorKyle
     */
    public function SearchSampleNumberDNA()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Sample Number')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->clear('@cora-search')
                ->type('@cora-search','3617A')
                ->keys('@cora-search','{enter}')
                ->pause(5000)

                // Search Result Assertions
                ->assertSee('DNA search by External Number: 3617A')
                // DNA Assertions
                ->clickLink('CIL 2003-116:G-37:X-236A:901')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-37:X-236A:901')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-37', '@specimen')
                ->assertVue('form.provenance2','X-236A', '@specimen')
                ->assertInputValue('@designator', '901')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-136', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by sample number DNA and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group managerDNA_search
     * @group SearchSampleNumberDNAManager
     * @group AuthorKyle
     */
    public function SearchSampleNumberDNAManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Sample Number')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->clear('@cora-search')
                ->type('@cora-search','3617A')
                ->keys('@cora-search','{enter}')
                ->pause(5000)

                // Search Result Assertions
                ->assertSee('DNA search by External Number: 3617A')
                // DNA Assertions
                ->clickLink('CIL 2003-116:G-37:X-236A:901')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-37:X-236A:901')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-37', '@specimen')
                ->assertVue('form.provenance2','X-236A', '@specimen')
                ->assertInputValue('@designator', '901')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-136', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by sample number DNA and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group orgAdmin_DNA_Search
     * @group SearchSampleNumberDNAOrgAdmin
     * @group AuthorKyle
     */
    public function SearchSampleNumberDNAOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Sample Number')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->clear('@cora-search')
                ->type('@cora-search','3617A')
                ->keys('@cora-search','{enter}')
                ->pause(5000)

                // Search Result Assertions
                ->assertSee('DNA search by External Number: 3617A')
                // DNA Assertions
                ->clickLink('CIL 2003-116:G-37:X-236A:901')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-37:X-236A:901')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-37', '@specimen')
                ->assertVue('form.provenance2','X-236A', '@specimen')
                ->assertInputValue('@designator', '901')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-136', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by mito sequence number DNA and validate the results.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group userDNA_search
     * @group DNA
     * @group SearchMitoSeqNumberDNA
     * @group AuthorKyle
     */
    public function SearchMitoSeqNumberDNA()
    {
        // Test user login
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Mito Seq Number')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->clear('@cora-search')
                ->type('@cora-search','59')
                ->keys('@cora-search','{enter}')
                ->pause(5000)

                // Search Result Assertions
                ->assertSee('DNA search by Mito Sequence Number: 59')
                // DNA Assertions
                ->clickLink('CIL 2003-116:G-37:X-236A:901')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-37:X-236A:901')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-37', '@specimen')
                ->assertVue('form.provenance2','X-236A', '@specimen')
                ->assertInputValue('@designator', '901')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-136', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by mito sequence number DNA and validate the results for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group managerDNA_search
     * @group SearchMitoSeqNumberDNAManager
     * @group AuthorKyle
     */
    public function SearchMitoSeqNumberDNAManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Mito Seq Number')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->clear('@cora-search')
                ->type('@cora-search','59')
                ->keys('@cora-search','{enter}')
                ->pause(5000)

                // Search Result Assertions
                ->assertSee('DNA search by Mito Sequence Number: 59')
                // DNA Assertions
                ->clickLink('CIL 2003-116:G-37:X-236A:901')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-37:X-236A:901')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-37', '@specimen')
                ->assertVue('form.provenance2','X-236A', '@specimen')
                ->assertInputValue('@designator', '901')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-136', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform a skeletal search by mito sequence number DNA and validate the results for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch
     * @group UNO
     * @group orgAdmin_DNA_Search
     * @group SearchMitoSeqNumberDNAOrgAdmin
     * @group AuthorKyle
     */
    public function SearchMitoSeqNumberDNAOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // DNA search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Mito Seq Number')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->clear('@cora-search')
                ->type('@cora-search','59')
                ->keys('@cora-search','{enter}')
                ->pause(5000)

                // Search Result Assertions
                ->assertSee('DNA search by Mito Sequence Number: 59')
                // DNA Assertions
                ->clickLink('CIL 2003-116:G-37:X-236A:901')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser
                ->pause(1000)
                ->assertSee('View Specimen - CIL 2003-116:G-37:X-236A:901')
                ->assertVue('form.accession_number','CIL 2003-116', '@specimen')
                ->assertVue('form.provenance1','G-37', '@specimen')
                ->assertVue('form.provenance2','X-236A', '@specimen')
                ->assertInputValue('@designator', '901')
                ->assertVue('form.sb_id','77','@specimen')
                ->assertVue('form.side', 'Left', '@specimen')
                ->assertVue('form.completeness', 'Complete', '@specimen')
                ->assertVue('form.measured', true, '@specimen')
                ->assertVue('form.dna_sampled', true , '@specimen' )
                ->assertVue('form.isotope_sampled', null, '@specimen')
                ->assertVue('form.inventoried', true, '@specimen')
                ->assertVue('form.inventoried_at', null, '@specimen')
                ->assertVue('form.ct_scanned', null, '@specimen')
                ->assertVue('form.xray_scanned', null, '@specimen')
                ->assertVue('form.individual_number', 'CIL 2003-116-I-136', '@specimen')
                ->assertVue('form.tags', null, '@specimen')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the mtDNA search function in the left side bar
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch15
     * @group UNO
     * @group userDNA_search
     * @group mtDNASearch
     * @group AuthorKyle
     */
    public function mtDNASearch()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome');
//
            // Navigate to the mt DNA Search Menu
            $browser->visit(new specimenPage)
                ->pause(500000)
                ->press('@leftsidebar-expand')
                ->pause(300000)
                ->assertSee('DNA')
                ->clickLink('DNA')
                ->pause(1000)
                ->assertSee('mito DNA Report')

                // Verify the mt DNA search takes the user to the page to create a mt DNA report
                ->pause(60000)
                ->assertSee('mtDNA Report')
                ->assertPathIs('/reports/mtdna')
                ->assertSee('Mito Sequence Number')
                ->assertSee('Mito Sequence Subgroup')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the mtDNA search function in the left side bar for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch1
     * @group UNO
     * @group managerDNA_search
     * @group mtDNASearchManager
     * @group AuthorKyle
     */
    public function mtDNASearchManager()
    {
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // Navigate to the mt DNA Search Menu
            $browser->visit(new specimenPage)
                ->pause(50000)
                ->press('@leftsidebar-expand')
                ->assertSee('DNA')
                ->clickLink('DNA')
                ->pause(1000)
                ->assertSee('mito DNA Report')

                // Verify the mt DNA search takes the user to the page to create a mt DNA report
                ->pause(60000)
                ->assertSee('mtDNA Report')
                ->assertPathIs('/reports/mtdna')
                ->assertSee('Mito Sequence Number')
                ->assertSee('Mito Sequence Subgroup')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the mtDNA search function in the left side bar for and org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch12
     * @group UNO
     * @group orgAdmin_DNA_Search
     * @group mtDNASearchOrgAdmin
     * @group AuthorKyle
     */
    public function mtDNASearchOrgAdmin()
    {
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // Navigate to the mt DNA Search Menu
            $browser->visit(new specimenPage)
                ->pause(50000)
                ->press('@leftsidebar-expand')
                ->assertSee('DNA')
                ->clickLink('DNA')
                ->pause(1000)
                ->assertSee('mito DNA Report')

                // Verify the mt DNA search takes the user to the page to create a mt DNA report
                ->pause(60000)
                ->assertSee('mtDNA Report')
                ->assertPathIs('/reports/mtdna')
                ->assertSee('Mito Sequence Number')
                ->assertSee('Mito Sequence Subgroup')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the mtDNA search function in the left side bar
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch1
     * @group UNO
     * @group userDNA_search
     * @group mtDNASearch
     * @group AuthorKyle
     */
    public function auStrDNASearch()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // Navigate to the mt DNA Search Menu
            $browser->visit(new specimenPage)
                ->pause(50000)
                ->press('@leftsidebar-expand')
                ->assertSee('DNA')
                ->clickLink('DNA')
                ->pause(1000)
                ->assertSee('auStr DNA Report')

                // Verify the mt DNA search takes the user to the page to create a mt DNA report
                ->pause(60000)
                ->assertSee('AuSTR DNA Report')
                ->assertPathIs('/reports/austrdna')
                ->assertSee('AuSTR  Sequence Number')
                ->assertSee('AuSTR  Sequence Subgroup')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the mtDNA search function in the left side bar for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch1
     * @group UNO
     * @group managerDNA_search
     * @group mtDNASearchManager
     * @group AuthorKyle
     */
    public function auStrDNASearchManager()
    {
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // Navigate to the mt DNA Search Menu
            $browser->visit(new specimenPage)
                ->pause(50000)
                ->press('@leftsidebar-expand')
                ->assertSee('DNA')
                ->clickLink('DNA')
                ->pause(1000)
                ->assertSee('auStr DNA Report')

                // Verify the mt DNA search takes the user to the page to create a mt DNA report
                ->pause(60000)
                ->assertSee('AuSTR DNA Report')
                ->assertPathIs('/reports/austrdna')
                ->assertSee('AuSTR  Sequence Number')
                ->assertSee('AuSTR  Sequence Subgroup')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the mtDNA search function in the left side bar for and org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch12
     * @group UNO
     * @group orgAdmin_DNA_Search
     * @group mtDNASearchOrgAdmin
     * @group AuthorKyle
     */
    public function auStrDNASearchOrgAdmin()
    {
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // Navigate to the mt DNA Search Menu
            $browser->visit(new specimenPage)
                ->pause(50000)
                ->press('@leftsidebar-expand')
                ->assertSee('DNA')
                ->clickLink('DNA')
                ->pause(1000)
                ->assertSee('auStr DNA Report')

                // Verify the mt DNA search takes the user to the page to create a mt DNA report
                ->pause(60000)
                ->assertSee('AuSTR DNA Report')
                ->assertPathIs('/reports/austrdna')
                ->assertSee('AuSTR  Sequence Number')
                ->assertSee('AuSTR  Sequence Subgroup')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the mtDNA search function in the left side bar
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch1
     * @group UNO
     * @group userDNA_search
     * @group mtDNASearch
     * @group AuthorKyle
     */
    public function yStrDNASearch()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // Navigate to the mt DNA Search Menu
            $browser->visit(new specimenPage)
                ->pause(50000)
                ->press('@leftsidebar-expand')
                ->assertSee('DNA')
                ->clickLink('DNA')
                ->pause(1000)
                ->assertSee('yStr DNA Report')

                // Verify the mt DNA search takes the user to the page to create a mt DNA report
                ->pause(60000)
                ->assertSee('Y-STR DNA Report')
                ->assertPathIs('/reports/ystrdna')
                ->assertSee('Ystr Sequence Number')
                ->assertSee('Ystr Sequence Subgroup')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the mtDNA search function in the left side bar for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch1
     * @group UNO
     * @group managerDNA_search
     * @group mtDNASearchManager
     * @group AuthorKyle
     */
    public function yStrDNASearchManager()
    {
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // Navigate to the mt DNA Search Menu
            $browser->visit(new specimenPage)
                ->pause(50000)
                ->press('@leftsidebar-expand')
                ->assertSee('DNA')
                ->clickLink('DNA')
                ->pause(1000)
                ->assertSee('yStr DNA Report')

                // Verify the mt DNA search takes the user to the page to create a mt DNA report
                ->pause(60000)
                ->assertSee('Y-STR DNA Report')
                ->assertPathIs('/reports/ystrdna')
                ->assertSee('Ystr Sequence Number')
                ->assertSee('Ystr Sequence Subgroup')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the mtDNA search function in the left side bar for and org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNASearch12
     * @group UNO
     * @group orgAdmin_DNA_Search
     * @group mtDNASearchOrgAdmin
     * @group AuthorKyle
     */
    public function yStrDNASearchOrgAdmin()
    {
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome');

            // Navigate to the mt DNA Search Menu
            $browser->visit(new specimenPage)
                ->pause(50000)
                ->press('@leftsidebar-expand')
                ->assertSee('DNA')
                ->clickLink('DNA')
                ->pause(1000)
                ->assertSee('yStr DNA Report')

                // Verify the mt DNA search takes the user to the page to create a mt DNA report
                ->pause(60000)
                ->assertSee('Y-STR DNA Report')
                ->assertPathIs('/reports/ystrdna')
                ->assertSee('Ystr Sequence Number')
                ->assertSee('Ystr Sequence Subgroup')

                ->logoutUser();
        });
    }
}
