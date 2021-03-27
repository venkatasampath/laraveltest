<?php

/**
 * ExportOptionsTest DuskTestCase
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
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\exportOptionsPage;

// 1 Total Test Cases
class exportOptionsTest  extends coraBaseTest
{
    /**
     * A Dusk test to verify the export of a single report.
     *
     * @return void
     * @throws
     * @test
     * @group ExportOptions
     * @group UNO2
     * @group ExportOptions
     * @group AuthorKyle
     * @group FileExport
     * @group Sprint21
     */
    public function FileExport()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Export Options set up
            $browser->visit(new exportOptionsPage)
                ->assertPathIs('/exportOptions')
                ->assertSee('Export Type')
                ->assertSee('Description')
                ->assertSee('Actions');
        });
    }
    public function ExportOptions()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Export Options set up
            $browser->visit(new exportOptionsPage)
                ->assertPathIs('/exportOptions')
                ->assertSee('Export Type')
                ->assertSee('Description')
                ->assertSee('Actions')

                // Initiate an All Base package export 1
                ->click('@export-button-1')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the All Base package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_base')

                // Initiate an All Specimens package export 2
                ->visit('/exportOptions')
                ->click('@export-button-2')
                //->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the All Specimens package export 2
                //->waitForText('File Export completed. Please check File Manager',100)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_all')

                // Initiate a DNA package export 3
                ->visit('/exportOptions')
                ->click('@export-button-3')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the DNA package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_dna')

                // Initiate a Measurements package export 4
                ->visit('/exportOptions')
                ->click('@export-button-4')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Measurements package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_measurements')

                // Initiate a Zones package export 5
                ->visit('/exportOptions')
                ->click('@export-button-5')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Zones package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_zones')

                // Initiate a Association package export 6
                ->visit('/exportOptions')
                ->click('@export-button-6')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Association package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_associations')

                // Initiate a Pairs package export 7
                ->visit('/exportOptions')
                ->click('@export-button-7')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pairs package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pairs')

                // Initiate a Articulations package export 8
                ->visit('/exportOptions')
                ->click('@export-button-8')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Articulations package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_articulations')

                // Initiate a Refits package export 9
                ->visit('/exportOptions')
                ->click('@export-button-9')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Refits package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_refits')

                // Initiate a Taphonomies package export 10
                ->visit('/exportOptions')
                ->click('@export-button-10')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Taphonomies package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_taphonomies')

                // Initiate a Pathology All package export 11
                ->visit('/exportOptions')
                ->click('@export-button-11')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pathology All package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pathology_all')

                // Initiate a Pathology package export 12
                ->visit('/exportOptions')
                ->click('@export-button-12')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pathology package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pathology_2')

                // Initiate a Trauma package export 13
                ->visit('/exportOptions')
                ->click('@export-button-13')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Trauma package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_trauma')

                // Initiate a Anomaly package export 14
                ->visit('/exportOptions')
                ->click('@export-button-14')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Anomaly package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_anomaly')

                // Initiate a Methods package export 15
                ->visit('/exportOptions')
                ->click('@export-button-15')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Methods package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_methods')

                // Initiate an Measurements package export 16
                ->visit('/exportOptions')
                ->click('@export-button-16')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Measurements package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_measurements')

                // Initiate an Measurements package export 17
                ->visit('/exportOptions')
                ->click('@export-button-16')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Measurements package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_measurements')

                // Initiate an Zones package export 17
                ->visit('/exportOptions')
                ->click('@export-button-17')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Zones package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_zones')

                // Initiate an Anomaly package export 18
                ->visit('/exportOptions')
                ->click('@export-button-18')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Anomaly package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_anomaly')

                // Initiate an Pathology package export 19
                ->visit('/exportOptions')
                ->click('@export-button-19')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pathology package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pathology')

                // Initiate an Taphonomies package export 20
                ->visit('/exportOptions')
                ->click('@export-button-20')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Taphonomies package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_taphonomies')

                // Initiate an Trauma package export 21
                ->visit('/exportOptions')
                ->click('@export-button-21')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Trauma package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_trauma')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the export of a single report for a manager
     *
     * @return void
     * @throws
     * @test
     * @group ExportOptions
     * @group UNO2
     * @group ExportOptionsManager
     * @group AuthorKyle
     */
    public function ExportOptionsManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Export Options set up
            $browser->visit(new exportOptionsPage)
                ->assertPathIs('/exportOptions')
                ->assertSee('Export Type')
                ->assertSee('Description')
                ->assertSee('Actions')

                // Initiate an All Base package export 1
                ->click('@export-button-1')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the All Base package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_base')

                // Initiate an All Specimens package export 2
                ->visit('/exportOptions')
                ->click('@export-button-2')
                //->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the All Specimens package export 2
                //->waitForText('File Export completed. Please check File Manager',100)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_all')

                // Initiate a DNA package export 3
                ->visit('/exportOptions')
                ->click('@export-button-3')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the DNA package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_dna')

                // Initiate a Measurements package export 4
                ->visit('/exportOptions')
                ->click('@export-button-4')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Measurements package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_measurements')

                // Initiate a Zones package export 5
                ->visit('/exportOptions')
                ->click('@export-button-5')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Zones package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_zones')

                // Initiate a Association package export 6
                ->visit('/exportOptions')
                ->click('@export-button-6')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Association package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_associations')

                // Initiate a Pairs package export 7
                ->visit('/exportOptions')
                ->click('@export-button-7')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pairs package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pairs')

                // Initiate a Articulations package export 8
                ->visit('/exportOptions')
                ->click('@export-button-8')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Articulations package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_articulations')

                // Initiate a Refits package export 9
                ->visit('/exportOptions')
                ->click('@export-button-9')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Refits package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_refits')

                // Initiate a Taphonomies package export 10
                ->visit('/exportOptions')
                ->click('@export-button-10')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Taphonomies package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_taphonomies')

                // Initiate a Pathology All package export 11
                ->visit('/exportOptions')
                ->click('@export-button-11')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pathology All package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pathology_all')

                // Initiate a Pathology package export 12
                ->visit('/exportOptions')
                ->click('@export-button-12')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pathology package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pathology_2')

                // Initiate a Trauma package export 13
                ->visit('/exportOptions')
                ->click('@export-button-13')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Trauma package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_trauma')

                // Initiate a Anomaly package export 14
                ->visit('/exportOptions')
                ->click('@export-button-14')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Anomaly package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_anomaly')

                // Initiate a Methods package export 15
                ->visit('/exportOptions')
                ->click('@export-button-15')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Methods package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_methods')

                // Initiate an Measurements package export 16
                ->visit('/exportOptions')
                ->click('@export-button-16')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Measurements package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_measurements')

                // Initiate an Measurements package export 17
                ->visit('/exportOptions')
                ->click('@export-button-16')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Measurements package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_measurements')

                // Initiate an Zones package export 17
                ->visit('/exportOptions')
                ->click('@export-button-17')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Zones package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_zones')

                // Initiate an Anomaly package export 18
                ->visit('/exportOptions')
                ->click('@export-button-18')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Anomaly package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_anomaly')

                // Initiate an Pathology package export 19
                ->visit('/exportOptions')
                ->click('@export-button-19')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pathology package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pathology')

                // Initiate an Taphonomies package export 20
                ->visit('/exportOptions')
                ->click('@export-button-20')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Taphonomies package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_taphonomies')

                // Initiate an Trauma package export 21
                ->visit('/exportOptions')
                ->click('@export-button-21')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Trauma package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_trauma')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the export of a single report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group ExportOptions
     * @group UNO2
     * @group ExportOptionsOrgAdmin
     * @group AuthorKyle
     */
    public function ExportOptionsOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Export Options set up
            $browser->visit(new exportOptionsPage)
                ->assertPathIs('/exportOptions')
                ->assertSee('Export Type')
                ->assertSee('Description')
                ->assertSee('Actions')

                // Initiate an All Base package export 1
                ->click('@export-button-1')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the All Base package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_base')

                // Initiate an All Specimens package export 2
                ->visit('/exportOptions')
                ->click('@export-button-2')
                //->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the All Specimens package export 2
                //->waitForText('File Export completed. Please check File Manager',100)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_all')

                // Initiate a DNA package export 3
                ->visit('/exportOptions')
                ->click('@export-button-3')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the DNA package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_dna')

                // Initiate a Measurements package export 4
                ->visit('/exportOptions')
                ->click('@export-button-4')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Measurements package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_measurements')

                // Initiate a Zones package export 5
                ->visit('/exportOptions')
                ->click('@export-button-5')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Zones package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_zones')

                // Initiate a Association package export 6
                ->visit('/exportOptions')
                ->click('@export-button-6')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Association package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_associations')

                // Initiate a Pairs package export 7
                ->visit('/exportOptions')
                ->click('@export-button-7')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pairs package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pairs')

                // Initiate a Articulations package export 8
                ->visit('/exportOptions')
                ->click('@export-button-8')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Articulations package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_articulations')

                // Initiate a Refits package export 9
                ->visit('/exportOptions')
                ->click('@export-button-9')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Refits package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_refits')

                // Initiate a Taphonomies package export 10
                ->visit('/exportOptions')
                ->click('@export-button-10')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Taphonomies package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_taphonomies')

                // Initiate a Pathology All package export 11
                ->visit('/exportOptions')
                ->click('@export-button-11')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pathology All package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pathology_all')

                // Initiate a Pathology package export 12
                ->visit('/exportOptions')
                ->click('@export-button-12')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pathology package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pathology_2')

                // Initiate a Trauma package export 13
                ->visit('/exportOptions')
                ->click('@export-button-13')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Trauma package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_trauma')

                // Initiate a Anomaly package export 14
                ->visit('/exportOptions')
                ->click('@export-button-14')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Anomaly package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_anomaly')

                // Initiate a Methods package export 15
                ->visit('/exportOptions')
                ->click('@export-button-15')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Methods package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_methods')

                // Initiate an Measurements package export 16
                ->visit('/exportOptions')
                ->click('@export-button-16')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Measurements package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_measurements')

                // Initiate an Measurements package export 17
                ->visit('/exportOptions')
                ->click('@export-button-16')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Measurements package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_measurements')

                // Initiate an Zones package export 17
                ->visit('/exportOptions')
                ->click('@export-button-17')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Zones package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_zones')

                // Initiate an Anomaly package export 18
                ->visit('/exportOptions')
                ->click('@export-button-18')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Anomaly package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_anomaly')

                // Initiate an Pathology package export 19
                ->visit('/exportOptions')
                ->click('@export-button-19')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Pathology package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_pathology')

                // Initiate an Taphonomies package export 20
                ->visit('/exportOptions')
                ->click('@export-button-20')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Taphonomies package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_taphonomies')

                // Initiate an Trauma package export 21
                ->visit('/exportOptions')
                ->click('@export-button-21')
                ->waitForText('File Export started. You will be notified once export is completed',10)
                ->assertPathIs('/exportOptions')

                // Verify the Trauma package export
                //->waitForText('File Export completed. Please check File Manager',30)
                ->visit('/exportFileManager')
                ->assertPathIs('/exportFileManager')
                ->assertSee('uno_cora_demo_trauma')

                ->logoutUser();
        });
    }
}
