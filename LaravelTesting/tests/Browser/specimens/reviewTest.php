<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;

class reviewTest extends coraBaseTest
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
     * A Dusk test to review General page by Anthro Analyst
     *
     * @return void
     * @throws
     * @test
     * @group reviewGeneral
     * @group reviewAll
     */
    public function reviewGeneral()
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
                ->maximize()

               //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Fibula')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51670')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->assertVue('sb_id',null,'@bone-review')
                ->assertVue('side',null,'@side-review')
                ->assertVue('completeness',null,'@completeness-review')
                ->click('@review-save')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review General page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewGeneralManager
     * @group reviewAll
     */
    public function reviewGeneralManager()
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
                ->maximize()

                //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51670')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->assertVue('sb_id',null,'@bone-review')
                ->assertVue('side',null,'@side-review')
                ->assertVue('completeness',null,'@completeness-review')
                ->click('@review-save')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review General page by Admin
     *
     * @return void
     * @throws
     * @test
     * @group reviewGeneralAdmin
     * @group reviewAll
     */
    public function reviewGeneralAdmin()
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
                ->maximize()

                //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51670')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->assertVue('sb_id',null,'@bone-review')
                ->assertVue('side',null,'@side-review')
                ->assertVue('completeness',null,'@completeness-review')
                ->click('@review-save')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Biological page by Analyst
     *
     * @return void
     * @throws
     * @test
     * @group reviewBiological
     * @group reviewAll
     */
    public function reviewBiological()
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
                ->maximize()

                //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Fibula')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/1023')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/1023/review')
                ->pause(1000)
                ->click('@biological-review')
                ->pause(1000)
                ->assertSee('No methods have been entered')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Biological page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewBiologicalManager
     * @group reviewAll
     */
    public function reviewBiologicalManager()
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
                ->maximize()

                //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Fibula')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/1023')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/1023/review')
                ->pause(1000)
                ->click('@biological-review')
                ->pause(1000)
                ->assertSee('No methods have been entered')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Biological page by org Admin
     *
     * @return void
     * @throws
     * @test
     * @group reviewBiologicalAdmin
     * @group reviewAll
     */
    public function reviewBiologicalAdmin()
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
                ->maximize()

                //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Fibula')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/1023')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/1023/review')
                ->pause(1000)
                ->click('@biological-review')
                ->pause(1000)
                ->assertSee('No methods have been entered')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review DNA page by Anthro
     *
     * @return void
     * @throws
     * @test
     * @group reviewDNA
     * @group reviewAll
     */
    public function reviewDNA()
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
                ->maximize()

                //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/1234')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->assertVue('sample_number',null,'@samplenumber-review')
                ->assertVue('external_case_id',null,'@externalcasenumber-review')
                ->assertVue('lab_id',null,'@lab-review')
                ->click('@lab-review')
                ->click('@resultdate-review')
                ->click('@requestdate-review')
                ->assertSee('Recommended for Resampling?')
                ->pause(1000)
                ->assertSeeIn('@dna-save-review','SAVE REVIEW')


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review DNA page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewDNAManager
     * @group reviewAll
     */
    public function reviewDNAManager()
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
                ->maximize()

                //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/1234')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->assertVue('sample_number',null,'@samplenumber-review')
                ->assertVue('external_case_id',null,'@externalcasenumber-review')
                ->assertVue('lab_id',null,'@lab-review')
                ->click('@lab-review')
                ->click('@resultdate-review')
                ->click('@requestdate-review')
                ->assertSee('Recommended for Resampling?')
                ->pause(1000)
                ->assertSeeIn('@dna-save-review','SAVE REVIEW')


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review DNA page by Admin
     *
     * @return void
     * @throws
     * @test
     * @group reviewDNAAdmin
     * @group reviewAll
     */
    public function reviewDNAAdmin()
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
                ->maximize()

                //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/1234')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->assertVue('sample_number',null,'@samplenumber-review')
                ->assertVue('external_case_id',null,'@externalcasenumber-review')
                ->assertVue('lab_id',null,'@lab-review')
                ->click('@lab-review')
                ->click('@resultdate-review')
                ->click('@requestdate-review')
                ->assertSee('Recommended for Resampling?')
                ->pause(1000)
                ->assertSeeIn('@dna-save-review','SAVE REVIEW')


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Mito DNA page by Analyst
     *
     * @return void
     * @throws
     * @test
     * @group reviewMitoDNA
     * @group reviewAll
     */
    public function reviewMitoDNA()
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
                ->maximize()

                //Mito Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->assertSee('Mito Form')
                ->click('@mito-review')
                ->click('@mitomethod-review')
                ->pause(1000)
                ->click('@mitorequestdate-review')
                ->pause(1000)
                ->click('@mitoreceivedate-review')
                ->pause(1000)
                ->assertSeeIn('@mito-seq-number-review', 'Mito Sequence Number')
                ->click('@mito-result-confidence-review')
                ->assertSee('Results Status')
                ->assertDontSee('Result statusess')
                ->pause(1000)
                ->assertSeeIn('@mito-seq-number-review', 'Mito Sequence Number')
                ->assertDontSeeIn('@mito-seq-number-review', 'Austr Sequence Number')
                ->assertSee('Mito Sequence Subgroup')
                ->assertSee('Base Pairs')
                ->assertSee('Total Count')
                ->assertSee('Match Count')
                ->assertDontSee('match counts')
                ->assertSee('Confirmed Regions')
                ->assertSee('Mito Polymorphisms')
                ->assertSee('Mito Haplosubgroup')
                ->click('@mito-mcc-date-review')
                ->assertSee('Number of Loci')
                ->assertSeeIn('@mito-save-review','SAVE REVIEW')
                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Mito DNA page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewMitoDNAManager
     * @group reviewAll
     */
    public function reviewMitoDNAManager()
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
                ->maximize()

                //Mito Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->assertSee('Mito Form')
                ->click('@mito-review')
                ->click('@mitomethod-review')
                ->pause(1000)
                ->click('@mitorequestdate-review')
                ->pause(1000)
                ->click('@mitoreceivedate-review')
                ->pause(1000)
                ->assertSeeIn('@mito-seq-number-review', 'Mito Sequence Number')
                ->click('@mito-result-confidence-review')
                ->assertSee('Results Status')
                ->assertDontSee('Result statusess')
                ->pause(1000)
                ->assertSeeIn('@mito-seq-number-review', 'Mito Sequence Number')
                ->assertDontSeeIn('@mito-seq-number-review', 'Austr Sequence Number')
                ->assertSee('Mito Sequence Subgroup')
                ->assertSee('Base Pairs')
                ->assertSee('Total Count')
                ->assertSee('Match Count')
                ->assertDontSee('match counts')
                ->assertSee('Confirmed Regions')
                ->assertSee('Mito Polymorphisms')
                ->assertSee('Mito Haplosubgroup')
                ->click('@mito-mcc-date-review')
                ->assertSee('Number of Loci')
                ->assertSeeIn('@mito-save-review','SAVE REVIEW')
                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Mito DNA page by Admin
     *
     * @return void
     * @throws
     * @test
     * @group reviewMitoDNAAdmin
     * @group reviewAll
     */
    public function reviewMitoDNAAdmin()
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
                ->maximize()

                //Mito Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->assertSee('Mito Form')
                ->click('@mito-review')
                ->click('@mitomethod-review')
                ->pause(1000)
                ->click('@mitorequestdate-review')
                ->pause(1000)
                ->click('@mitoreceivedate-review')
                ->pause(1000)
                ->assertSeeIn('@mito-seq-number-review', 'Mito Sequence Number')
                ->click('@mito-result-confidence-review')
                ->assertSee('Results Status')
                ->assertDontSee('Result statusess')
                ->pause(1000)
                ->assertSeeIn('@mito-seq-number-review', 'Mito Sequence Number')
                ->assertDontSeeIn('@mito-seq-number-review', 'Austr Sequence Number')
                ->assertSee('Mito Sequence Subgroup')
                ->assertSee('Base Pairs')
                ->assertSee('Total Count')
                ->assertSee('Match Count')
                ->assertDontSee('match counts')
                ->assertSee('Confirmed Regions')
                ->assertSee('Mito Polymorphisms')
                ->assertSee('Mito Haplosubgroup')
                ->click('@mito-mcc-date-review')
                ->assertSee('Number of Loci')
                ->assertSeeIn('@mito-save-review','SAVE REVIEW')
                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Austr DNA page
     *
     * @return void
     * @throws
     * @test
     * @group reviewAustrDNA
     * @group reviewAll
     */
    public function reviewAustrDNA()
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
                ->maximize()

                //Mito Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->click('@austr-review')
                ->assertSee('au-STR Form')
                ->click('@austrmethod-review')
                ->pause(1000)
                ->click('@austrrequestdate-review')
                ->pause(1000)
                ->click('@austrreceivedate-review')
                ->click('@austr-result-confidence-review')
                ->assertSee('Results Status')
                ->assertDontSee('Result statusess')
                ->pause(1000)

                ->assertSee('auSTR Sequence Subgroup')
                //Negative testing
                ->assertDontSee('Base Pairs')
                ->assertDontSee('Total Count')
                ->assertDontSee('Match Count')
                ->assertDontSee('Confirmed Regions')
                ->click('@austr-mcc-date-review')
                ->assertSee('Number of Loci')
                ->assertSeeIn('@austr-save-review','SAVE REVIEW')
                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Austr DNA page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewAustrDNAManager
     * @group reviewAll
     */
    public function reviewAustrDNAManager()
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
                ->maximize()

                //Mito Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->click('@austr-review')
                ->assertSee('au-STR Form')
                ->click('@austrmethod-review')
                ->pause(1000)
                ->click('@austrrequestdate-review')
                ->pause(1000)
                ->click('@austrreceivedate-review')
                ->click('@austr-result-confidence-review')
                ->assertSee('Results Status')
                ->assertDontSee('Result statusess')
                ->pause(1000)

                ->assertSee('auSTR Sequence Subgroup')
                //Negative testing
                ->assertDontSee('Base Pairs')
                ->assertDontSee('Total Count')
                ->assertDontSee('Match Count')
                ->assertDontSee('Confirmed Regions')
                ->click('@austr-mcc-date-review')
                ->assertSee('Number of Loci')
                ->assertSeeIn('@austr-save-review','SAVE REVIEW')
                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Austr DNA page by Admin
     *
     * @return void
     * @throws
     * @test
     * @group reviewAustrDNAAdmin
     * @group reviewAll
     */
    public function reviewAustrDNAAdmin()
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
                ->maximize()

                //Mito Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->click('@austr-review')
                ->assertSee('au-STR Form')
                ->click('@austrmethod-review')
                ->pause(1000)
                ->click('@austrrequestdate-review')
                ->pause(1000)
                ->click('@austrreceivedate-review')
                ->click('@austr-result-confidence-review')
                ->assertSee('Results Status')
                ->assertDontSee('Result statusess')
                ->pause(1000)

                ->assertSee('auSTR Sequence Subgroup')
                //Negative testing
                ->assertDontSee('Base Pairs')
                ->assertDontSee('Total Count')
                ->assertDontSee('Match Count')
                ->assertDontSee('Confirmed Regions')
                ->click('@austr-mcc-date-review')
                ->assertSee('Number of Loci')
                ->assertSeeIn('@austr-save-review','SAVE REVIEW')
                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Ystr DNA page by Anthro
     *
     * @return void
     * @throws
     * @test
     * @group reviewYstrDNA
     * @group reviewAll
     */
    public function reviewYstrDNA()
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
                ->maximize()

                //Mito Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->click('@ystr-review')
                ->assertSee('Y-STR Form')
                ->click('@ystrmethod-review')
                ->pause(1000)
                ->click('@ystrrequestdate-review')
                ->pause(1000)
                ->click('@ystrreceivedate-review')
                ->click('@ystr-result-confidence-review')
                ->assertSee('Results Status')
                ->assertDontSee('Result statusess')
                ->pause(1000)

                ->assertSee('YSTR Sequence Similar')
                //Negative testing
                ->assertDontSee('Base Pairs')
                ->assertDontSee('Total Count')
                ->assertDontSee('Match Count')
                ->assertDontSee('Confirmed Regions')
                ->assertSee('Number of Loci')
                ->assertSee('Population Frequency')
                ->assertSee('Count')
                ->click('@ystr-haplosubgroup-review')
                ->click('@ystr-mcc-date-review')
                ->assertSeeIn('@ystr-save-review','SAVE REVIEW')
                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Ystr DNA page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewYstrDNAManager
     * @group reviewAll
     */
    public function reviewYstrDNAManager()
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
                ->maximize()

                //Mito Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->click('@ystr-review')
                ->assertSee('Y-STR Form')
                ->click('@ystrmethod-review')
                ->pause(1000)
                ->click('@ystrrequestdate-review')
                ->pause(1000)
                ->click('@ystrreceivedate-review')
                ->click('@ystr-result-confidence-review')
                ->assertSee('Results Status')
                ->assertDontSee('Result statusess')
                ->pause(1000)

                ->assertSee('YSTR Sequence Similar')
                //Negative testing
                ->assertDontSee('Base Pairs')
                ->assertDontSee('Total Count')
                ->assertDontSee('Match Count')
                ->assertDontSee('Confirmed Regions')
                ->assertSee('Number of Loci')
                ->assertSee('Population Frequency')
                ->assertSee('Count')
                ->click('@ystr-haplosubgroup-review')
                ->click('@ystr-mcc-date-review')
                ->assertSeeIn('@ystr-save-review','SAVE REVIEW')
                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Ystr DNA page by Admin
     *
     * @return void
     * @throws
     * @test
     * @group reviewYstrDNAAdmin
     * @group reviewAll
     */
    public function reviewYstrDNAAdmin()
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
                ->maximize()

                //Mito Review page
                ->visit('/skeletalelements/1234/review')
                ->pause(1000)
                ->click('@dna-review')
                ->pause(1000)
                ->assertSee('22A')
                ->click('@dna-expansion')
                ->pause(1000)
                ->click('@ystr-review')
                ->assertSee('Y-STR Form')
                ->click('@ystrmethod-review')
                ->pause(1000)
                ->click('@ystrrequestdate-review')
                ->pause(1000)
                ->click('@ystrreceivedate-review')
                ->click('@ystr-result-confidence-review')
                ->assertSee('Results Status')
                ->assertDontSee('Result statusess')
                ->pause(1000)

                ->assertSee('YSTR Sequence Similar')
                //Negative testing
                ->assertDontSee('Base Pairs')
                ->assertDontSee('Total Count')
                ->assertDontSee('Match Count')
                ->assertDontSee('Confirmed Regions')
                ->assertSee('Number of Loci')
                ->assertSee('Population Frequency')
                ->assertSee('Count')
                ->click('@ystr-haplosubgroup-review')
                ->click('@ystr-mcc-date-review')
                ->assertSeeIn('@ystr-save-review','SAVE REVIEW')
                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Taphonomy page by Analyst
     *
     * @return void
     * @throws
     * @test
     * @group reviewTaphonomy
     * @group reviewAll
     */
    public function reviewTaphonomy()
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
                ->maximize()

                //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Fibula')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/1023')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/1023/review')
                ->pause(2000)
                ->click('@taphonomy-step')
                ->pause(1000)
                ->click('@taphonomy-menu')
                ->pause(1000)
                ->assertSee('You can apply multiple taphonomies to this specimen')
                ->pause(1000)
                //save button
                ->click('@taphonomy-review-save')
                ->pause(1000)
                //accept button
                ->click('@taphonomy-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Taphonomy page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewTaphonomyManager
     * @group reviewAll
     */
    public function reviewTaphonomyManager()
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
                ->maximize()

                //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Fibula')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/1023')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/1023/review')
                ->pause(2000)
                ->click('@taphonomy-step')
                ->pause(1000)
                ->click('@taphonomy-menu')
                ->pause(1000)
                ->assertSee('You can apply multiple taphonomies to this specimen')
                ->pause(1000)
                //save button
                ->click('@taphonomy-review-save')
                ->pause(1000)
                //accept button
                ->click('@taphonomy-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Taphonomy page by Admin
     *
     * @return void
     * @throws
     * @test
     * @group reviewTaphonomyAdmin
     * @group reviewAll
     */
    public function reviewTaphonomyAdmin()
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
                ->maximize()

                //Search for bone Fibula
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Fibula')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/1023')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/1023/review')
                ->pause(2000)
                ->click('@taphonomy-step')
                ->pause(1000)
                ->click('@taphonomy-menu')
                ->pause(1000)
                ->assertSee('You can apply multiple taphonomies to this specimen')
                ->pause(1000)
                //save button
                ->click('@taphonomy-review-save')
                ->pause(1000)
                //accept button
                ->click('@taphonomy-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }



    /**
     * A Dusk test to review Zones page
     *
     * @return void
     * @throws
     * @test
     * @group reviewZones
     * @group reviewAll
     */
    public function reviewZones()
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
                ->maximize()

                //Search for bone Humerus
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51670')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@zones-step')
                ->pause(1000)
                ->assertSee('2 - Caput')
                //check switch
                ->click('@2-caputswitch')
                ->pause(1000)
                //save button
                ->click('@zones-review-save')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Zones page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewZonesManager
     * @group reviewAll
     */
    public function reviewZonesManager()
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
                ->maximize()

                //Search for bone Humerus
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51670')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@zones-step')
                ->pause(1000)
                ->assertSee('2 - Caput')
                //check switch
                ->click('@2-caputswitch')
                ->pause(1000)
                //save button
                ->click('@zones-review-save')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Measurements page by Analyst
     *
     * @return void
     * @throws
     * @test
     * @group reviewMeasurements
     * @group reviewAll
     */
    public function reviewMeasurements()
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
                ->maximize()

                //Search for bone Humerus
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51670')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@measurements-step')
                ->pause(1000)
                ->assertSee('Hum_01 Maximum Length')
                ->click('@measurements-review')
                ->type('@measurements-review','1')

                //save button
                ->click('@measurements-review-save')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Measurements page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewMeasurementsManager
     * @group reviewAll
     */
    public function reviewMeasurementsManager()
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
                ->maximize()

                //Search for bone Humerus
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51670')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@measurements-step')
                ->pause(1000)
                ->assertSee('Hum_01 Maximum Length')
                ->click('@measurements-review')
                ->type('@measurements-review','1')

                //save button
                ->click('@measurements-review-save')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Articulations page
     *
     * @return void
     * @throws
     * @test
     * @group reviewArticulations
     * @group reviewAll
     */
    public function reviewArticulations()
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
                ->maximize()

                //Search for bone Humerus
               ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51670')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@associations-step')
                ->pause(1000)

                //Articulations
                ->assertSee('Articulations')
                ->click('@articulations-panel')
                ->pause(1000)
                ->click('@articulations-menu')
                ->pause(1000)
                ->assertSee('You can apply multiple articulations to this specimen')
                ->pause(1000)
                //save button
                ->click('@association-review-save')
                ->pause(1000)
                //accept button
                ->click('@association-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Articulations page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewArticulationsManager
     * @group reviewAll
     */
    public function reviewArticulationsManager()
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
                ->maximize()

                //Search for bone Humerus
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51670')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@associations-step')
                ->pause(1000)

                //Articulations
                ->assertSee('Articulations')
                ->click('@articulations-panel')
                ->pause(1000)
                ->click('@articulations-menu')
                ->pause(1000)
                ->assertSee('You can apply multiple articulations to this specimen')
                ->pause(1000)
                //save button
                ->click('@association-review-save')
                ->pause(1000)
                //accept button
                ->click('@association-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Pair Matching page
     *
     * @return void
     * @throws
     * @test
     * @group reviewPairMatching
     * @group reviewAll
     */
    public function reviewPairMatching()
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
                ->maximize()

                //Search for bone Humerus
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51670')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@associations-step')
                ->pause(1000)

                //Pair Matching

                ->click('@pairmatching-panel')
                ->pause(1000)
                ->assertSee('Pair Matching')
                ->click('@pairmatching-menu')
                ->pause(1000)
                ->assertSee('You can apply multiple pairs to this specimen')
                ->pause(1000)
                //save button
                ->click('@association-review-save')
                ->pause(1000)
                //accept button
                ->click('@association-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Pair Matching page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewPairMatchingManager
     * @group reviewAll
     */
    public function reviewPairMatchingManager()
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
                ->maximize()

                //Search for bone Humerus
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Humerus')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51670')
                ->pause(2000)
                //click action button
                ->click ('@actions-button')
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@associations-step')
                ->pause(1000)

                //Pair Matching

                ->click('@pairmatching-panel')
                ->pause(1000)
                ->assertSee('Pair Matching')
                ->click('@pairmatching-menu')
                ->pause(1000)
                ->assertSee('You can apply multiple pairs to this specimen')
                ->pause(1000)
                //save button
                ->click('@association-review-save')
                ->pause(1000)
                //accept button
                ->click('@association-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Refits page
     *
     * @return void
     * @throws
     * @test
     * @group reviewRefits
     * @group reviewAll
     */
    public function reviewRefits()
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
                ->maximize()

                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@associations-step')
                ->pause(1000)

                //Refits

                ->click('@refits-panel')
                ->pause(1000)
                ->assertSee('Refits')
                ->click('@refits-menu')
                ->pause(1000)
                ->assertSee('You can apply multiple refits to this specimen')
                ->pause(1000)
                //save button
                ->click('@association-review-save')
                ->pause(1000)
                //accept button
                ->click('@association-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Refits page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewRefitsManager
     * @group reviewAll
     */
    public function reviewRefitsManager()
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
                ->maximize()

                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@associations-step')
                ->pause(1000)

                //Refits

                ->click('@refits-panel')
                ->pause(1000)
                ->assertSee('Refits')
                ->click('@refits-menu')
                ->pause(1000)
                ->assertSee('You can apply multiple refits to this specimen')
                ->pause(1000)
                //save button
                ->click('@association-review-save')
                ->pause(1000)
                //accept button
                ->click('@association-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Trauma page by Analyst
     *
     * @return void
     * @throws
     * @test
     * @group reviewTrauma
     * @group reviewAll
     */
    public function reviewTrauma()
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
                ->maximize()

                //Review page
                ->visit('/skeletalelements/6455/review')
                ->pause(2000)
                ->click('@pathology-review')
                ->pause(1000)

                //Trauma
                ->click('@trauma-panel')
                ->pause(1000)
                ->assertSee('Trauma')
                ->pause(2000)
                ->click('@trauma-selection')
                ->pause(1000)
                ->click('@trauma-zone-review')
                ->pause(1000)
                ->click('@trauma-state-review')
                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Trauma page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewTraumaManager
     * @group reviewAll
     */
    public function reviewTraumaManager()
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
                ->maximize()

                //Review page
                ->visit('/skeletalelements/6455/review')
                ->pause(2000)
                ->click('@pathology-review')
                ->pause(1000)

                //Trauma
                ->click('@trauma-panel')
                ->pause(1000)
                ->assertSee('Trauma')
                ->pause(2000)
                ->click('@trauma-selection')
                ->pause(1000)
                ->click('@trauma-zone-review')
                ->pause(1000)
                ->click('@trauma-state-review')
                ->pause(1000)


                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Anomaly page
     *
     * @return void
     * @throws
     * @test
     * @group reviewAnomaly
     * @group reviewAll
     */
    public function reviewAnomaly()
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
                ->maximize()

                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@pathology-review')
                ->pause(1000)

                //Anomaly

                ->click('@anomaly-panel')
                ->pause(1000)
                ->assertSee('Anomaly')
                ->click('@anomaly-menu')
                ->pause(1000)
                ->assertSee('Please can apply multiple anomalys to this specimen')
                ->pause(1000)
                //save button
                ->click('@anomaly-review-save')
                ->pause(1000)
                //accept button
                ->click('@anomaly-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Anomaly page by Manager
     *
     * @return void
     * @throws
     * @test
     * @group reviewAnomalyManager
     * @group reviewAll
     */
    public function reviewAnomalyManager()
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
                ->maximize()

                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@pathology-review')
                ->pause(1000)

                //Anomaly

                ->click('@anomaly-panel')
                ->pause(1000)
                ->assertSee('Anomaly')
                ->click('@anomaly-menu')
                ->pause(1000)
                ->assertSee('Please can apply multiple anomalys to this specimen')
                ->pause(1000)
                //save button
                ->click('@anomaly-review-save')
                ->pause(1000)
                //accept button
                ->click('@anomaly-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to review Anomaly page by Admin
     *
     * @return void
     * @throws
     * @test
     * @group reviewAnomalyAdmin
     * @group reviewAll
     */
    public function reviewAnomalyAdmin()
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
                ->maximize()

                //Review page
                ->visit('/skeletalelements/51670/review')
                ->pause(2000)
                ->click('@pathology-review')
                ->pause(1000)

                //Anomaly

                ->click('@anomaly-panel')
                ->pause(1000)
                ->assertSee('Anomaly')
                ->click('@anomaly-menu')
                ->pause(1000)
                ->assertSee('Please can apply multiple anomalys to this specimen')
                ->pause(1000)
                //save button
                ->click('@anomaly-review-save')
                ->pause(1000)
                //accept button
                ->click('@anomaly-review-accept')
                ->pause(1000)

                ->logoutUser();
        });
    }


}
