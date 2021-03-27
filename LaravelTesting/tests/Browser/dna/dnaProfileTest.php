<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use App\User;

// 3 Total Test Cases
class dnaProfileTest extends DuskTestCase
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
     * A Dusk test to verify a successful edit of DNA due to attribute rules
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditDNA
     * @group AuthorKyle
     */
    public function EditDNA()
    {
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Verify lab id can be null
                ->select('@dna-lab','{enter}')
                //->clear('@dna-lab')

                // Verify external case number can be null
                ->select('@external-case-number','{enter}')
                ->clear('@external-case-number')

                // Verify sample number can't be null
                ->type('@sample-number','00B')
                //->clear('@sample-number')

                // Verify received date can be null
                ->keys('@dna-mito-receive-date','{backspace}','{backspace}','{tab}','{backspace}','{backspace}','{tab}','{backspace}','{backspace}','{backspace}','{backspace}')

                // Verify result confidence can be null
                ->select('@dna-results-confidence','{enter}')

                // Verify mito sequence similar can be nulls
                ->select('@dna-mito-sequence-similar','{enter}')
                ->clear('@dna-mito-sequence-similar')

                // Verify mito match count can be null
                ->select('@dna-mito-match-count','{enter}')
                ->clear('@dna-mito-match-count')

                // Verify mito total count can be null
                ->select('@dna-mito-total-count','{enter}')
                ->clear('@dna-mito-total-count')

                // Verify dna haplogroup can be null
                ->select('@dna-mito-haplogroup','{enter}')

                // Press Save and verify the first round of edits
                ->click('@dna-save')
                ->pause(1000)
                ->assertSee('DNA Profile successfully updated')
                ->assertPathIs('/dnas/387')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Verify lab id can be selected
                ->select('@dna-lab','1')

                // Verify external case number can be alpha numeric
                ->type('@external-case-number', 'ABC123')

                // Verify sample number can be alpha numeric
                ->type('@sample-number', 'ABC123')

                // Verify received date can be a date
                ->select('@dna-mito-receive-date','01012000')

                // Verify result confidence can be null
                ->select('@dna-results-confidence','Reportable')

                // Verify mito sequence number can numeric
                ->type('@dna-mito-sequence-number', '123456')

                // Verify mito sequence subgroup can be alpha numeric
                ->type('@dna-mito-sequence-subgroup', 'ABC123')

                // Verify mito sequence similar can be alpha numeric with dashes or spaces
                ->type('@dna-mito-sequence-similar', 'A BC-123')

                // Verify mito match count can be only numeric
                ->type('@dna-mito-match-count', '123456')

                // Verify mito total count can be only numeric
                ->type('@dna-mito-total-count', '123456')

                // Verify mito total count can be only numeric
                ->type('@dna-mito-total-count', '123456')

                // Verify dna haplogroup can be selected
                ->select('@dna-mito-haplogroup','1')

                // Press Save and verify the second round of edits
                ->click('@dna-save')
                ->pause(1000)
                ->assertSee('DNA Profile successfully updated')
                ->assertPathIs('/dnas/387')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify a successful edit of DNA due to attribute rules for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditDNAManager
     * @group AuthorKyle
     */
    public function EditDNAManager()
    {
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Verify lab id can be null
                ->select('@dna-lab','{enter}')
                //->clear('@dna-lab')

                // Verify external case number can be null
                ->select('@external-case-number','{enter}')
                ->clear('@external-case-number')

                // Verify sample number can't be null
                ->type('@sample-number','00B')
                //->clear('@sample-number')

                // Verify received date can be null
                ->keys('@dna-mito-receive-date','{backspace}','{backspace}','{tab}','{backspace}','{backspace}','{tab}','{backspace}','{backspace}','{backspace}','{backspace}')

                // Verify result confidence can be null
                ->select('@dna-results-confidence','{enter}')

                // Verify mito sequence similar can be nulls
                ->select('@dna-mito-sequence-similar','{enter}')
                ->clear('@dna-mito-sequence-similar')

                // Verify mito match count can be null
                ->select('@dna-mito-match-count','{enter}')
                ->clear('@dna-mito-match-count')

                // Verify mito total count can be null
                ->select('@dna-mito-total-count','{enter}')
                ->clear('@dna-mito-total-count')

                // Verify dna haplogroup can be null
                ->select('@dna-mito-haplogroup','{enter}')

                // Press Save and verify the first round of edits
                ->click('@dna-save')
                ->pause(1000)
                ->assertSee('DNA Profile successfully updated')
                ->assertPathIs('/dnas/387')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Verify lab id can be selected
                ->select('@dna-lab','1')

                // Verify external case number can be alpha numeric
                ->type('@external-case-number', 'ABC123')

                // Verify sample number can be alpha numeric
                ->type('@sample-number', 'ABC123')

                // Verify received date can be a date
                ->select('@dna-mito-receive-date','01012000')

                // Verify result confidence can be null
                ->select('@dna-results-confidence','Reportable')

                // Verify mito sequence number can numeric
                ->type('@dna-mito-sequence-number', '123456')

                // Verify mito sequence subgroup can be alpha numeric
                ->type('@dna-mito-sequence-subgroup', 'ABC123')

                // Verify mito sequence similar can be alpha numeric with dashes or spaces
                ->type('@dna-mito-sequence-similar', 'A BC-123')

                // Verify mito match count can be only numeric
                ->type('@dna-mito-match-count', '123456')

                // Verify mito total count can be only numeric
                ->type('@dna-mito-total-count', '123456')

                // Verify mito total count can be only numeric
                ->type('@dna-mito-total-count', '123456')

                // Verify dna haplogroup can be selected
                ->select('@dna-mito-haplogroup','1')

                // Press Save and verify the second round of edits
                ->click('@dna-save')
                ->pause(1000)
                ->assertSee('DNA Profile successfully updated')
                ->assertPathIs('/dnas/387')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify a successful edit of DNA due to attribute rules for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditDNAOrgAdmin
     * @group AuthorKyle
     */
    public function EditDNAOrgAdmin()
    {
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Verify lab id can be null
                ->select('@dna-lab','{enter}')
                //->clear('@dna-lab')

                // Verify external case number can be null
                ->select('@external-case-number','{enter}')
                ->clear('@external-case-number')

                // Verify sample number can't be null
                ->type('@sample-number','00B')
                //->clear('@sample-number')

                // Verify received date can be null
                ->keys('@dna-mito-receive-date','{backspace}','{backspace}','{tab}','{backspace}','{backspace}','{tab}','{backspace}','{backspace}','{backspace}','{backspace}')

                // Verify result confidence can be null
                ->select('@dna-results-confidence','{enter}')

                // Verify mito sequence similar can be nulls
                ->select('@dna-mito-sequence-similar','{enter}')
                ->clear('@dna-mito-sequence-similar')

                // Verify mito match count can be null
                ->select('@dna-mito-match-count','{enter}')
                ->clear('@dna-mito-match-count')

                // Verify mito total count can be null
                ->select('@dna-mito-total-count','{enter}')
                ->clear('@dna-mito-total-count')

                // Verify dna haplogroup can be null
                ->select('@dna-mito-haplogroup','{enter}')

                // Press Save and verify the first round of edits
                ->click('@dna-save')
                ->pause(1000)
                ->assertSee('DNA Profile successfully updated')
                ->assertPathIs('/dnas/387')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Verify lab id can be selected
                ->select('@dna-lab','1')

                // Verify external case number can be alpha numeric
                ->type('@external-case-number', 'ABC123')

                // Verify sample number can be alpha numeric
                ->type('@sample-number', 'ABC123')

                // Verify received date can be a date
                ->select('@dna-mito-receive-date','01012000')

                // Verify result confidence can be null
                ->select('@dna-results-confidence','Reportable')

                // Verify mito sequence number can numeric
                ->type('@dna-mito-sequence-number', '123456')

                // Verify mito sequence subgroup can be alpha numeric
                ->type('@dna-mito-sequence-subgroup', 'ABC123')

                // Verify mito sequence similar can be alpha numeric with dashes or spaces
                ->type('@dna-mito-sequence-similar', 'A BC-123')

                // Verify mito match count can be only numeric
                ->type('@dna-mito-match-count', '123456')

                // Verify mito total count can be only numeric
                ->type('@dna-mito-total-count', '123456')

                // Verify mito total count can be only numeric
                ->type('@dna-mito-total-count', '123456')

                // Verify dna haplogroup can be selected
                ->select('@dna-mito-haplogroup','1')

                // Press Save and verify the second round of edits
                ->click('@dna-save')
                ->pause(1000)
                ->assertSee('DNA Profile successfully updated')
                ->assertPathIs('/dnas/387')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify a failed edit of DNA due to attribute rules
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditFailDNA
     * @group AuthorKyle
     */
    public function EditFailDNA()
    {
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Purposely incorrect entry of external case #, can be null and only alpha numeric
                ->type('@external-case-number', '##')
                ->keys('@external-case-number','{enter}')
                ->assertSee('The external case id may only contain letters and numbers.')

                // Purposely incorrect entry of DNA sample #, can be null and only alpha numeric
                ->type('@sample-number', '##')
                ->keys('@sample-number','{enter}')
                ->assertSee('The sample number may only contain letters and numbers.')

                // Purposely incorrect entry of Mito sequence number, can be null and only numeric
                ->type('@dna-mito-sequence-number', 'Ab')
                ->keys('@dna-mito-sequence-number','{enter}')
                ->assertSee('The mito sequence number must be a number.')

                // Purposely incorrect entry of Mito sequence sub group, can be null and only alpha numeric
                ->type('@dna-mito-sequence-subgroup', '##')
                ->keys('@dna-mito-sequence-subgroup','{enter}')
                ->assertSee('The mito sequence subgroup may only contain letters, numbers, dashes and spaces.')

                // Purposely incorrect entry of Mito sequence similar, can be null and only alpha numeric with dashes or spaces
                ->type('@dna-mito-sequence-similar', '##')
                ->keys('@dna-mito-sequence-similar','{enter}')
                ->assertSee('The mito sequence similar may only contain letters, numbers, dashes and spaces.')

                // Purposely incorrect entry of Mito match count, can be null and only numeric
                ->type('@dna-mito-match-count', 'Ab')
                ->keys('@dna-mito-match-count','{enter}')
                ->assertSee('The mito match count must be a number.')

                // Purposely incorrect entry of Mito total count, can be null and only numeric
                ->type('@dna-mito-total-count', 'Ab')
                ->keys('@dna-mito-total-count','{enter}')
                ->assertSee('The mito total count must be a number.')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify a failed edit of DNA due to attribute rules for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditFailDNAManager
     * @group AuthorKyle
     */
    public function EditFailDNAManager()
    {
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Purposely incorrect entry of external case #, can be null and only alpha numeric
                ->type('@external-case-number', '##')
                ->keys('@external-case-number','{enter}')
                ->assertSee('The external case id may only contain letters and numbers.')

                // Purposely incorrect entry of DNA sample #, can be null and only alpha numeric
                ->type('@sample-number', '##')
                ->keys('@sample-number','{enter}')
                ->assertSee('The sample number may only contain letters and numbers.')

                // Purposely incorrect entry of Mito sequence number, can be null and only numeric
                ->type('@dna-mito-sequence-number', 'Ab')
                ->keys('@dna-mito-sequence-number','{enter}')
                ->assertSee('The mito sequence number must be a number.')

                // Purposely incorrect entry of Mito sequence sub group, can be null and only alpha numeric
                ->type('@dna-mito-sequence-subgroup', '##')
                ->keys('@dna-mito-sequence-subgroup','{enter}')
                ->assertSee('The mito sequence subgroup may only contain letters, numbers, dashes and spaces.')

                // Purposely incorrect entry of Mito sequence similar, can be null and only alpha numeric with dashes or spaces
                ->type('@dna-mito-sequence-similar', '##')
                ->keys('@dna-mito-sequence-similar','{enter}')
                ->assertSee('The mito sequence similar may only contain letters, numbers, dashes and spaces.')

                // Purposely incorrect entry of Mito match count, can be null and only numeric
                ->type('@dna-mito-match-count', 'Ab')
                ->keys('@dna-mito-match-count','{enter}')
                ->assertSee('The mito match count must be a number.')

                // Purposely incorrect entry of Mito total count, can be null and only numeric
                ->type('@dna-mito-total-count', 'Ab')
                ->keys('@dna-mito-total-count','{enter}')
                ->assertSee('The mito total count must be a number.')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify a failed edit of DNA due to attribute rules for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditFailDNAOrgAdmin
     * @group AuthorKyle
     */
    public function EditFailDNAOrgAdmin()
    {
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Purposely incorrect entry of external case #, can be null and only alpha numeric
                ->type('@external-case-number', '##')
                ->keys('@external-case-number','{enter}')
                ->assertSee('The external case id may only contain letters and numbers.')

                // Purposely incorrect entry of DNA sample #, can be null and only alpha numeric
                ->type('@sample-number', '##')
                ->keys('@sample-number','{enter}')
                ->assertSee('The sample number may only contain letters and numbers.')

                // Purposely incorrect entry of Mito sequence number, can be null and only numeric
                ->type('@dna-mito-sequence-number', 'Ab')
                ->keys('@dna-mito-sequence-number','{enter}')
                ->assertSee('The mito sequence number must be a number.')

                // Purposely incorrect entry of Mito sequence sub group, can be null and only alpha numeric
                ->type('@dna-mito-sequence-subgroup', '##')
                ->keys('@dna-mito-sequence-subgroup','{enter}')
                ->assertSee('The mito sequence subgroup may only contain letters, numbers, dashes and spaces.')

                // Purposely incorrect entry of Mito sequence similar, can be null and only alpha numeric with dashes or spaces
                ->type('@dna-mito-sequence-similar', '##')
                ->keys('@dna-mito-sequence-similar','{enter}')
                ->assertSee('The mito sequence similar may only contain letters, numbers, dashes and spaces.')

                // Purposely incorrect entry of Mito match count, can be null and only numeric
                ->type('@dna-mito-match-count', 'Ab')
                ->keys('@dna-mito-match-count','{enter}')
                ->assertSee('The mito match count must be a number.')

                // Purposely incorrect entry of Mito total count, can be null and only numeric
                ->type('@dna-mito-total-count', 'Ab')
                ->keys('@dna-mito-total-count','{enter}')
                ->assertSee('The mito total count must be a number.')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify a creation of an additional DNA test
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group CreateAdditionalTestDNA
     * @group AuthorKyle
     */
    public function CreateAdditionalTestDNA()
    {
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Create an additional DNA test
                ->click('@dna-additional-test-create')
                ->assertPathIs('/skeletalelements/1221/dnaAnalysis/create')

                // Edit the additional test fields
                ->select('@dna-analysistest_type','7')
                ->select('@dna-region-request-date','01012000')
                ->select('@dna-region-results','TEST CREATE')
                ->select('@dna-region-receive-date','01012000')

                // Save the new additional test
                ->click('@dna-analysis-save')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify a creation of an additional DNA test for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group CreateAdditionalTestDNAManager
     * @group AuthorKyle
     */
    public function CreateAdditionalTestDNAManager()
    {
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Create an additional DNA test
                ->click('@dna-additional-test-create')
                ->assertPathIs('/skeletalelements/1221/dnaAnalysis/create')

                // Edit the additional test fields
                ->select('@dna-analysistest_type','7')
                ->select('@dna-region-request-date','01012000')
                ->select('@dna-region-results','TEST CREATE')
                ->select('@dna-region-receive-date','01012000')

                // Save the new additional test
                ->click('@dna-analysis-save')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify a creation of an additional DNA test for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group CreateAdditionalTestDNAOrgAdmin
     * @group AuthorKyle
     */
    public function CreateAdditionalTestDNAOrgAdmin()
    {
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Create an additional DNA test
                ->click('@dna-additional-test-create')
                ->assertPathIs('/skeletalelements/1221/dnaAnalysis/create')

                // Edit the additional test fields
                ->select('@dna-analysistest_type','7')
                ->select('@dna-region-request-date','01012000')
                ->select('@dna-region-results','TEST CREATE')
                ->select('@dna-region-receive-date','01012000')

                // Save the new additional test
                ->click('@dna-analysis-save')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an additional DNA test
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditAdditionalTestDNA
     * @group AuthorKyle
     */
    public function EditAdditionalTestDNA()
    {
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Select the first additional DNA test to edit
                ->click('#collapseDNAAnalysis > div > div > table > tbody > tr > td:nth-child(1) > div > a')
                ->click('@dna-analysis-action-menu')
                ->click('@dna-analysis-edit-menu')

                // Edit the additional test fields
                ->select('@dna-analysistest_type','7')
                ->select('@dna-region-request-date','02022001')
                ->select('@dna-region-results','TEST EDIT')
                ->select('@dna-region-receive-date','02022001')

                // Save the new additional test
                ->click('@dna-analysis-save')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an additional DNA test for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditAdditionalTestDNAManager
     * @group AuthorKyle
     */
    public function EditAdditionalTestDNAManager()
    {
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Select the first additional DNA test to edit
                ->click('#collapseDNAAnalysis > div > div > table > tbody > tr > td:nth-child(1) > div > a')
                ->click('@dna-analysis-action-menu')
                ->click('@dna-analysis-edit-menu')

                // Edit the additional test fields
                ->select('@dna-analysistest_type','7')
                ->select('@dna-region-request-date','02022001')
                ->select('@dna-region-results','TEST EDIT')
                ->select('@dna-region-receive-date','02022001')

                // Save the new additional test
                ->click('@dna-analysis-save')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit an additional DNA test for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditAdditionalTestDNAOrgAdmin
     * @group AuthorKyle
     */
    public function EditAdditionalTestDNAOrgAdmin()
    {
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Select the first additional DNA test to edit
                ->click('#collapseDNAAnalysis > div > div > table > tbody > tr > td:nth-child(1) > div > a')
                ->click('@dna-analysis-action-menu')
                ->click('@dna-analysis-edit-menu')

                // Edit the additional test fields
                ->select('@dna-analysistest_type','7')
                ->select('@dna-region-request-date','02022001')
                ->select('@dna-region-results','TEST EDIT')
                ->select('@dna-region-receive-date','02022001')

                // Save the new additional test
                ->click('@dna-analysis-save')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an additional DNA test
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group DeleteAdditionalTestDNA
     * @group AuthorKyle
     */
    public function DeleteAdditionalTestDNA()
    {
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Delete the first additional test for DNA
                ->assertVisible('#form-delete-dnaanalysis-15 > a > i')
                ->pause(1000)
                //->assertSee('Additional DNA test successfully deleted!')
                ->assertPathIs('/dnas/387')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an additional DNA test for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group DeleteAdditionalTestDNAManager
     * @group AuthorKyle
     */
    public function DeleteAdditionalTestDNAManager()
    {
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Delete the first additional test for DNA
                ->assertVisible('#form-delete-dnaanalysis-15 > a > i')
                ->pause(1000)
                //->assertSee('Additional DNA test successfully deleted!')
                ->assertPathIs('/dnas/387')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete an additional DNA test for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group DeleteAdditionalTestDNAOrgAdmin
     * @group AuthorKyle
     */
    public function DeleteAdditionalTestDNAOrgAdmin()
    {
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Delete the first additional test for DNA
                ->assertVisible('#form-delete-dnaanalysis-15 > a > i')
                ->pause(1000)
                //->assertSee('Additional DNA test successfully deleted!')
                ->assertPathIs('/dnas/387')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a resample of DNA test
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group CreateResampleDNA
     * @group AuthorKyle
     */
    public function CreateResampleDNA()
    {
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Create an additional DNA test
                ->click('@dna-resampling-create')
                ->assertPathBeginsWith('/skeletalelements/1221/387/dnaResampling/create')

                // Edit the resample fields
                ->select('@dna-resample-number','1234')
                ->select('@dna-resample-request-date','01012000')
                ->select('@dna-resample-results','TEST')
                ->select('@dna-resample-receive-date','01012000')

                // Save the new additional test
                ->click('@dna-resample-save')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a resample of DNA test for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group CreateResampleDNAManager
     * @group AuthorKyle
     */
    public function CreateResampleDNAManager()
    {
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Create an additional DNA test
                ->click('@dna-resampling-create')
                ->assertPathBeginsWith('/skeletalelements/1221/387/dnaResampling/create')

                // Edit the resample fields
                ->select('@dna-resample-number','1234')
                ->select('@dna-resample-request-date','01012000')
                ->select('@dna-resample-results','TEST')
                ->select('@dna-resample-receive-date','01012000')

                // Save the new additional test
                ->click('@dna-resample-save')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a resample of DNA test for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group CreateResampleDNAOrgAdmin
     * @group AuthorKyle
     */
    public function CreateResampleDNAOrgAdmin()
    {
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Create an additional DNA test
                ->click('@dna-resampling-create')
                ->assertPathBeginsWith('/skeletalelements/1221/387/dnaResampling/create')

                // Edit the resample fields
                ->select('@dna-resample-number','1234')
                ->select('@dna-resample-request-date','01012000')
                ->select('@dna-resample-results','TEST')
                ->select('@dna-resample-receive-date','01012000')

                // Save the new additional test
                ->click('@dna-resample-save')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit a resample of DNA test
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditResampleDNA
     * @group AuthorKyle
     */
    public function EditResampleDNA()
    {
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Select the first DNA resample to edit
                ->click('#collapseDNAResampling > div > div > table > tbody > tr > td:nth-child(1) > div > a')
                ->click('@dna-resampling-action-menu')
                ->click('@dna-resampling-edit-menu')

                // Edit the resample fields
                ->select('@dna-resample-number','9876')
                ->select('@dna-resample-request-date','02022001')
                ->select('@dna-resample-results','TEST EDIT')
                ->select('@dna-resample-receive-date','02022001')

                // Save the new additional test
                ->click('@dna-resample-save')
                ->pause(1000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit a resample of DNA test for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditResampleDNAManager
     * @group AuthorKyle
     */
    public function EditResampleDNAManager()
    {
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Select the first DNA resample to edit
                ->click('#collapseDNAResampling > div > div > table > tbody > tr > td:nth-child(1) > div > a')
                ->click('@dna-resampling-action-menu')
                ->click('@dna-resampling-edit-menu')

                // Edit the resample fields
                ->select('@dna-resample-number','9876')
                ->select('@dna-resample-request-date','02022001')
                ->select('@dna-resample-results','TEST EDIT')
                ->select('@dna-resample-receive-date','02022001')

                // Save the new additional test
                ->click('@dna-resample-save')
                ->pause(1000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to edit a resample of DNA test for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group EditResampleDNAOrgAdmin
     * @group AuthorKyle
     */
    public function EditResampleDNAOrgAdmin()
    {
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Select the first DNA resample to edit
                ->click('#collapseDNAResampling > div > div > table > tbody > tr > td:nth-child(1) > div > a')
                ->click('@dna-resampling-action-menu')
                ->click('@dna-resampling-edit-menu')

                // Edit the resample fields
                ->select('@dna-resample-number','9876')
                ->select('@dna-resample-request-date','02022001')
                ->select('@dna-resample-results','TEST EDIT')
                ->select('@dna-resample-receive-date','02022001')

                // Save the new additional test
                ->click('@dna-resample-save')
                ->pause(1000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete a resample of DNA test
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group DeleteResampleDNA
     * @group AuthorKyle
     */
    public function DeleteResampleDNA()
    {
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Delete the first DNA resample
                ->assertVisible('#form-delete-dnaresample-9')
                ->pause(1000)
                //->assertSee('Specimen Dna Resample successfully deleted!')
                ->assertPathIs('/dnas/387/edit')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete a resample of DNA test for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group DeleteResampleDNAManager
     * @group AuthorKyle
     */
    public function DeleteResampleDNAManager()
    {
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Delete the first DNA resample
                ->assertVisible('#form-delete-dnaresample-9')
                ->pause(1000)
                //->assertSee('Specimen Dna Resample successfully deleted!')
                ->assertPathIs('/dnas/387/edit')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to delete a resample of DNA test for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group DNAProfile
     * @group UNO
     * @group DeleteResampleDNAOrgAdmin
     * @group AuthorKyle
     */
    public function DeleteResampleDNAOrgAdmin()
    {
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

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

                // Navigate to the elements DNA page
                ->click('@se-dna-profile-menu')
                ->assertPathIs('/dnas/387')
                ->assertSee('DNA Profile')

                // Open the edit functions for the DNA profile
                ->click('@actions-button')
                ->click('@actions-edit-menu')
                ->assertPathIs('/dnas/387/edit')
                ->assertSee('Edit DNA Profile')

                // Delete the first DNA resample
                ->assertVisible('#form-delete-dnaresample-9')
                ->pause(1000)
                //->assertSee('Specimen Dna Resample successfully deleted!')
                ->assertPathIs('/dnas/387/edit')
                ->logoutUser();
        });
    }
}
