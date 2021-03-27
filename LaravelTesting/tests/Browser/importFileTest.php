<?php

namespace Tests\Browser;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\importFilePage;

class importFileTest extends coraBaseTest
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
     * A Dusk test to verify the import criteria options for an report.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportCriteria
     * @group Sprint21
     * @group AuthorKyle
     */
    public function ImportCriteria()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('File')
                ->assertSee('Upload')
                ->click('@import-type-select')
                ->pause(3000)
                // Verify Import Options
                ->assertSee('articulations')
                ->assertSee('pairs')
                ->assertPathIs('/importFile');
        });
    }


    /**
     * A Dusk test to verify the import of an download template when a file type is selected for an report.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportDownload
     * @group AuthorNaveena
     * @group Sprint21
     */
    public function ImportDownload()
    {
        // org admin login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(5000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('File')
                ->assertSee('Upload')

                // Click on the import selector and select the articulations option
                ->click('@import-type-select')
                ->pause(3000)
                ->keys('@import-type-select', '{arrow_down}')
                ->keys('@import-type-select','{enter}')
                ->pause(3000)

                // Verify the user is able to download a file
                ->click('@download-button')
                ->pause(3000)
                ->assertPathIs('/importFile');
        });
    }

    /**
     * A Dusk test to verify the import criteria options for an report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportCriteriaManager
     * @group AuthorKyle
     */
    public function ImportCriteriaManager()
    {
        // Test user login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('File')
                ->assertSee('Upload')
                ->click('@import-type-select')
                ->pause(2000)

                // Verify Import Options
                ->assertSee('articulations')
                ->keys('@import-type-select', '{arrow_down}')
                ->keys('@import-type-select','{enter}')
                ->pause(3000)
                ->assertSee('articulations')
                ->assertPathIs('/importFile');
        });
    }

    /**
     * A Dusk test to verify the import criteria options for an report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportCriteriaOrgAdmin
     * @group AuthorKyle
     */
    public function ImportCriteriaOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')
                ->click('@import-type-select')
                ->pause(1000)

                // Verify Import Options
                ->assertSee('articulations')
                ->select('@import-type-select', '1')
                ->assertSee('articulations')
                ->assertPathIs('/importFile')
                ->logoutUser();
        });
    }

    /**
     * A Dusk test to verify the failed import of an upload when a file type is not selected for an report.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group Sprint21
     * @group ImportUploadFail
     * @group AuthorKyle
     */
    public function ImportUploadFail()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('File')
                ->assertSee('Upload')
                ->pause(3000)
                // Click on the import selector without selecting an option
                ->select('@import-type-select', '')
                ->pause(3000)
                ->attach('@browse-files', resource_path('assets\templates\se_articulation_sample_template.csv'))
                ->pause(3000)

                // Verify the user is unable to upload a file
                ->assertPathIs('/importFile')
                ->assertSee('Upload');
        });
    }

    /**
     * A Dusk test to verify the failed import of an upload when a file type is not selected for an report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportUploadFailManager
     * @group AuthorKyle
     */
    public function ImportUploadFailManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')

                // Click on the import selector without selecting an option
                ->keys('@import-type-select', '{arrow_down}')
                ->keys('@import-type-select', '{enter}')
                ->pause(5000)

                // Verify the user is unable to upload a file
                ->click('@upload-file-button')
                ->assertPathIs('/importFile')
                ->assertSee('Upload File')
                ->logoutUser();
        });
    }

    /**
     * A Dusk test to verify the failed import of an upload when a file type is not selected for an report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportUploadFailOrgAdmin
     * @group AuthorKyle
     */
    public function ImportUploadFailOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')

                // Click on the import selector without selecting an option
                ->keys('@import-type-select', '{arrow_down}')
                ->keys('@import-type-select', '{enter}')
                ->pause(5000)

                // Verify the user is unable to upload a file
                ->click('@upload-file-button')
                ->assertPathIs('/importFile')
                ->assertSee('Upload File')
                ->logoutUser();
        });
    }

    /**
     * A Dusk test to verify the import of an upload when a file type is selected for an report.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportUpload
     * @group AuthorKyle
     */
    public function ImportUpload()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(5000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('File')
                ->assertSee('Upload')

                // Click on the import selector and select the articulation option
                ->click('@import-type-select')
                ->pause(5000)
                ->keys('@import-type-select', '{arrow_down}')
                ->keys('@import-type-select', '{enter}')
                ->pause(5000)
                // Verify the user is able to upload a file
                ->click('@upload-file-button')
                ->pause(5000);

        });
    }

    /**
     * A Dusk test to verify the import of an upload when a file type is selected for an report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportUploadManager
     * @group AuthorKyle
     */
    public function ImportUploadManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')

                // Click on the import selector and select the specimens option
                ->select('@import-type-select', '1')
                ->pause(1000)

                // Verify the user is able to upload a file
                ->click('@upload-file-button')
                ->assertPathIs('/importFile')
                ->waitForText('File Import started. You will receive a notification when import is completed')
                ->assertSee('File Import started. You will receive a notification when import is completed');

            $response = $this->get('/importFile');

            $response->assertStatus(302);

            $browser->visit(new importFilePage)
                ->logoutUser();
        });
    }

    /**
     * A Dusk test to verify the import of an upload when a file type is selected for an report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportUploadOrgAdmin
     * @group AuthorKyle
     * @group Sprint21
     */
    public function ImportUploadOrgAdmin()
    {
        // Test user login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(5000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('File')
                ->assertSee('Upload')

                // Click on the import selector and select the articulation option
                ->click('@import-type-select')
                ->pause(5000)
                ->keys('@import-type-select', '{arrow_down}')
                ->keys('@import-type-select', '{enter}')
                ->pause(3000)
                // Verify the user is able to attach a file
                ->attach('@browse-files', resource_path('assets\templates\se_articulation_sample_template.csv'))
                ->pause(5000)
                // Verify the user is able to upload a file
                ->click('@upload-file-button')
                ->pause(5000);

        });
    }
}
