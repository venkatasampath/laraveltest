<?php

/**
 * SE_ActionEdit DuskTestCase
 *
 * @category   DuskTestCases
 * @package    CoRA-DuskTestCases
 * @author     Kyle Hampton<kthampton@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Test\Browser\Pages\SkeletalElements;
use App\User;

class SE_ActionEdit extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     * @throws
<<<<<<< HEAD
     * @group action_edit
=======
     * @group action2
>>>>>>> 124b74386424458db829efa70e131f5eaf854488
     * @group SE
     */

    public function testSE_ActionEdit()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('/skeletalelements/228')
                ->clickLink('Edit')
                ->assertSee('Edit Specimen')
                ->type('accession_number', '9999')
                ->select('side', 'Right')
                ->check('reviewed', '1' )
                ->driver->executeScript('window.scrollTo(0, 700);');
                // can't chain methods after this
            $browser
                ->press('Save')
                ->pause(500)
                ->assertSee('9999')
                ->assertSee('Right')
                ->assertChecked('reviewed', '1');

        });
    }
}
