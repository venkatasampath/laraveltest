<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use App\User;

// 9 Total Test Cases
class reportsTest extends DuskTestCase
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
     * A Dusk test to create an advanced report.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateAdvancedReport
     * @group AuthorKyle
     */
    public function CreateAdvancedReport()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->click('@se-advance-search' )

                /*
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-advanced')
                */
                ->waitForLocation('/showadvanced')
                ->waitForText('Specimens - Advanced Search')

                // Select the criteria for the report
                ->select('#bone','93')
                ->select('#side','Left')
                ->select('#completeness','')
                ->select('#inventoried_by_user','')
                ->select('#reviewed_by_user','')
                ->uncheck('#collapseSE > div > div > div:nth-child(6) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->check('#collapseSE > div > div > div:nth-child(7) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(8) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(9) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(10) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(11) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(12) > div > div > label > input[type="checkbox"]:nth-child(2)')

                // Generate the Report and Verify Results
                ->click('@report-generate')
                ->waitForLocation('/showadvanced/skeletalelements')
                /*
                ->waitForText('Copy')
                ->waitForText('Excel')
                ->waitForText('PDF')
                ->waitForText('Column visibility')
                ->waitForLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                ->waitForLocation('/skeletalelements/1221')
                ->assertPathIs('/skeletalelements/1221')
                */

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create an advanced report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateAdvancedReportManager
     * @group AuthorKyle
     */
    public function CreateAdvancedReportManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->click('@se-advance-search' )

                /*
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-advanced')
                */
                ->waitForLocation('/showadvanced')
                ->waitForText('Specimens - Advanced Search')

                // Select the criteria for the report
                ->select('#bone','93')
                ->select('#side','Left')
                ->select('#completeness','')
                ->select('#inventoried_by_user','')
                ->select('#reviewed_by_user','')
                ->uncheck('#collapseSE > div > div > div:nth-child(6) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->check('#collapseSE > div > div > div:nth-child(7) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(8) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(9) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(10) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(11) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(12) > div > div > label > input[type="checkbox"]:nth-child(2)')

                // Generate the Report and Verify Results
                ->click('@report-generate')
                ->waitForLocation('/showadvanced/skeletalelements')
                /*
                ->waitForText('Copy')
                ->waitForText('Excel')
                ->waitForText('PDF')
                ->waitForText('Column visibility')
                ->waitForLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                ->waitForLocation('/skeletalelements/1221')
                ->assertPathIs('/skeletalelements/1221')
                */

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create an advanced report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateAdvancedReportOrgAdmin
     * @group AuthorKyle
     */
    public function CreateAdvancedReportOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                ->click('@se-advance-search' )

                /*
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-advanced')
                */
                ->waitForLocation('/showadvanced')
                ->waitForText('Specimens - Advanced Search')

                // Select the criteria for the report
                ->select('#bone','93')
                ->select('#side','Left')
                ->select('#completeness','')
                ->select('#inventoried_by_user','')
                ->select('#reviewed_by_user','')
                ->uncheck('#collapseSE > div > div > div:nth-child(6) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->check('#collapseSE > div > div > div:nth-child(7) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(8) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(9) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(10) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(11) > div > div > label > input[type="checkbox"]:nth-child(2)')
                ->uncheck('#collapseSE > div > div > div:nth-child(12) > div > div > label > input[type="checkbox"]:nth-child(2)')

                // Generate the Report and Verify Results
                ->click('@report-generate')
                ->waitForLocation('/showadvanced/skeletalelements')
                /*
                ->waitForText('Copy')
                ->waitForText('Excel')
                ->waitForText('PDF')
                ->waitForText('Column visibility')
                ->waitForLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                ->waitForLocation('/skeletalelements/1221')
                ->assertPathIs('/skeletalelements/1221')
                */

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a mt DNA report.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateDNAReport
     * @group AuthorKyle
     */
    public function CreateDNAReport()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-mt-dna')
                ->waitForLocation('/reports/mtDNA')
                ->waitForText('Mitochondrial DNA - Advanced Report')

                // Select the criteria for the report
                ->select('#mitosequence','333')
                ->select('#mitosequencesubgroup','222')

                // Generate the Report and Verify Results
                ->click('@report-generate')
                ->waitForText('Copy')
                ->waitForText('Excel')
                ->waitForText('PDF')
                ->waitForText('Column visibility')
                ->waitForLink('ABC999-888-777-555')
                ->clickLink('ABC999-888-777-555')
                //->waitForLocation('/skeletalelements/1220')
                //->assertPathIs('/skeletalelements/1220')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a mt DNA report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateDNAReportManager
     * @group AuthorKyle
     */
    public function CreateDNAReportManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-mt-dna')
                ->waitForLocation('/reports/mtDNA')
                ->waitForText('Mitochondrial DNA - Advanced Report')

                // Select the criteria for the report
                ->select('#mitosequence','333')
                ->select('#mitosequencesubgroup','222')

                // Generate the Report and Verify Results
                ->click('@report-generate')
                ->waitForText('Copy')
                ->waitForText('Excel')
                ->waitForText('PDF')
                ->waitForText('Column visibility')
                ->waitForLink('ABC999-888-777-555')
                ->clickLink('ABC999-888-777-555')
                //->waitForLocation('/skeletalelements/1220')
                //->assertPathIs('/skeletalelements/1220')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a mt DNA report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateDNAReportOrgAdmin
     * @group AuthorKyle
     */
    public function CreateDNAReportOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-mt-dna')
                ->waitForLocation('/reports/mtDNA')
                ->waitForText('Mitochondrial DNA - Advanced Report')

                // Select the criteria for the report
                ->select('#mitosequence','333')
                ->select('#mitosequencesubgroup','222')

                // Generate the Report and Verify Results
                ->click('@report-generate')
                ->waitForText('Copy')
                ->waitForText('Excel')
                ->waitForText('PDF')
                ->waitForText('Column visibility')
                ->waitForLink('ABC999-888-777-555')
                ->clickLink('ABC999-888-777-555')
                //->waitForLocation('/skeletalelements/1220')
                //->assertPathIs('/skeletalelements/1220')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a zones report.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateZonesReport
     * @group AuthorKyle
     */
    public function CreateZonesReport()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-zones')
                ->waitForLocation('/reports/zones')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#sb_select','37')
                ->select('#side_select','')
                //->keys('#zone_select','{enter}')
                //->type('#collapseSE > div > div:nth-child(6) > div > span > span.selection > span > ul','1')
                //->assertSee('aefadlkajsdf')
                //->select('#search_type_select','0')


                // Generate the Report and Verify Results
                //->click('#accordion > div > div.card-header > div.float-right > button')
                //#accordion > div > div.card-header > div.float-right > button
                ->pause(5000)
                //->waitForText('Excel')
                //->waitForText('PDF')
                ->assertPathIs('/reports/zones')
                ->pause(5000)
                //->waitForLink('ABC999-888-777-555')
                //->clickLink('ABC999-888-777-555')
                //->waitForLocation('/skeletalelements/1220')
                //s->assertPathIs('/skeletalelements/1220')
                //->assertSee('No Specimen Records found.')
                //->assertSee('Please refine your search')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a zones report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateZonesReportManager
     * @group AuthorKyle
     */
    public function CreateZonesReportManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-zones')
                ->waitForLocation('/reports/zones')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#sb_select','37')
                ->select('#side_select','')
                //->keys('#zone_select','{enter}')
                //->type('#collapseSE > div > div:nth-child(6) > div > span > span.selection > span > ul','1')
                //->assertSee('aefadlkajsdf')
                //->select('#search_type_select','0')


                // Generate the Report and Verify Results
                //->click('#accordion > div > div.card-header > div.float-right > button')
                //#accordion > div > div.card-header > div.float-right > button
                ->pause(5000)
                //->waitForText('Excel')
                //->waitForText('PDF')
                ->assertPathIs('/reports/zones')
                ->pause(5000)
                //->waitForLink('ABC999-888-777-555')
                //->clickLink('ABC999-888-777-555')
                //->waitForLocation('/skeletalelements/1220')
                //s->assertPathIs('/skeletalelements/1220')
                //->assertSee('No Specimen Records found.')
                //->assertSee('Please refine your search')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a zones report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateZonesReportOrgAdmin
     * @group AuthorKyle
     */
    public function CreateZonesReportOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-zones')
                ->waitForLocation('/reports/zones')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#sb_select','37')
                ->select('#side_select','')
                //->keys('#zone_select','{enter}')
                //->type('#collapseSE > div > div:nth-child(6) > div > span > span.selection > span > ul','1')
                //->assertSee('aefadlkajsdf')
                //->select('#search_type_select','0')


                // Generate the Report and Verify Results
                //->click('#accordion > div > div.card-header > div.float-right > button')
                //#accordion > div > div.card-header > div.float-right > button
                ->pause(5000)
                //->waitForText('Excel')
                //->waitForText('PDF')
                ->assertPathIs('/reports/zones')
                ->pause(5000)
                //->waitForLink('ABC999-888-777-555')
                //->clickLink('ABC999-888-777-555')
                //->waitForLocation('/skeletalelements/1220')
                //s->assertPathIs('/skeletalelements/1220')
                //->assertSee('No Specimen Records found.')
                //->assertSee('Please refine your search')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a methods report.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateMethodsReport
     * @group AuthorKyle
     */
    public function CreateMethodsReport()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-methods')
                ->waitForLocation('/reports/methods')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#sb_select','93')
                //->select('#method_type','77')
                //->keys('#accordion > div > div.card-header > div.float-right > button','{enter}','{arrow_down}','{enter}')
                ->pause(1000)
                ->select('#method_select','77')
                ->pause(1000)
                //->select('#method_feature_select','')
                //->select('#score_select','')
                //->select('#range_select','')

                // Generate the Report and Verify Results
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)
                ->pause(1000)

                ->assertPathIs('/reports/methods')
                ->waitForLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                //->waitForLocation('/skeletalelements/1221')
                //->assertPathIs('/skeletalelements/1221')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a methods report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateMethodsReportManager
     * @group AuthorKyle
     */
    public function CreateMethodsReportManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-methods')
                ->waitForLocation('/reports/methods')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#sb_select','93')
                //->select('#method_type','77')
                //->keys('#accordion > div > div.card-header > div.float-right > button','{enter}','{arrow_down}','{enter}')
                ->pause(1000)
                ->select('#method_select','77')
                ->pause(1000)
                //->select('#method_feature_select','')
                //->select('#score_select','')
                //->select('#range_select','')

                // Generate the Report and Verify Results
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)
                ->pause(1000)

                ->assertPathIs('/reports/methods')
                ->waitForLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                //->waitForLocation('/skeletalelements/1221')
                //->assertPathIs('/skeletalelements/1221')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a methods report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateMethodsReportOrgAdmin
     * @group AuthorKyle
     */
    public function CreateMethodsReportOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-methods')
                ->waitForLocation('/reports/methods')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#sb_select','93')
                //->select('#method_type','77')
                //->keys('#accordion > div > div.card-header > div.float-right > button','{enter}','{arrow_down}','{enter}')
                ->pause(1000)
                ->select('#method_select','77')
                ->pause(1000)
                //->select('#method_feature_select','')
                //->select('#score_select','')
                //->select('#range_select','')

                // Generate the Report and Verify Results
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)
                ->pause(1000)

                ->assertPathIs('/reports/methods')
                ->waitForLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                //->waitForLocation('/skeletalelements/1221')
                //->assertPathIs('/skeletalelements/1221')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a measurements report.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateMeasurementsReport
     * @group AuthorKyle
     */
    public function CreateMeasurementsReport()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-measurements')
                ->waitForLocation('/reports/measurements')

                // Select the criteria for the report
                ->select('#sb_select','37')
                ->select('#individual_number_select',' 444')

                // Generate the Report and Verify Results
                ->click('#accordion > div > div.card-headerfloat > div.float-right > button')
                ->pause(1000)
                ->pause(1000)

                ->assertPathIs('/reports/measurements')
                ->waitForLink('ABC999-888-777-555')
                ->clickLink('ABC999-888-777-555')
                //->waitForLocation('/skeletalelements/1220')
                //->assertPathIs('/skeletalelements/1220')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a measurements report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateMeasurementsReportManager
     * @group AuthorKyle
     */
    public function CreateMeasurementsReportManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-measurements')
                ->waitForLocation('/reports/measurements')

                // Select the criteria for the report
                ->select('#sb_select','37')
                ->select('#individual_number_select',' 444')

                // Generate the Report and Verify Results
                ->click('#accordion > div > div.card-headerfloat > div.float-right > button')
                ->pause(1000)
                ->pause(1000)

                ->assertPathIs('/reports/measurements')
                ->waitForLink('ABC999-888-777-555')
                ->clickLink('ABC999-888-777-555')
                //->waitForLocation('/skeletalelements/1220')
                //->assertPathIs('/skeletalelements/1220')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a measurements report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateMeasurementsReportOrgAdmin
     * @group AuthorKyle
     */
    public function CreateMeasurementsReportOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-measurements')
                ->waitForLocation('/reports/measurements')

                // Select the criteria for the report
                ->select('#sb_select','37')
                ->select('#individual_number_select',' 444')

                // Generate the Report and Verify Results
                ->click('#accordion > div > div.card-headerfloat > div.float-right > button')
                ->pause(1000)
                ->pause(1000)

                ->assertPathIs('/reports/measurements')
                ->waitForLink('ABC999-888-777-555')
                ->clickLink('ABC999-888-777-555')
                //->waitForLocation('/skeletalelements/1220')
                //->assertPathIs('/skeletalelements/1220')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a articulations report.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateArticulationsReport
     * @group AuthorKyle
     */
    public function CreateArticulationsReport()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-articulations')
                ->waitForLocation('/reports/articulation')

                // Select the criteria for the report
                ->select('#group_select','Arm')
                ->select('#sb_select','37')
                ->select('#side_select','0')
                ->click('#collapseSE > div.col-lg-12.form-group.se-search > center > button')
                ->pause(1000)

                // Select the specimen to search for articulations
                ->waitForLocation('/reports/articulation/results')
                ->assertPathIs('/reports/articulation/results')
                ->select('#skeletalelement_select','102')
                ->pause(1000)
                ->click('#collapseSE > div.col-lg-12.form-group.se-search > form > center > button')
                ->pause(1000)

                ->waitForLocation('/reports/articulation/finalresults')
                ->assertPathIs('/reports/articulation/finalresults')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a articulations report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateArticulationsReportManager
     * @group AuthorKyle
     */
    public function CreateArticulationsReportManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-articulations')
                ->waitForLocation('/reports/articulation')

                // Select the criteria for the report
                ->select('#group_select','Arm')
                ->select('#sb_select','37')
                ->select('#side_select','0')
                ->click('#collapseSE > div.col-lg-12.form-group.se-search > center > button')
                ->pause(1000)

                // Select the specimen to search for articulations
                ->waitForLocation('/reports/articulation/results')
                ->assertPathIs('/reports/articulation/results')
                ->select('#skeletalelement_select','102')
                ->pause(1000)
                ->click('#collapseSE > div.col-lg-12.form-group.se-search > form > center > button')
                ->pause(1000)

                ->waitForLocation('/reports/articulation/finalresults')
                ->assertPathIs('/reports/articulation/finalresults')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a articulations report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateArticulationsReportOrgAdmin
     * @group AuthorKyle
     */
    public function CreateArticulationsReportOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-articulations')
                ->waitForLocation('/reports/articulation')

                // Select the criteria for the report
                ->select('#group_select','Arm')
                ->select('#sb_select','37')
                ->select('#side_select','0')
                ->click('#collapseSE > div.col-lg-12.form-group.se-search > center > button')
                ->pause(1000)

                // Select the specimen to search for articulations
                ->waitForLocation('/reports/articulation/results')
                ->assertPathIs('/reports/articulation/results')
                ->select('#skeletalelement_select','102')
                ->pause(1000)
                ->click('#collapseSE > div.col-lg-12.form-group.se-search > form > center > button')
                ->pause(1000)

                ->waitForLocation('/reports/articulation/finalresults')
                ->assertPathIs('/reports/articulation/finalresults')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create an individual number report.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateIndividualNumberReport
     * @group AuthorKyle
     */
    public function CreateIndividualNumberReport()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-individual-number')
                ->waitForLocation('/reports/individualnumber')

                // Select the criteria for the report
                ->select('#individual_number_select','444')
                ->select('#sb_select','37')
                ->select('#side_select','Left')
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->waitForLocation('/reports/individualnumber')
                ->assertPathIs('/reports/individualnumber')
                ->assertSeeLink('ABC999-888-777-555')
                ->clickLink('ABC999-888-777-555')

                ->pause(1000)
                ->pause(1000)

                //->waitForLocation('/skeletalelements/1220')
                //->assertPathIs('/skeletalelements/1220')
                //->assertSee('View Specimen - ABC999-888-777-555')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create an individual number report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateIndividualNumberReportManager
     * @group AuthorKyle
     */
    public function CreateIndividualNumberReportManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-individual-number')
                ->waitForLocation('/reports/individualnumber')

                // Select the criteria for the report
                ->select('#individual_number_select','444')
                ->select('#sb_select','37')
                ->select('#side_select','Left')
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->waitForLocation('/reports/individualnumber')
                ->assertPathIs('/reports/individualnumber')
                ->assertSeeLink('ABC999-888-777-555')
                ->clickLink('ABC999-888-777-555')

                ->pause(1000)
                ->pause(1000)

                //->waitForLocation('/skeletalelements/1220')
                //->assertPathIs('/skeletalelements/1220')
                //->assertSee('View Specimen - ABC999-888-777-555')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create an individual number report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateIndividualNumberReportOrgAdmin
     * @group AuthorKyle
     */
    public function CreateIndividualNumberReportOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)
                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-individual-number')
                ->waitForLocation('/reports/individualnumber')

                // Select the criteria for the report
                ->select('#individual_number_select','444')
                ->select('#sb_select','37')
                ->select('#side_select','Left')
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->waitForLocation('/reports/individualnumber')
                ->assertPathIs('/reports/individualnumber')
                ->assertSeeLink('ABC999-888-777-555')
                ->clickLink('ABC999-888-777-555')

                ->pause(1000)
                ->pause(1000)

                //->waitForLocation('/skeletalelements/1220')
                //->assertPathIs('/skeletalelements/1220')
                //->assertSee('View Specimen - ABC999-888-777-555')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a trauma report.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateTraumaReport
     * @group AuthorKyle
     */
    public function CreateTraumaReport()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)

                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-trauma')
                ->waitForLocation('/reports/traumas')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#trauma_select','1')
                ->pause(1000)
                ->select('#sb_select','93')
                ->pause(1000)
                ->select('#side_select','Left')
                ->pause(1000)
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->waitForLocation('/reports/traumas')
                ->assertPathIs('/reports/traumas')
                ->assertSeeLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                ->pause(1000)
                ->waitForLocation('/skeletalelements/1221')
                ->assertPathIs('/skeletalelements/1221')
                ->assertSee('View Specimen - ABC999-888-777-556')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a trauma report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateTraumaReportManager
     * @group AuthorKyle
     */
    public function CreateTraumaReportManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)

                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-trauma')
                ->waitForLocation('/reports/traumas')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#trauma_select','1')
                ->pause(1000)
                ->select('#sb_select','93')
                ->pause(1000)
                ->select('#side_select','Left')
                ->pause(1000)
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->waitForLocation('/reports/traumas')
                ->assertPathIs('/reports/traumas')
                ->assertSeeLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                ->pause(1000)
                //->waitForLocation('/skeletalelements/1221')
                //->assertPathIs('/skeletalelements/1221')
                //->assertSee('View Specimen - ABC999-888-777-556')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a trauma report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateTraumaReportOrgAdmin
     * @group AuthorKyle
     */
    public function CreateTraumaReportOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)

                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-trauma')
                ->waitForLocation('/reports/traumas')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#trauma_select','1')
                ->pause(1000)
                ->select('#sb_select','93')
                ->pause(1000)
                ->select('#side_select','Left')
                ->pause(1000)
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->waitForLocation('/reports/traumas')
                ->assertPathIs('/reports/traumas')
                ->assertSeeLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                ->pause(1000)
                //->waitForLocation('/skeletalelements/1221')
                //->assertPathIs('/skeletalelements/1221')
                //->assertSee('View Specimen - ABC999-888-777-556')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create an anomaly report.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateAnomalyReport
     * @group AuthorKyle
     */
    public function CreateAnomalyReport()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)

                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-anomaly')
                ->waitForLocation('/reports/anomaly')

                // Select the criteria for the report
                ->select('#anomaly_select','Metopism')
                ->pause(1000)
                ->select('#sb_select','37')
                ->pause(1000)
                ->select('#side_select','Left')
                ->pause(1000)
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->assertSee('Anomaly Report')
                ->assertSee('No Specimen Records found. Please refine your search')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create an anomaly report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateAnomalyReportManager
     * @group AuthorKyle
     */
    public function CreateAnomalyReportManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)

                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-anomaly')
                ->waitForLocation('/reports/anomaly')

                // Select the criteria for the report
                ->select('#anomaly_select','Metopism')
                ->pause(1000)
                ->select('#sb_select','37')
                ->pause(1000)
                ->select('#side_select','Left')
                ->pause(1000)
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->assertSee('Anomaly Report')
                ->assertSee('No Specimen Records found. Please refine your search')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create an anomaly report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreateAnomalyReportOrgAdmin
     * @group AuthorKyle
     */
    public function CreateAnomalyReportOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)

                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-anomaly')
                ->waitForLocation('/reports/anomaly')

                // Select the criteria for the report
                ->select('#anomaly_select','Metopism')
                ->pause(1000)
                ->select('#sb_select','37')
                ->pause(1000)
                ->select('#side_select','Left')
                ->pause(1000)
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->assertSee('Anomaly Report')
                ->assertSee('No Specimen Records found. Please refine your search')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a pathology report.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreatePathologyReport
     * @group AuthorKyle
     */
    public function CreatePathologyReport()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)

                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-pathology')
                ->waitForLocation('/reports/pathologys')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#pathology_select','1')
                ->pause(1000)
                ->select('#sb_select','93')
                ->pause(1000)
                ->select('#side_select','Left')
                ->pause(1000)
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->waitForLocation('/reports/pathologys')
                ->assertPathIs('/reports/pathologys')
                ->assertSeeLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                ->pause(1000)
                //->waitForLocation('/skeletalelements/1221')
                //->assertPathIs('/skeletalelements/1221')
                //->assertSee('View Specimen - ABC999-888-777-556')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a pathology report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreatePathologyReportManager
     * @group AuthorKyle
     */
    public function CreatePathologyReportManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)

                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-pathology')
                ->waitForLocation('/reports/pathologys')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#pathology_select','1')
                ->pause(1000)
                ->select('#sb_select','93')
                ->pause(1000)
                ->select('#side_select','Left')
                ->pause(1000)
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->waitForLocation('/reports/pathologys')
                ->assertPathIs('/reports/pathologys')
                ->assertSeeLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                ->pause(1000)
                //->waitForLocation('/skeletalelements/1221')
                //->assertPathIs('/skeletalelements/1221')
                //->assertSee('View Specimen - ABC999-888-777-556')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to create a pathology report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Reports
     * @group UNO
     * @group CreatePathologyReportOrgAdmin
     * @group AuthorKyle
     */
    public function CreatePathologyReportOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Skeletal elements search set up
            $browser->visit(new specimenPage)
                ->pause(1000)
                ->press('@se-menu')
                ->pause(1000)

                // Click Reports Dashboard
                ->click('@se-reports-dashboard')
                ->pause(1000)
                ->assertPathIs('/reports/dashboard')
                ->assertSee('Reports Dashboard')

                ->click('@report-go-pathology')
                ->waitForLocation('/reports/pathologys')

                // Select the criteria for the report
                ->select('#an_select','ABC999')
                ->select('#pathology_select','1')
                ->pause(1000)
                ->select('#sb_select','93')
                ->pause(1000)
                ->select('#side_select','Left')
                ->pause(1000)
                ->click('#accordion > div > div.card-header > div.float-right > button')
                ->pause(1000)

                // Verify the results of the report
                ->waitForLocation('/reports/pathologys')
                ->assertPathIs('/reports/pathologys')
                ->assertSeeLink('ABC999-888-777-556')
                ->clickLink('ABC999-888-777-556')
                ->pause(1000)
                //->waitForLocation('/skeletalelements/1221')
                //->assertPathIs('/skeletalelements/1221')
                //->assertSee('View Specimen - ABC999-888-777-556')

                ->logoutUser();
        });
    }
}
