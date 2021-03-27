<?php

/**
 * Administration Section DuskTestCase
 *
 * @category   DuskTestCases
 * @package    CoRA2-DuskTestCases
 * @author     John Placzek
 *
 */

namespace Tests\Browser;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\instrumentManagementPage;
use App\User;


/**
 * Overall test file for the Project Management section
 * that lies underneath the Administration section
 *
 * @return void
 * @throws
 * @group section_ADMIN
 * @group part_instrument_management
 * @group full_instrument_test
 * @group author_John
 *
 */

class admin_InstrumentManagementTest extends DuskTestCase
{


    /**
     * A Dusk test to create a new Instrument
     *
     * @return void
     * @throws
     * @group InstrumentManagement
     * @group InstrumentCreate
     * @group AuthorJohn
     *
     */
    public function testInstrumentCreate()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new instrumentManagementPage())
                ->assertSee('Instruments')
                ->press('@actions-button')
                ->press('@actions-create-menu')
                ->assertSee('New Instrument')
                ->type('@code',uniqid('TestInstrument_'))
                ->type('@category', 'Dusk Testing')
                ->type('@module','Summer Capstone')
                ->type('@reference','Test - safe to delete')
                ->press('Save')
                //->press('@save-button')  //TODO: use this once DUSK tag is fixed
                ->assertsee('View Instrument - TestInstrument_');
        });
    }


    /**
     * A Dusk test to fail creating a new Instrument
     *
     * @return void
     * @throws
     * @group InstrumentManagement
     * @group InstrumentCreateFail
     * @group AuthorJohn
     *
     */
    public function testInstrumentCreateFail()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new instrumentManagementPage())
                ->assertSee('Instruments')
                ->press('@actions-button')
                ->press('@actions-create-menu')
                ->assertSee('New Instrument')

                //Trying when leaving the Code field empty
                //->type('@code', 'Fail Test')
                ->type('@category', 'Fail Test')
                ->type('@module','Fail Test')
                ->type('@reference','Fail Test')
                ->press('Save')
                //->press('@save-button') //TODO: use this once DUSK tag is fixed
                ->assertsee('New Instrument');

                //Trying when leaving the Category field empty
            $browser->loginAs($user)
                ->visit(new instrumentManagementPage())
                ->assertSee('Instruments')
                ->press('@actions-button')
                ->press('@actions-create-menu')
                ->assertSee('New Instrument')
                ->type('@code', 'Fail Test')
                //->type('@category', 'Fail Test')
                ->type('@module','Fail Test')
                ->type('@reference','Fail Test')
                ->press('Save')
                //->press('@save-button') //TODO: use this once DUSK tag is fixed
                ->assertsee('New Instrument');

                //Trying when leaving the Module field empty
            $browser->loginAs($user)
                ->visit(new instrumentManagementPage())
                ->assertSee('Instruments')
                ->press('@actions-button')
                ->press('@actions-create-menu')
                ->assertSee('New Instrument')
                ->type('@code', 'Fail Test')
                ->type('@category', 'Fail Test')
                //->type('@module','Fail Test')
                ->type('@reference','Fail Test')
                ->press('Save')
                //->press('@save-button') //TODO: use this once DUSK tag is fixed
                ->assertsee('New Instrument');
        });
    }


    /**
     * A Dusk test to edit an Instrument
     *
     * @return void
     * @throws
     * @group InstrumentManagement
     * @group InstrumentEdit
     * @group AuthorJohn
     *
     */
    public function testInstrumentEdit()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new instrumentManagementPage())
                ->assertSee('Instruments')
                ->type('@search', 'testinstrument1000')
                ->click('@searchtopresult')
                ->assertsee('View Instrument - TestInstrument1000')
                ->press('@actions-button')
                ->press('@actions-edit-menu')
                ->type('@code','TestInstrumentEdit1000')
                ->type('@category', 'Dusk Testing - Edit')
                ->type('@module', 'Edit Test')
                ->type('@reference', 'Edit Test')
                ->press('Save')
                //->press('@save-button') //TODO: use this once DUSK tag is fixed
                ->assertsee('View Instrument - TestInstrumentEdit1000');
        });


        //change instrument info back
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new instrumentManagementPage())
                ->type('@search', 'testinstrumentedit1000')
                ->click('@searchtopresult')
                ->assertsee('View Instrument - TestInstrumentEdit1000')
                ->press('@actions-button')
                ->press('@actions-edit-menu')
                ->type('@code','TestInstrument1000')
                ->type('@category', 'Dusk Testing')
                ->type('@module', 'Summer Capstone')
                ->type('@reference', 'Test')
                ->press('Save')
                //->press('@save-button') //TODO: use this once DUSK tag is fixed
                ->assertsee('View Instrument - TestInstrument1000');
        });
    }


    /**
     * A Dusk test to test Discard Changes option
     * when editing a instrument object.
     *
     * @return void
     * @throws
     * @group InstrumentManagement
     * @group InstrumentEditDiscard
     * @group AuthorJohn
     *
     */
    public function testInstrumentEditDiscard()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new instrumentManagementPage())
                ->assertSee('Instruments')
                ->type('@search', 'testinstrument1000')
                ->click('@searchtopresult')
                ->assertsee('View Instrument - TestInstrument1000')
                ->press('@actions-button')
                ->press('@actions-edit-menu')
                ->assertsee('Edit Instrument - TestInstrument1000')
                ->type('@code','TestInstrumentDiscard1000')
                ->type('@category', 'EditDiscard')
                ->press('@actions-button')
                ->press('@actions-discard-menu')
                ->assertsee('View Instrument - TestInstrument1000');
        });
    }


//TODO: Waiitng on bug fix to complete test.
//TODO: Currently, page errors when browsing to the Assign Users page.
    /**
     * A Dusk test case that will test adding and removing
     * users from a instrument
     *
     * @return void
     * @throws
     * @group InstrumentUsers
     *
     */

    /**
    public function testInstrumentUsers()
    {
        $this->browse(function (Browser $browser) {
            $user = user::find(1);
            $browser->loginAs($user)
                ->visit(new InstrumentManagementPage())
                ->type('@search', 'testinstrument1000')
                ->click('@searchtopresult')
                ->assertSee('View Instrument - TestInstrument1000')
                ->press('#app > div > div.app-content > div > div > div > div > div.card-body > form > div:nth-child(7) > div > a')
                ->assertsee('afajljad');



             //Testing adding users to project
             ->type('@users-assigned-field','pawaska')
             ->keys('@users-assigned-field','{enter}')
             ->press('Save')
             ->assertSee('user(s) successfully associated')
             ->assertSee('Pawaskar');




             //Testing removing users from project
             ->press('@users-assigned-remove-button')
             ->keys('@users-assigned-field','{escape}')
             ->assertDontSee('Pawaskar');

        });
    }
     */
}
