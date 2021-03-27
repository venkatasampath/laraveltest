<?php

/**
 * DashboardTest DuskTestCase
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
use Tests\Browser\Pages\homePage;
use App\User;

// 6 Total Test Cases
class dashboardTest extends coraBaseTest
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
     * A Dusk test to refresh the home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group RefreshDashboard
     * @group AuthorKyle
     */
    public function RefreshDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->assertDontSee('User Profile successfully updated')
                ->click('@refresh-dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to refresh the home dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group RefreshDashboardManager
     * @group AuthorKyle
     */
    public function RefreshDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->assertDontSee('User Profile successfully updated')
                ->click('@refresh-dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to refresh the home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group RefreshDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function RefreshDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->assertDontSee('User Profile successfully updated')
                ->click('@refresh-dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to click through the welcome popup on the home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group WelcomeDashboard
     * @group AuthorKyle
     */
    public function WelcomeDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@cora-home')
                ->assertSee('Welcome to CoRA - Commingled Remains Analytics')
                ->assertPathIs('/')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to click through the welcome popup on the home dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group WelcomeDashboardManager
     * @group AuthorKyle
     */
    public function WelcomeDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@cora-home')
                ->assertSee('Welcome to CoRA - Commingled Remains Analytics')
                ->assertPathIs('/')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to click through the welcome popup on the home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group WelcomeDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function WelcomeDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@cora-home')
                ->assertSee('Welcome to CoRA - Commingled Remains Analytics')
                ->assertPathIs('/')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CollapseDashboard
     * @group AuthorKyle
     */
    public function CollapseDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CollapseDashboardManager
     * @group AuthorKyle
     */
    public function CollapseDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CollapseDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function CollapseDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Navigate to the data populated CoRA 2 Demo Dashboard
                ->visit('/projectDashboard/1')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ExpandDashboard
     * @group AuthorKyle
     */
    public function ExpandDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Expand Dashboard
                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ExpandDashboardManager
     * @group AuthorKyle
     */
    public function ExpandDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Expand Dashboard
                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ExpandDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function ExpandDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Navigate to the data populated CoRA 2 Demo Dashboard
                ->visit('/projectDashboard/1')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Expand Dashboard
                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to customize the home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CustomizeDashboard
     * @group AuthorKyle
     */
    public function CustomizeDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Open the Customize Widget Visibility Window
                ->click('@customize-widget-visibility')
                ->assertPathIs('/dashboard')

                // Uncheck All Charts
                ->pause(1000)
                ->uncheck('@inventory')
                ->pause(1000)
                ->uncheck('@complete')
                ->pause(1000)
                ->uncheck('@skeletal-elements')
                ->pause(1000)
                ->uncheck('@dna-sampled')
                ->pause(1000)
                ->uncheck('@mito-sequences')
                ->pause(1000)
                ->uncheck('@mni-zones-side')
                ->pause(1000)
                ->uncheck('@mni-bones-side')
                ->pause(1000)
                ->uncheck('@mito-bones-side')
                ->pause(1000)
                ->click('@customize-widget-visibility')
                ->pause(1000)

                // Assert All Charts are no longer visible
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/dashboard')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to customize the home dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CustomizeDashboardManager
     * @group AuthorKyle
     */
    public function CustomizeDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Open the Customize Widget Visibility Window
                ->click('@customize-widget-visibility')
                ->assertPathIs('/dashboard')

                // Uncheck All Charts
                ->pause(1000)
                ->uncheck('@inventory')
                ->pause(1000)
                ->uncheck('@complete')
                ->pause(1000)
                ->uncheck('@skeletal-elements')
                ->pause(1000)
                ->uncheck('@dna-sampled')
                ->pause(1000)
                ->uncheck('@mito-sequences')
                ->pause(1000)
                ->uncheck('@mni-zones-side')
                ->pause(1000)
                ->uncheck('@mni-bones-side')
                ->pause(1000)
                ->uncheck('@mito-bones-side')
                ->pause(1000)
                ->click('@customize-widget-visibility')
                ->pause(1000)

                // Assert All Charts are no longer visible
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/dashboard')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to customize the home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CustomizeDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function CustomizeDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Navigate to the data populated CoRA 2 Demo Dashboard
                ->visit('/projectDashboard/1')

                // Open the Customize Widget Visibility Window
                ->click('@customize-widget-visibility')
                ->assertPathIs('/projectDashboard/1')

                // Uncheck All Charts
                ->pause(1000)
                ->uncheck('@inventory')
                ->pause(1000)
                ->uncheck('@complete')
                ->pause(1000)
                ->uncheck('@skeletal-elements')
                ->pause(1000)
                ->uncheck('@dna-sampled')
                ->pause(1000)
                ->uncheck('@mito-sequences')
                ->pause(1000)
                ->uncheck('@mni-zones-side')
                ->pause(1000)
                ->uncheck('@mni-bones-side')
                ->pause(1000)
                ->uncheck('@mito-bones-side')
                ->pause(1000)
                ->click('@customize-widget-visibility')
                ->pause(1000)

                // Assert All Charts are no longer visible
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/projectDashboard/1')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to close the individual sections of the home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CloseDashboard
     * @group AuthorKyle
     */
    public function CloseDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Close All Charts
                ->click('@inventory-close')
                ->pause(1000)
                ->click('@mito-bones-side-close')
                ->pause(1000)
                ->click('@mni-zones-side-close')
                ->pause(1000)
                ->click('@mni-bones-close')
                ->pause(1000)
                ->click('@mito-sequences-close')
                ->pause(1000)
                ->click('@dna-sampled-close')
                ->pause(1000)
                ->click('@skeletal-elements-close')
                ->pause(1000)
                ->click('@complete-close')
                ->pause(1000)

                // Assert All Charts are closed
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/dashboard')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to close the individual sections of the home dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CloseDashboardManager
     * @group AuthorKyle
     */
    public function CloseDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Close All Charts
                ->click('@inventory-close')
                ->pause(1000)
                ->click('@mito-bones-side-close')
                ->pause(1000)
                ->click('@mni-zones-side-close')
                ->pause(1000)
                ->click('@mni-bones-close')
                ->pause(1000)
                ->click('@mito-sequences-close')
                ->pause(1000)
                ->click('@dna-sampled-close')
                ->pause(1000)
                ->click('@skeletal-elements-close')
                ->pause(1000)
                ->click('@complete-close')
                ->pause(1000)

                // Assert All Charts are closed
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/dashboard')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to close the individual sections of the home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CloseDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function CloseDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Navigate to the data populated CoRA 2 Demo Dashboard
                ->visit('/projectDashboard/1')

                // Close All Charts
                ->click('@inventory-close')
                ->pause(1000)
                ->click('@mito-bones-side-close')
                ->pause(1000)
                ->click('@mni-zones-side-close')
                ->pause(1000)
                ->click('@mni-bones-close')
                ->pause(1000)
                ->click('@mito-sequences-close')
                ->pause(1000)
                ->click('@dna-sampled-close')
                ->pause(1000)
                ->click('@skeletal-elements-close')
                ->pause(1000)
                ->click('@complete-close')
                ->pause(1000)

                // Assert All Charts are closed
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/projectDashboard/1')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to test the Org Admin dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group OrgAdminDashboard
     * @group AuthorJohn
     */
    public function OrgAdminDashboard()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Org Admin Dashboard')
                ->assertPathIs('/dashboard')
                ->assertSee('All Projects')
                ->assertSee('DNA Summary')
                ->assertSee('Skeletal Summary')
                ->assertSee('CoRA Demo')
                ->click('@top_DNA_project')
                ->assertPathBeginsWith('/projectDashboard/')
                ->assertSee('Dashboard')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard');

            //scroll page down to view Specimens project table
            $browser->driver->executeScript('window.scrollTo(0, 500);');

            $browser
                ->click('@top_SE_project')
                ->assertPathBeginsWith('/projectDashboard/')
                ->assertSee('Dashboard')
                ->logoutUser();
        });
    }
     /**
     * A Dusk test to refresh the home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group SidebarCollapse
     * @group AuthorKyle
     */
    public function SidebarCollapse()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Open Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Specimens and Verify Menu Options
                ->click('@se-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open DNA and Verify Menu Options
                ->click('@dna-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Reports and Verify Menu Options
                ->click('@reports')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Close the Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to refresh the home dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group SidebarCollapseManager
     * @group AuthorKyle
     */
    public function SidebarCollapseManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Open Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Specimens and Verify Menu Options
                ->click('@se-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open DNA and Verify Menu Options
                ->click('@dna-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Reports and Verify Menu Options
                ->click('@reports')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Close the Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to refresh the home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group SidebarCollapseOrgAdmin
     * @group AuthorKyle
     */
    public function SidebarCollapseOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Open Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Specimens and Verify Menu Options
                ->click('@se-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open DNA and Verify Menu Options
                ->click('@dna-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Reports and Verify Menu Options
                ->click('@reports')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Close the Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the project switcher on home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ProjectSwitcher
     * @group AuthorKyle
     */
    public function ProjectSwitcher()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Change the Project Tarawa
                ->select('@cora-project-switcher','27')
                ->click('@cora-project-switcher-button')
                ->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','27')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Change the Project back to CoRA Demo
                ->select('@cora-project-switcher','1')
                ->click('@cora-project-switcher-button')
                ->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','1')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the project switcher on home dashboard for a manager
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ProjectSwitcherManager
     * @group AuthorKyle
     */
    public function ProjectSwitcherManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Change the Project Tarawa
                /*
                ->select('@cora-project-switcher','27')
                ->click('@cora-project-switcher-button')
                ->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','27')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                */

                // Change the Project back to CoRA Demo
                ->select('@cora-project-switcher','1')
                ->click('@cora-project-switcher-button')
                //->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','1')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the project switcher on home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ProjectSwitcherOrgAdmin
     * @group AuthorKyle
     */
    public function ProjectSwitcherOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Navigate to the data populated CoRA 2 Demo Dashboard
                ->visit('/projectDashboard/1')

                // Change the Project Hamburger Hill
                ->select('@cora-project-switcher','32')
                ->click('@cora-project-switcher-button')
                ->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','32')
                ->assertSee('Dashboard')
                ->assertPathIs('/projectDashboard/1')

                // Change the Project back to CoRA Demo
                ->select('@cora-project-switcher','1')
                ->click('@cora-project-switcher-button')
                ->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','1')
                ->assertSee('Dashboard')
                ->assertPathIs('/projectDashboard/1')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test for each of the drilldown buttons on the project dashboard
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group Drilldowns
     * @group AuthorJohn
     */
    public function Drilldowns()
    {
        //local machine is very slow comment out or remove pauses to increase testing times
        // Org Admin has different privileges and can see more this test is looking for all possible dusk elements.
        // Test User login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->pause(30000)
                ->loginUser($user['email'], $user['password'])
                ->pause(30000)
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            //visit home page
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->pause(30000)

                //open navigation bar and click on dashboard
                ->click('@leftSideBar-menu')
                ->click('@Dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                //Wait for widgets to load
                ->pause(90000)

                //Test to see if projects are available.
                //Specimen Summary table
                ->assertVisible('@specimen-summary-buna')
                ->assertVisible('@specimen-summary-cabanatuan')
                ->assertVisible('@specimen-summary-castelfiorentino')
                ->assertVisible('@specimen_summary-enoura maru')
                ->assertVisible('@specimen_summary-hürtgen forest')
                ->assertVisible('@specimen_summary-kwp')
                ->assertVisible('@specimen_summary-market garden')
                ->assertVisible('@specimen_summary-ploesti')
                ->assertVisible('@specimen_summary-solomon islands')
                ->assertVisible('@specimen_summary-southeast asia')
                ->assertVisible('@specimen_summary-tarawa')
                ->assertVisible('@specimen_summary-uss arizona')
                ->assertVisible('@specimen_summary-uss california')
                ->assertVisible('@specimen_summary-uss nevada')
                ->assertVisible('@specimen_summary-uss oklahoma')
                ->assertVisible('@specimen_summary-uss west virginia')
                ->assertVisible('@specimen_summary-wake island')

                //DNA Summary table
                ->assertVisible('@dna-summary-buna')
                ->assertVisible('@dna-summary-cabanatuan')
                ->assertVisible('@dna-summary-castelfiorentino')
                ->assertVisible('@dna_summary-enoura maru')
                ->assertVisible('@dna_summary-hürtgen forest')
                ->assertVisible('@dna_summary-kwp')
                ->assertVisible('@dna_summary-market garden')
                ->assertVisible('@dna_summary-ploesti')
                ->assertVisible('@dna_summary-solomon islands')
                ->assertVisible('@dna_summary-southeast asia')
                ->assertVisible('@dna_summary-tarawa')
                ->assertVisible('@dna_summary-uss arizona')
                ->assertVisible('@dna_summary-uss california')
                ->assertVisible('@dna_summary-uss nevada')
                ->assertVisible('@dna_summary-uss oklahoma')
                ->assertVisible('@dna_summary-uss west virginia')
                ->assertVisible('@dna_summary-wake island');

            // Click one project drill down to see if elements exist.
            // Projects that don't exist will generate sql error. We know Project Buna Exists.

            //Test Buna
            $browser->click('@dna-summary-buna');

            //Drill down opens in a new window. Switch to new tab.
            $window = collect($browser->driver->getWindowHandles())->last();
            $browser->driver->switchTo()->window($window);
            $browser->assertPathIs('/projectDashboard/12')
            //wait for widgets to load
            ->pause(120000);

            //Check if widgets have loaded
                // Pie Charts
            $browser->assertVisible('@pie-complete-size')
                ->assertVisible('@pie-complete-donut')
                ->assertVisible('@pie-complete-collapse')
                ->assertVisible('@pie-complete-close')
                ->assertVisible('@pie-complete-details');

            $browser->assertVisible('@pie-individual-assigned-size')
                ->assertVisible('@pie-individual-assigned-donut')
                ->assertVisible('@pie-individual-assigned-collapse')
                ->assertVisible('@pie-individual-assigned-close')
                ->assertVisible('@pie-individual-assigned-details');

            $browser->assertVisible('@pie-dna-sampled-size')
                ->assertVisible('@pie-dna-sampled-donut')
                ->assertVisible('@pie-dna-sampled-collapse')
                ->assertVisible('@pie-dna-sampled-close')
                ->assertVisible('@pie-dna-sampled-details');

            $browser->assertVisible('@pie-dna-mito-results-size')
                ->assertVisible('@pie-dna-mito-results-donut')
                ->assertVisible('@pie-dna-mito-results-collapse')
                ->assertVisible('@pie-dna-mito-results-close')
                ->assertVisible('@pie-dna-mito-results-details');

            $browser->assertVisible('@pie-dna-ystr-results-size')
                ->assertVisible('@pie-dna-ystr-results-donut')
                ->assertVisible('@pie-dna-ystr-results-collapse')
                ->assertVisible('@pie-dna-ystr-results-close')
                ->assertVisible('@pie-dna-ystr-results-details');

            $browser->assertVisible('@pie-dna-austr-results-size')
                ->assertVisible('@pie-dna-austr-results-donut')
                ->assertVisible('@pie-dna-austr-results-collapse')
                ->assertVisible('@pie-dna-austr-results-close')
                ->assertVisible('@pie-dna-austr-results-details');

            $browser->assertVisible('@pie-measured-size')
                ->assertVisible('@pie-measured-donut')
                ->assertVisible('@pie-measured-collapse')
                ->assertVisible('@pie-measured-close')
                ->assertVisible('@pie-measured-details');

            $browser->assertVisible('@pie-ct-scanned-size')
                ->assertVisible('@pie-ct-scanned-donut')
                ->assertVisible('@pie-ct-scanned-collapse')
                ->assertVisible('@pie-ct-scanned-close')
                ->assertVisible('@pie-ct-scanned-details');

            $browser->assertVisible('@pie-xray-scanned-size')
                ->assertVisible('@pie-xray-scanned-donut')
                ->assertVisible('@pie-xray-scanned-collapse')
                ->assertVisible('@pie-xray-scanned-close')
                ->assertVisible('@pie-xray-scanned-details');

            $browser->assertVisible('@pie-clavicle-triangle-size')
                ->assertVisible('@pie-clavicle-triangle-donut')
                ->assertVisible('@pie-clavicle-triangle-collapse')
                ->assertVisible('@pie-clavicle-triangle-close')
                ->assertVisible('@pie-clavicle-triangle-details');

            $browser->assertVisible('@pie-isotope-sampled-size')
                ->assertVisible('@pie-isotope-sampled-donut')
                ->assertVisible('@pie-isotope-sampled-collapse')
                ->assertVisible('@pie-isotope-sampled-close')
                ->assertVisible('@pie-isotope-sampled-details');

                     //Bar Charts
            $browser->assertVisible('@bar-mito-sequences-collapse')
                ->assertVisible('@bar-mito-sequences-close')
                ->assertVisible('@bar-mito-sequences-details');

            $browser->assertVisible('@bar-frequency-bones-collapse')
                ->assertVisible('@bar-frequency-bones-close')
                ->assertVisible('@bar-frequency-bones-details');


            $browser->assertVisible('@bar-frequency-zones-collapse')
                ->assertVisible('@bar-frequency-zones-close')
                ->assertVisible('@bar-frequency-zones-details');

                     //Stacked Bar Charts
            $browser->assertVisible('@stacked-bar-mni-mito-bones-side-collapse')
                ->assertVisible('@stacked-bar-mni-mito-bones-side-close')
                ->assertVisible('@stacked-bar-mni-mito-bones-side-details');

            $browser->assertVisible('@stacked-bar-mni-bones-side-collapse')
                ->assertVisible('@stacked-bar-mni-bones-side-close')
                ->assertVisible('@stacked-bar-mni-bones-side-details');

            $browser->assertVisible('@stacked-bar-frequency-zones-side-collapse')
                ->assertVisible('@stacked-bar-frequency-zones-side-close')
                ->assertVisible('@stacked-bar-frequency-zones-side-details');

                     //Line Chart
            $browser->assertVisible('@line-specimens-collapse')
                ->assertVisible('@line-specimens-close')
                ->assertVisible('@line-specimens-details');

            $browser->assertVisible('@line-dnas-collapse')
                ->assertVisible('@line-dnas-close')
                ->assertVisible('@line-dnas-details');
        });
    }
    /**
     * A Dusk test for each of the drilldown buttons on the project dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group DrilldownsManager
     * @group AuthorJohn
     */
    public function DrilldownsManager()
    {
        //local machine is very slow comment out or remove pauses to increase testing times
        // Org manager dashboard is different than org admin.
        // Test User login
        $user = $this->testAccounts["org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->pause(30000)
                ->loginUser($user['email'], $user['password'])
                ->pause(30000)
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            //visit home page
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->pause(30000)

                //open navigation bar and click on dashboard
                ->click('@leftSideBar-menu')
                ->click('@Dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                //Wait for widgets to load
                ->pause(90000);

            // Testing each drilldown button
            // Pie Charts
            $browser->click('@pie-complete-size')
                ->click('@pie-complete-donut')
                ->click('@pie-complete-collapse')
                ->click('@pie-complete-close');

            $browser->click('@pie-individual-assigned-size')
                ->click('@pie-individual-assigned-donut')
                ->click('@pie-individual-assigned-collapse')
                ->click('@pie-individual-assigned-close');

            $browser->click('@pie-dna-sampled-size')
                ->click('@pie-dna-sampled-donut')
                ->click('@pie-dna-sampled-collapse')
                ->click('@pie-dna-sampled-close');

            $browser->click('@pie-dna-mito-results-size')
                ->click('@pie-dna-mito-results-donut')
                ->click('@pie-dna-mito-results-collapse')
                ->click('@pie-dna-mito-results-close');

            $browser->click('@pie-dna-ystr-results-size')
                ->click('@pie-dna-ystr-results-donut')
                ->click('@pie-dna-ystr-results-collapse')
                ->click('@pie-dna-ystr-results-close');

            $browser->click('@pie-dna-austr-results-size')
                ->click('@pie-dna-austr-results-donut')
                ->click('@pie-dna-austr-results-collapse')
                ->click('@pie-dna-austr-results-close');

            $browser->click('@pie-measured-size')
                ->click('@pie-measured-donut')
                ->click('@pie-measured-collapse')
                ->click('@pie-measured-close');

            $browser->click('@pie-ct-scanned-size')
                ->click('@pie-ct-scanned-donut')
                ->click('@pie-ct-scanned-collapse')
                ->click('@pie-ct-scanned-close');

            $browser->click('@pie-xray-scanned-size')
                ->click('@pie-xray-scanned-donut')
                ->click('@pie-xray-scanned-collapse')
                ->click('@pie-xray-scanned-close');

            $browser->click('@pie-clavicle-triangle-size')
                ->click('@pie-clavicle-triangle-donut')
                ->click('@pie-clavicle-triangle-collapse')
                ->click('@pie-clavicle-triangle-close');

            $browser->click('@pie-isotope-sampled-size')
                ->click('@pie-isotope-sampled-donut')
                ->click('@pie-isotope-sampled-collapse')
                ->click('@pie-isotope-sampled-close');

            //Bar Charts
            $browser->click('@bar-mito-sequences-collapse')
                ->click('@bar-mito-sequences-close');

            $browser->click('@bar-frequency-bones-collapse')
                ->click('@bar-frequency-bones-close');


            $browser->click('@bar-frequency-zones-collapse')
                ->click('@bar-frequency-zones-close');

            //Stacked Bar Charts
            $browser->click('@stacked-bar-mni-mito-bones-side-collapse')
                ->click('@stacked-bar-mni-mito-bones-side-close');

            $browser->click('@stacked-bar-mni-bones-side-collapse')
                ->click('@stacked-bar-mni-bones-side-close');

            $browser->click('@stacked-bar-frequency-zones-side-collapse')
                ->click('@stacked-bar-frequency-zones-side-close');

            //Line Chart
            $browser->click('@line-specimens-collapse')
                ->click('@line-specimens-close');

            $browser->click('@line-dnas-collapse')
                ->click('@line-dnas-close');

            // Dashboard should be empty and all widgets closed.
            // Reset the dash board and wait for widgets to reload.
            // Possible bug dashboard reload button will not work until page is refreshed.
            $browser->visit('/dashboard')
                ->pause(90000)
                ->click('@reset-dashboard-button');

            // Test Widget Details
            //Details button opens new tab.
            $browser->click('@pie-complete-details');
            //Drill down opens in a new window. Switch to new tab.
            $window = collect($browser->driver->getWindowHandles())->last();
            $browser->driver->switchTo()->window($window);
            $browser->assertPathIs('/drilldown/complete')
                //wait for widgets to load
                ->pause(120000);

            //Test Drill down widget button
                //Each manipulation button requires two clicks.
            $browser->click('@pie-complete-size')
                ->pause(3000)
                ->click('@pie-complete-size')

                ->click('@pie-complete-donut')
                ->pause(3000)
                ->click('@pie-complete-donut')


                ->click('@pie-complete-collapse')
                ->pause(3000)
                ->click('@pie-complete-collapse')

                ->click('@pie-complete-close');

            // Reload page after close. Pie Should come back.
            $browser->visit('/drilldown/complete');

        });
    }
    /**
     * A Dusk test for each of the drilldown buttons on the project dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group DrilldownsOrgAdmin
     * @group AuthorJohn
     */
    public function DrilldownsOrgAdmin()
    {
        //local machine is very slow comment out or remove pauses to increase testing times
        // Org manager dashboard is different than org admin.
        // Test User login
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->pause(30000)
                ->loginUser($user['email'], $user['password'])
                ->pause(30000)
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            //visit home page
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->pause(30000)

                //open navigation bar and click on dashboard
                ->click('@leftSideBar-menu')
                ->click('@Dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                //Wait for widgets to load
                ->pause(90000);

            //Org Admin has one more screen and needs to click a project first.
            $browser->click('@dna-summary-buna');

            //Drill down opens in a new window. Switch to new tab.
            $window = collect($browser->driver->getWindowHandles())->last();
            $browser->driver->switchTo()->window($window);
            $browser->assertPathIs('/projectDashboard/12')
                //wait for widgets to load
                ->pause(120000);

            // Testing each drilldown button
            // Pie Charts
            $browser->click('@pie-complete-size')
                ->click('@pie-complete-donut')
                ->click('@pie-complete-collapse')
                ->click('@pie-complete-close');

            $browser->click('@pie-individual-assigned-size')
                ->click('@pie-individual-assigned-donut')
                ->click('@pie-individual-assigned-collapse')
                ->click('@pie-individual-assigned-close');

            $browser->click('@pie-dna-sampled-size')
                ->click('@pie-dna-sampled-donut')
                ->click('@pie-dna-sampled-collapse')
                ->click('@pie-dna-sampled-close');

            $browser->click('@pie-dna-mito-results-size')
                ->click('@pie-dna-mito-results-donut')
                ->click('@pie-dna-mito-results-collapse')
                ->click('@pie-dna-mito-results-close');

            $browser->click('@pie-dna-ystr-results-size')
                ->click('@pie-dna-ystr-results-donut')
                ->click('@pie-dna-ystr-results-collapse')
                ->click('@pie-dna-ystr-results-close');

            $browser->click('@pie-dna-austr-results-size')
                ->click('@pie-dna-austr-results-donut')
                ->click('@pie-dna-austr-results-collapse')
                ->click('@pie-dna-austr-results-close');

            $browser->click('@pie-measured-size')
                ->click('@pie-measured-donut')
                ->click('@pie-measured-collapse')
                ->click('@pie-measured-close');

            $browser->click('@pie-ct-scanned-size')
                ->click('@pie-ct-scanned-donut')
                ->click('@pie-ct-scanned-collapse')
                ->click('@pie-ct-scanned-close');

            $browser->click('@pie-xray-scanned-size')
                ->click('@pie-xray-scanned-donut')
                ->click('@pie-xray-scanned-collapse')
                ->click('@pie-xray-scanned-close');

            $browser->click('@pie-clavicle-triangle-size')
                ->click('@pie-clavicle-triangle-donut')
                ->click('@pie-clavicle-triangle-collapse')
                ->click('@pie-clavicle-triangle-close');

            $browser->click('@pie-isotope-sampled-size')
                ->click('@pie-isotope-sampled-donut')
                ->click('@pie-isotope-sampled-collapse')
                ->click('@pie-isotope-sampled-close');

            //Bar Charts
            $browser->click('@bar-mito-sequences-collapse')
                ->click('@bar-mito-sequences-close');

            $browser->click('@bar-frequency-bones-collapse')
                ->click('@bar-frequency-bones-close');


            $browser->click('@bar-frequency-zones-collapse')
                ->click('@bar-frequency-zones-close');

            //Stacked Bar Charts
            $browser->click('@stacked-bar-mni-mito-bones-side-collapse')
                ->click('@stacked-bar-mni-mito-bones-side-close');

            $browser->click('@stacked-bar-mni-bones-side-collapse')
                ->click('@stacked-bar-mni-bones-side-close');

            $browser->click('@stacked-bar-frequency-zones-side-collapse')
                ->click('@stacked-bar-frequency-zones-side-close');

            //Line Chart
            $browser->click('@line-specimens-collapse')
                ->click('@line-specimens-close');

            $browser->click('@line-dnas-collapse')
                ->click('@line-dnas-close');

            // Dashboard should be empty and all widgets closed.
            // Reset the dash board and wait for widgets to reload.
            // Possible bug dashboard reload button will not work until page is refreshed.
            $browser->visit('/projectDashboard/12')
                ->pause(90000)
                ->click('@reset-dashboard-button');

            // Test Widget Details
            //Details button opens new tab.
            $browser->click('@pie-complete-details');
            //Drill down opens in a new window. Switch to new tab.
            $window = collect($browser->driver->getWindowHandles())->last();
            $browser->driver->switchTo()->window($window);
            $browser->assertPathIs('/drilldown/complete')
                //wait for widgets to load
                ->pause(120000);

            //Test Drill down widget button
            //Each manipulation button requires two clicks.
            $browser->click('@pie-complete-size')
                ->pause(3000)
                ->click('@pie-complete-size')

                ->click('@pie-complete-donut')
                ->pause(3000)
                ->click('@pie-complete-donut')


                ->click('@pie-complete-collapse')
                ->pause(3000)
                ->click('@pie-complete-collapse')

                ->click('@pie-complete-close');

            // Reload page after close. Pie Should come back.
            $browser->visit('/drilldown/complete');

        });
    }
}
