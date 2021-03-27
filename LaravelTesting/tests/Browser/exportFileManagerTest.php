<?php

/**
 * ExportFileManagerTest DuskTestCase
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
use Tests\Browser\Pages\exportFileManagerPage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\UploadedFileStub;



// 2 Total Test Cases
class exportFileManagerTest extends coraBaseTest
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
     * A Dusk test to verify the details function of a file manager report.
     *
     * @return void
     * @throws
     * @test
     * @group ExportFileManager
     * @group UNO2
     * @group ExportDetails
     * @group AuthorKyle
     * @group ExporFileManager
     * @group Sprint21
     */
    public function ExporFileManager()
    {

        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Export File Manager set up
            $browser->visit(new exportFileManagerPage)
                ->assertPathIs('/exportFileManager')
                ->assertSee('File Manager')
                ->assertSee('Export')
                ->assertSee('Actions');
        });
    }

    public function ExportDetails()
    {

        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Export File Manager set up
            $browser->visit(new exportFileManagerPage)
                ->assertPathIs('/exportFileManager')
                ->assertSee('File Manager')
                ->assertSee('Exports')
                ->assertSee('Actions')

                // Verify details button 1 functions as expected
                ->click('@details-button-1')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 2 functions as expected
                ->click('@details-button-2')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 3 functions as expected
                ->click('@details-button-3')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 4 functions as expected
                ->click('@details-button-4')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 5 functions as expected
                ->click('@details-button-5')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 6 functions as expected
                ->click('@details-button-6')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 7 functions as expected
                ->click('@details-button-7')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 8 functions as expected
                ->click('@details-button-8')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 9 functions as expected
                ->click('@details-button-9')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 10 functions as expected
                ->click('@details-button-10')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 11 functions as expected
                ->click('@details-button-11')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 12 functions as expected
                ->click('@details-button-12')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 13 functions as expected
                ->click('@details-button-13')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 14 functions as expected
                ->click('@details-button-14')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 15 functions as expected
                ->click('@details-button-15')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 16 functions as expected
                ->click('@details-button-16')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the details function of a file manager report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ExportFileManager
     * @group UNO2
     * @group ExportDetailsManager
     * @group AuthorKyle
     */
    public function ExportDetailsManager()
    {

        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Export File Manager set up
            $browser->visit(new exportFileManagerPage)
                ->assertPathIs('/exportFileManager')
                ->assertSee('File Manager')
                ->assertSee('Exports')
                ->assertSee('Actions')

                // Verify details button 1 functions as expected
                ->click('@details-button-1')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 2 functions as expected
                ->click('@details-button-2')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 3 functions as expected
                ->click('@details-button-3')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 4 functions as expected
                ->click('@details-button-4')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 5 functions as expected
                ->click('@details-button-5')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 6 functions as expected
                ->click('@details-button-6')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 7 functions as expected
                ->click('@details-button-7')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 8 functions as expected
                ->click('@details-button-8')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 9 functions as expected
                ->click('@details-button-9')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 10 functions as expected
                ->click('@details-button-10')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 11 functions as expected
                ->click('@details-button-11')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 12 functions as expected
                ->click('@details-button-12')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 13 functions as expected
                ->click('@details-button-13')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 14 functions as expected
                ->click('@details-button-14')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 15 functions as expected
                ->click('@details-button-15')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 16 functions as expected
                ->click('@details-button-16')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the details function of a file manager report for an org admin
     *
     * @return void
     * @throws
     * @test
     * @group ExportFileManager
     * @group UNO2
     * @group ExportDetailsOrgAdmin
     * @group AuthorKyle
     */
    public function ExportDetailsOrgAdmin()
    {

        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Export File Manager set up
            $browser->visit(new exportFileManagerPage)
                ->assertPathIs('/exportFileManager')
                ->assertSee('File Manager')
                ->assertSee('Exports')
                ->assertSee('Actions')

                // Verify details button 1 functions as expected
                ->click('@details-button-1')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 2 functions as expected
                ->click('@details-button-2')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 3 functions as expected
                ->click('@details-button-3')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 4 functions as expected
                ->click('@details-button-4')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 5 functions as expected
                ->click('@details-button-5')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 6 functions as expected
                ->click('@details-button-6')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 7 functions as expected
                ->click('@details-button-7')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 8 functions as expected
                ->click('@details-button-8')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 9 functions as expected
                ->click('@details-button-9')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 10 functions as expected
                ->click('@details-button-10')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 11 functions as expected
                ->click('@details-button-11')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 12 functions as expected
                ->click('@details-button-12')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 13 functions as expected
                ->click('@details-button-13')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 14 functions as expected
                ->click('@details-button-14')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 15 functions as expected
                ->click('@details-button-15')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                // Verify details button 16 functions as expected
                ->click('@details-button-16')
                ->assertPathBeginsWith('/exportFileManager/view/')
                ->assertSee('Exported Files')
                ->assertSee('Actions')
                ->assertVisible('@download-button-1')
                ->visit('/exportFileManager')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the download function of a file manager report.
     *
     * @return void
     * @throws
     * @test
     * @group ExportFileManager
     * @group UNO2
     * @group ExportFileDownload
     * @group AuthorKyle
     */
    public function ExportDownload()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Export File Manager set up
            $browser->visit(new exportFileManagerPage)
                ->assertPathIs('/exportFileManager')
                ->assertSee('File Manager')
                ->assertSee('Exports')
                ->assertSee('Actions')
                ->click('@download-button-4')

                // BUG IN LINE 251
                ->assertSee('FAIL');

            $response = $this->get('/exportFileManager');

            $response->assertStatus(302);

            $browser->visit(new exportFileManagerPage)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the download function of a file manager report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group ExportFileManager
     * @group UNO2
     * @group ExportFileDownloadManager
     * @group AuthorKyle
     */
    public function ExportDownloadManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Export File Manager set up
            $browser->visit(new exportFileManagerPage)
                ->assertPathIs('/exportFileManager')
                ->assertSee('File Manager')
                ->assertSee('Exports')
                ->assertSee('Actions')
                ->click('@download-button-4')

                // BUG IN LINE 251
                ->assertSee('FAIL');

            $response = $this->get('/exportFileManager');

            $response->assertStatus(302);

            $browser->visit(new exportFileManagerPage)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the download function of a file manager report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group ExportFileManager
     * @group UNO2
     * @group ExportFileDownloadOrgAdmin
     * @group AuthorKyle
     */
    public function ExportDownloadOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Export File Manager set up
            $browser->visit(new exportFileManagerPage)
                ->assertPathIs('/exportFileManager')
                ->assertSee('File Manager')
                ->assertSee('Exports')
                ->assertSee('Actions')
                ->click('@download-button-4')

                // BUG IN LINE 251
                ->assertSee('FAIL');

            $response = $this->get('/exportFileManager');

            $response->assertStatus(302);

            $browser->visit(new exportFileManagerPage)
                ->logoutUser();
        });
    }
}
