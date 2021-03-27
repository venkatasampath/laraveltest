<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use Tests\DuskTestCase;

class specimenReviewTest extends coraBaseTest
{
    /**
     * A Dusk test to verify the save of a general in Specimen Review.
     *
     * @return void
     * @throws
     * @test
     * @group general
     * @group Sprint21
     * @group SpecimenReview
     */
    public function specimenGeneralReview()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->pause(1000)
                ->loginUser($user['email'], $user['password'])
                ->pause(1000)
                ->assertSee('Welcome');
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->maximize()
                ->pause(1000)

                //Review page
                ->visit('/skeletalelements/1266/review')
                ->pause(1000)
                ->click('@bone-review')
                ->pause(1000)
                ->keys('@bone-review',['{ARROW_DOWN}'])
                ->keys('@bone-review', '{ENTER}')
                ->pause(1000)
                ->click('@side-review')
                ->pause(1000)
                ->keys('@side-review',['{ARROW_DOWN}'])
                ->keys('@side-review', '{ENTER}')
                ->pause(1000)
                //->driver->executeScript('window.scrollTo(0,9000);');
                ->click('@completeness-review')
                ->pause(1000)
                ->keys('@completeness-review',['{ARROW_DOWN}'])
                ->keys('@completeness-review', '{ENTER}')
                ->pause(1000)
                ->click('@review-save')
                ->pause(1000)
                ->assertSee('Update successful')
                ->logoutUser();


        });
    }
    /**
     * A Dusk test to verify the save of a general in BiologicalProfile Review.
     *
     * @return void
     * @throws
     * @test
     * @group Sprint21
     * @group BiologicalProfilereview
     * @group SpecimenReview
     */
    public function BiologicalProfileReview()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->pause(2000)
                ->loginUser($user['email'], $user['password'])
                ->pause(2000)
                ->assertSee('Welcome')

                //Review page
                ->visit('/skeletalelements/1266/review')
                ->pause(1000)
                ->click('@biological-review')
                ->pause(10000)
                ->click('@biologicalProfile-dropdown')
                ->pause(1000)
                ->click('@Dorsal')
                ->pause(1000)
                ->keys('@Dorsal', ['{ARROW_DOWN}'])
                ->keys('@Dorsal', '{ENTER}')
                ->pause(1000)
                ->click('@Ventral')
                ->pause(1000)
                ->keys('@Ventral', ['{ARROW_DOWN}'])
                ->keys('@Ventral', '{ENTER}')
                ->pause(1000)
                ->click('@Rim')
                ->pause(1000)
                ->keys('@Rim', ['{ARROW_DOWN}'])
                ->keys('@Rim', '{ENTER}')
                ->pause(1000)
                ->click('@Composite Score - SUMALL')
                ->pause(1000)
                ->keys('@Composite Score - SUMALL', ['{ARROW_DOWN}'])
                ->keys('@Composite Score - SUMALL', '{ENTER}')
                ->pause(1000)
                ->click('@methods-review-save')
                ->pause(1000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the save of a general in DNA Review.
     *
     * @return void
     * @throws
     * @test
     * @group Sprint21
     * @group DNAreview
     * @group SpecimenReview
     */
    public function DNAReview(){
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->maximize()
                // Search Result Assertions for humerus 2016-230
                //Click the skeletal element

                //Review page
                ->visit('/skeletalelements/1363/review')
                ->pause(2000)
                ->click('@dna-review')
                ->pause(7000)
                ->click('@DNA-dropdown')
                ->pause(2000)
                ->click('@DNA-general')
                ->pause(2000)
                ->type('@DNA-general-external_case_id','5')
                ->keys('@DNA-general-external_case_id', '{ENTER}')
                ->pause(1000)
                ->type('@DNA-general-external_sample_number','6')
                ->keys('@DNA-general-external_sample_number', '{ENTER}')
                ->pause(1000)
                ->type('@DNA-general-dispostion_of_evidence','7')
                ->keys('@DNA-general-dispostion_of_evidence', '{ENTER}')
                ->pause(1000)
                ->type('@DNA-general-locus','7')
                ->keys('@DNA-general-locus', '{ENTER}')
                ->pause(1000)
                ->type('@DNA-general-notes','7')
                ->keys('@DNA-general-notes', '{ENTER}')
                ->pause(1000)
                ->click('@DNA-auSTR')
                ->pause(1000)
                ->type('@austr-austr_method', 'AmpFLSTR Minifiler')
                ->keys('@austr-austr_method', '{ENTER}')
                ->pause(3000)
                ->type('@austr-austr_results_confidence', '')
                ->type('@austr-austr_results_confidence', 'Pending')
                ->keys('@austr-austr_results_confidence', '{ENTER}')
                ->pause(3000)
                ->type('@austr-austr_sequence_number','7')
                ->keys('@austr-austr_sequence_number', '{ENTER}')
                ->pause(1000)
                ->click('@DNA-Mito')
                ->pause(1000)
                ->type('@Mito-mito_method','Sanger')
                ->keys('@Mito-mito_method', '{ENTER}')
                ->pause(3000)
                ->type('@Mito-mito_sequence_number', '7')
                ->keys('@Mito-mito_sequence_number', '{ENTER}')
                ->pause(1000)
                ->click('@DNA-ySTR')
                ->pause(1000)
                ->type('@ystr-ystr_method', 'Y filer')
                ->keys('@ystr-ystr_method', '{ENTER}')
                ->pause(3000)
                ->type('@ystr-ystr_sequence_number', '7')
                ->keys('@ystr-ystr_sequence_number', '{ENTER}')
                ->pause(1000)
                ->type('@ystr-ystr_sequence_subgroup', '8')
                ->keys('@ystr-ystr_sequence_subgroup', '{ENTER}')
                ->pause(1000)
                ->type('@ystr-ystr_sequence_similar', '8')
                ->keys('@ystr-ystr_sequence_similar', '{ENTER}')
                ->pause(1000)
                ->type('@ystr-ystr_match_count', '9')
                ->keys('@ystr-ystr_match_count', '{ENTER}')
                ->pause(1000)
                ->type('@ystr-ystr_total_count', '10')
                ->keys('@ystr-ystr_total_count', '{ENTER}')
                ->pause(1000)
                ->type('@ystr-ystr_num_loci', '11')
                ->keys('@ystr-ystr_num_loci', '{ENTER}')
                ->pause(1000)
                ->click('@dna-review-save')
                ->pause(1000)
                ->assertSee('Update successful')
                ->logoutUser();
        });
    }

    /**
     * A Dusk test to verify the save of a general in DNA Review.
     *
     * @return void
     * @throws
     * @test
     * @group taphonomyReview
     * @group Sprint21
     * @group SpecimenReview
     */
    public function TaphonomyReview(){
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome')
                // Skeletal elements search set up

                //Review page
                ->visit('/skeletalelements/1266/review')
                ->pause(2000)
                ->click('@taphonomy-review')
                ->pause(4000)
//                ->click('@se-taphonomys-menu')
//                ->keys('@se-taphonomys-menu', ['{ARROW_DOWN}'])
//                ->keys('@se-taphonomys-menu', '{ENTER}')
                ->pause(2000)
                ->click('@taphonomy-review-save')
                ->pause(1000)
                ->assertSee('Update successful')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the save of a general in DNA Review.
     *
     * @return void
     * @throws
     * @test
     * @group Zonesreview
     * @group Sprint21
     * @group SpecimenReview
     */
    public function ZonesReview()
    {
        $user = ['email' => 'test.anthro.analyst@unomaha.edu', 'password' => '!UnoSpr@2021'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->maximize()
                ->pause(2000)
                //Review page
                ->visit('/skeletalelements/1266/review')
                ->pause(2000)
                ->click('@zones-step')
                ->pause(1000)
                ->click('@2-caputswitch')
                ->pause(3000)
                ->click('@zones-review-save')
                ->pause(1000)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the save of a general in Measurement Review.
     *
     * @return void
     * @throws
     * @test
     * @group Sprint21
     * @group Measurementreview
     * @group SpecimenReview
     */
    public function MeasurementReview()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->maximize()
                //Review page
                ->visit('/skeletalelements/1311/review')
                ->pause(2000)
                ->click('@measurements-step')
                ->pause(1000)
                ->click('@measurements-review-101')
                ->pause(1000)
                ->clear('@measurements-review-101')
                ->pause(1000)
                ->type('@measurements-review-101',1)
                ->pause(1000)
                ->click('@measurements-review-102')
                ->pause(1000)
                ->clear('@measurements-review-102')
                ->pause(1000)
                ->click('@measurements-review-102')
                ->type('@measurements-review-102','1.5')
                ->pause(1000)
                ->click('@measurements-review-103')
                ->pause(1000)
                ->clear('@measurements-review-103')
                ->pause(1000)
                ->type('@measurements-review-103','2')
                ->pause(1000)
                ->click('@measurements-review-104')
                ->pause(1000)
                ->clear('@measurements-review-104')
                ->pause(1000)
                ->type('@measurements-review-104','2.5')
                ->pause(1000)
                ->click('@measurements-review-106')
                ->pause(1000)
                ->clear('@measurements-review-106')
                ->pause(1000)
                ->type('@measurements-review-106','3.5')
                ->pause(1000)
                ->click('@measurements-review-107')
                ->pause(1000)
                ->clear('@measurements-review-107')
                ->pause(1000)
                ->type('@measurements-review-107','5')
                ->pause(1000)
                ->click('@measurements-review-108')
                ->pause(1000)
                ->clear('@measurements-review-108')
                ->pause(1000)
                ->type('@measurements-review-108','4.5')
                ->pause(1000)
                ->click('@measurements-review-109')
                ->pause(1000)
                ->clear('@measurements-review-109')
                ->pause(1000)
                ->type('@measurements-review-109','6.5')
                ->pause(1000)
                ->click('@measurements-review-110')
                ->pause(1000)
                ->clear('@measurements-review-110')
                ->pause(1000)
                ->type('@measurements-review-110','7')
                ->pause(1000)
                ->click('@measurements-review-111')
                ->pause(1000)
                ->clear('@measurements-review-111')
                ->pause(1000)
                ->type('@measurements-review-111','7.5')
                ->pause(1000)
                ->click('@measurements-review-112')
                ->pause(1000)
                ->clear('@measurements-review-112')
                ->pause(1000)
                ->type('@measurements-review-112','8')
                ->pause(1000)
                ->click('@measurements-review-113')
                ->pause(1000)
                ->clear('@measurements-review-113')
                ->pause(1000)
                ->type('@measurements-review-113','8.5')
                ->pause(1000)
                ->click('@measurements-review-114')
                ->pause(1000)
                ->clear('@measurements-review-114')
                ->pause(1000)
                ->type('@measurements-review-114','10.2')
                ->pause(1000)
                ->click('@measurements-review-115')
                ->pause(1000)
                ->clear('@measurements-review-115')
                ->pause(1000)
                ->type('@measurements-review-115','11')
                ->pause(1000)
                ->click('@measurements-review-116')
                ->pause(1000)
                ->clear('@measurements-review-116')
                ->pause(1000)
                ->type('@measurements-review-116','7.5')
                ->pause(1000)
                ->click('@measurements-review-117')
                ->pause(1000)
                ->clear('@measurements-review-117')
                ->pause(1000)
                ->type('@measurements-review-117','10')
                ->pause(1000)
                ->click('@measurements-review-save')
                ->pause(1000)
                ->logoutUser();
        });
    }

    /**
     * A Dusk test to verify the save of a general in Association Review.
     *
     * @return void
     * @throws
     * @test
     * @group Associationreview
     * @group Sprint21
     * @group SpecimenReview
     */
    public function reviewAssociation()
    {
        // Test user login

        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');
            // Skeletal elements search set up


            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->maximize()

                //Search for bone Humerus

                //Click the skeletal element
                //Review page
                ->visit('/skeletalelements/1364/review')
                ->pause(2000)
                ->click('@associations-step')
                ->pause(1000)

                //Articulations
                ->assertSee('Articulations')
                ->click('@articulations-panel')
                ->pause(1000)
                ->click('@articulations-menu')
                ->pause(4000)
                ->keys('@association-review-option', ['{ARROW_DOWN}'])
                ->pause(3000)
                ->keys('@association-review-option', ['{ENTER}'])
                ->pause(5000)
                //save button
                ->click('@association-review-save')
                ->pause(1000)
                //accept button
                ->click('@association-review-accept')
                ->pause(1000)
//                $browser->driver->executeScript('window.scrollTo(0, 400);');



//            // Pair Matching
                ->click('@associations-step')
                ->pause(1000)
                ->click('@pairmatching-panel')
                ->pause(4000)
                ->click('@pairmatching-menu')
                ->pause(1000)
                ->keys('@association-review-option', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@association-review-option', ['{ENTER}'])
                ->pause(1000)

                //save button
                ->click('@association-review-save')
                ->pause(1000)
                //accept button
                ->click('@association-review-accept')
                ->pause(1000)
                # refits

                ->click('@associations-step')
                ->pause(1000)
                ->click('@refits-panel')
                ->pause(1000)
                ->click('@refits-menu')
                ->pause(1000)
                ->keys('@association-review-option', ['{ARROW_DOWN}'])
                ->pause(3000)
                ->keys('@association-review-option', ['{ENTER}'])
                ->pause(3000)
                //save button
                ->click('@association-review-save')
                ->pause(1000)
                ->click('@association-review-accept')
                ->pause(2000)

                #morphology
                ->click('@associations-step')
                ->pause(1000)
                ->click('@morphology-panel')
                ->pause(1000)
//                ->click('@association-review-accept')
                ->pause(1000);
        });
    }

    /**
     * A Dusk test to verify the save of a general in DNA Review.
     *
     * @return void
     * @throws
     * @test
     * @group Pathologiesreview
     * @group Sprint21
     * @group SpecimenReview
     */
    public function PathologiesReview()
    {
        $user = ['email' => 'test.anthro.analyst@unomaha.edu', 'password' => '!UnoSpr@2021'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');
            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(5000)
                ->maximize()

                //Review page
                ->visit('/skeletalelements/1364/review')
                ->pause(1000)
                ->click('@pathology-review')
                ->pause(1000)
                ->click('@pathology-panel')
                ->pause(1000)
                ->click('@pathology-review-save')
                ->pause(1000)
                ->click('@pathology-review-accept')
                ->pause(1000)

                # Trauma
                ->click('@pathology-review')
                ->pause(1000)
                ->click('@trauma-panel')
                ->pause(1000)
                ->click('@trauma-review-save')
                ->pause(1000)
                ->click('@trauma-review-accept')
                ->pause(1000)


                #Anomaly
                ->click('@anomaly-panel')
                ->pause(3000);
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser-> pause(2000)
                ->click('@anomaly-review-save')
                ->pause(1000)
                ->click('@anomaly-review-accept')
                ->pause(1000)
                ->logoutUser();
        });
    }
}
