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

class specimen_ActionEditDiscardTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     * @throws
     * @group create_bone_complete
     * @group SE
     */

    public function testSE_ActionEdit()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('/skeletalelements/228')
                ->clickLink('Edit')
                //->assertSee('Edit Specimen - UNO 2016-212-G-01-X-232C-401')
                ->type('accession_number', '9999')
                ->select('side', 'Right')
                ->clickLink('Discard Changes')
                ->assertSee('View')
                ->assertSee('test')
                ->assertSee('Left');

        });
    }
}
