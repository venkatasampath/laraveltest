<?php

/**
 * SkeletalElementsEditTest DuskTestCase
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

// 12 Total Test Cases
class editTest extends coraBaseTest
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
    protected function setUp(): void
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
    public function tearDown(): void
    {
        session()->flush();

        parent::tearDown();
    }

    /**
     * A Dusk test to perform valid edit of a specimen
     *
     * @return void
     * @throws
     * @test
     * @group AnalystEditSpecimenBone
     * @group SkeletalElementsEdit
     */
    public function EditSkeletalElement()
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
                ->pause(2000)
                ->maximize()


                //Search for bone Accessory rib
                ->click ('@cora-search-options-bones')
                ->type('@cora-search-options-bones','Accessory rib')
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(2000)

                //Click the skeletal element
                ->visit('/skeletalelements/51665')
                ->pause(2000)

                //click edit button
                ->click ('@edit-button')
                ->pause(3000)

                //Edit Attributes
                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2018-337')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->clear ('@provenance1')
                ->type('@provenance1', 'G-12')
                ->keys('@provenance1', ['{ENTER}'])
                ->pause(3000)
                ->clear ('@se-provenance2')
                ->type('@se-provenance2', 'X-100')
                ->pause(1000)

                ->clear ('@se-designator')
                ->type('@se-designator', '102')
                ->pause(2000)

                //Check to see if reset is working or not
                ->press ('@reset-button')
                ->pause(3000)

                //click edit button
                ->click ('@edit-button')
                ->pause(3000)

                //save button

                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2003-116')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->click('@save-button')
                ->pause(2000)

                ->click ('@edit-button')

                // Specimen Attribute Assertions
                ->click ('@se-bone')

                ->click ('@se-side')
                ->pause(2000)
                ->click ('@se-side')
                ->select('@se-side','Right')
                ->pause(1000)
                ->assertSee('Completeness')
                ->click ('@se-completeness')
                ->clear('@se-completeness')
                ->select('@se-completeness','Incomplete')

                ->pause(2000)

                //Testing check boxes are checked or not
                ->assertNotChecked ('@se-measured')
                ->pause(1000)
                ->assertNotChecked ('@se-dna_sampled')
                ->pause(1000)
                ->assertNotChecked ('@se-isotope_sampled')


                //Insert individual number
                ->type('@se-individual_number','I-100')
                ->press ('@se-identification_date')
                ->pause(2000)
                ->type('@se-remains_status', 'Released')
                ->keys('@se-remains_status','{enter}')
                ->press ('@remains_release_date')
                ->pause(3000)
                //reset to in lab
                ->clear ('@se-remains_status')
                ->type('@se-remains_status', 'In Lab')
                ->pause(1000)


                //Check to see if tag buttons are working

                ->press ('@tag-edit-save')
                ->pause(2000)
                ->press ('@tag-reset')
                ->pause(1000)
                ->press ('@tag-edit-save')
                ->press ('@tag-edit-save')
                ->pause(2000)


                //Comments
                ->type('@comment-text','Test')
                ->pause(2000)



                ->logoutUser();
        });
    }

    /**
     * A Dusk test to perform valid edit of a specimen for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsEdit
     * @group EditSpecimenIndividualNumber
     */
    public function EditSkeletalElementManager()
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


                //Search by Individual number (Femur)

                ->clear ('@cora-search-options')
                ->type('@cora-search-options','Individual Number')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search-options-individual-number','CIL 2003-113-I-247')
                ->pause(1000)
                ->keys('@cora-search-options-individual-number', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(3000)

                //Click the se to edit
                ->visit('/skeletalelements/8130')
                ->pause(2000)
                //click edit button
                ->click ('@edit-button')
                ->pause(3000)

                //Edit Attributes
                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2018-337')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->clear ('@provenance1')
                ->type('@provenance1', 'G-39')
                ->keys('@provenance1', ['{ENTER}'])
                ->pause(3000)
                ->clear ('@se-provenance2')
                ->type('@se-provenance2', 'X-13B')
                ->pause(1000)

                //Check to see if reset is working or not
                ->press ('@reset-button')
                ->pause(3000)

                //click edit button
                ->click ('@edit-button')
                ->pause(3000)

                //save button

                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2003-116')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->click('@save-button')



                ->logoutUser();
        });
    }


    /**
     * A Dusk test to perform valid edit of a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsEdit
     * @group EditSpecimenProvenance1
     */
    public function EditSkeletalElementProvenance1()
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

                //Search for bone Tibia by Provenance 1
                ->clear ('@cora-search-options')
                ->type('@cora-search-options','Provenance 1')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)


                ->keys('@cora-search-options-provenance1','G-01',['{ENTER}'])
                ->keys('@cora-search-options-provenance1', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(3000)

                //Click the se to edit
                ->visit('/skeletalelements/1064')
                ->pause(1000)
                ->click ('@edit-button')
                ->pause(3000)

                //Edit Attributes
                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2018-337')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->clear ('@provenance1')
                ->type('@provenance1', 'G-39')
                ->keys('@provenance1', ['{ENTER}'])
                ->pause(3000)
                ->clear ('@se-provenance2')
                ->type('@se-provenance2', 'X-13B')
                ->pause(1000)

                //Check to see if reset is working or not
                ->press ('@reset-button')
                ->pause(3000)
                //click edit button
                ->click ('@edit-button')
                ->pause(3000)
                //save button
                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2003-116')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->click('@save-button')



                ->logoutUser();
        });
    }
    /**
     * A Dusk test to perform valid edit of a specimen for an anthro admin.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsEdit
     * @group AnalystEditSpecimenAccession
     */

    public function EditSkeletalElementAccession()
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

                //Search for bone Unseriated rib by Accession CIL 2003-116
                ->pause(3000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Accession')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->keys('@cora-search-options-accessions','CIL 2003-116',['{ENTER}'])
                ->pause(1000)
                ->keys('@cora-search-options-accessions',['{tab}'])
                ->press('@search-btn')
                ->pause(2000)

                //Click the se to edit
                ->visit('/skeletalelements/1010')
                ->pause(1000)
                ->click ('@edit-button')
                ->pause(3000)

                //Edit Attributes
                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2018-337')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->clear ('@provenance1')
                ->type('@provenance1', 'G-39')
                ->keys('@provenance1', ['{ENTER}'])
                ->pause(3000)
                ->clear ('@se-provenance2')
                ->type('@se-provenance2', 'X-13B')
                ->pause(1000)

                //Check to see if reset is working or not
                ->press ('@reset-button')
                ->pause(3000)
                //click edit button
                ->click ('@edit-button')
                ->pause(3000)
                //save button
                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2003-116')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->click('@save-button')

                //Insert Mass
                ->type('@se-mass','11.4')
                ->pause(2000)
                ->press ('@reset-button')


                ->logoutUser();
        });
    }

    /**
     * A Dusk test to perform valid edit of a specimen for an anthro admin.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsEdit
     * @group AnalystEditSpecimenCompositeKey
     */

    public function EditSkeletalElementCompositeKey()
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

                //Search for specimen by composite key (Cranium)
                ->pause(5000)
                ->clear('@cora-search-options')
                ->type('@cora-search-options','Composite Key')
                ->pause(1000)
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->type('@cora-search','CIL 2003-116:G-25:X-247C:101')
                ->keys('@cora-search','{enter}')
                ->pause(2000)

                //Click the se to edit
                ->visit('/skeletalelements/1063')
                ->pause(1000)
                ->click ('@edit-button')
                ->pause(3000)

                //Edit Attributes
                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2018-337')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->clear ('@provenance1')
                ->type('@provenance1', 'G-39')
                ->keys('@provenance1', ['{ENTER}'])
                ->pause(3000)
                ->clear ('@se-provenance2')
                ->type('@se-provenance2', 'X-13B')
                ->pause(1000)

                //Check to see if reset is working or not
                ->press ('@reset-button')
                ->pause(3000)
                //click edit button
                ->click ('@edit-button')
                ->pause(3000)
                //save button
                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2003-116')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->click('@save-button')



                ->logoutUser();
        });
    }

    /**
     * A Dusk test to perform valid edit of a specimen for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group SkeletalElementsEdit
     * @group EditSkeletalElementProvenance2
     */
    public function EditSkeletalElementProvenance2()
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

                //Search for bone Scapula by Provenance 2
                ->clear ('@cora-search-options')
                ->type('@cora-search-options','Provenance 2')
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->keys('@cora-search-options', ['{ENTER}'])
                ->pause(500)


                ->keys('@cora-search-options-provenance2','X-100',['{ENTER}'])
                ->keys('@cora-search-options-provenance2', ['{ENTER}'])
                ->keys('@search-btn','{enter}')
                ->pause(3000)

                //Click the se to edit
                ->visit('/skeletalelements/25340')
                ->pause(1000)
                ->click ('@edit-button')
                ->pause(3000)

                //Edit Attributes
                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2018-337')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->clear ('@provenance1')
                ->type('@provenance1', 'G-39')
                ->keys('@provenance1', ['{ENTER}'])
                ->pause(3000)
                ->clear ('@se-provenance2')
                ->type('@se-provenance2', 'X-13B')
                ->pause(1000)

                //Check to see if reset is working or not
                ->press ('@reset-button')
                ->pause(3000)
                //click edit button
                ->click ('@edit-button')
                ->pause(3000)
                //save button
                ->clear ('@se-accession')
                ->type('@se-accession', 'CIL 2003-116')
                ->keys('@se-accession', ['{ENTER}'])
                ->pause(2000)
                ->click('@save-button')


                ->logoutUser();
        });
    }
}