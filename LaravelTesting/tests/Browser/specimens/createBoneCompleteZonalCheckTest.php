<?php

/**
 * SE_ActionCreate DuskTestCase
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

class specimen_CreateBoneCompleteZonalCheckTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     * @throws
     * @group create_complete_bone
     * @group SE
     */

    public function testSE_CreateBoneCompleteZonalCheckTest()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('/skeletalelements/')
                ->clickLink('Create')
                ->assertSee('New Specimen')
                ->type('accession_number', 'TESTZone22')
                ->type('provenance1', 'TEST')
                ->type('provenance2', 'TEST')
                ->type('designator', 'TEST')
                ->select('sb_id[type]', 'Clavicle')
                //->keys('{arrow_down}','{arrow_down}','{arrow_down}','{arrow_down}','{arrow_down}','{arrow_down}','{arrow_down}','{arrow_down}','{arrow_down}','{arrow_down}','{arrow_down}','{arrow_down}','{enter}')
                //->select('side','Right')
                //->select('completeness','Complete')
                ->press('hi');
                //->assertsee('Clavicle')
                //->assertSee('View');
                //->clickLink('Zonal Classification')
                //->assertSee('Zones:')
                //->assertNotChecked('#app > div.app-content > div > div > div > div > div.panel-body > form:nth-child(2) > div > div.panel-body > div > div:nth-child(2) > fieldset:nth-child(1) > div > div > div > label', '1');
                //->assertChecked('2 - Acromial end', '1');
                //->assertChecked('3 - Diaphysis', '1');
        });
    }
}
