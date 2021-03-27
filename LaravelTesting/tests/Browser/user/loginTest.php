<?php
/**
 * LoginTest DuskTestCase
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

// 12 Total Test Cases
class loginTest extends coraBaseTest
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
     * A Dusk test for a newly created user login for the first time.
     * This will require the user to change the temporary password
     * The user should automatically be redirected to the
     * /password/expiration page. Here the user will
     * change the password. This will redirect
     * the user back to the login page where
     * they will have to use the new
     * password to login.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LoginNewUser
     * @group AuthorKyle
     */
    /*
    public function loginNewUser()
    {
        $user = ['email' => 'test.dna.analyst@unomaha.edu
', 'orig-password' => 'Peacemaker!2', 'new-password' => 'Unomaha!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new LoginPage)
                ->loginUser($user['email'], $user['orig-password'])
                ->assertSee('Password Expired')
                ->assertPathIs('/password/expiration')
                ->type('current-password', $user['orig-password'])
                ->type('new-password', 'Unomaha!23')
                ->type('new-password_confirmation', 'Unomaha!23')
                ->press('Change Password')
                ->assertSee('Password changed successfully, You can now login !')
                ->assertPathIs('/login')
                ->type('email', $user['email'])
                ->type('password', 'Unomaha!23')
                ->press('Login')
                ->assertPathIs('/home')
                ->clickLink('Logout')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/');
        });
    }
    */
    /**
     * A simple Dusk test for a user account that does not exist.
     *
     * @return void
     * @throws
     * @test
     * @group Login100
     * @group LoginInvalidUser
     * @group InvalidLogin
     * @group AuthorKyle
     */
    public function LoginInvalidUser()
    {
        $user = $this->testAccounts["invalid-user"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('These credentials do not match our records.')
                ->assertSee('These credentials do not match our records.')
                ->assertPathIs('/login');
        });
    }

    /**
     * A simple Dusk test for a user account that exist but with invalid password.
     *
     * @return void
     * @throws
     * @test
     * @group Login200
     * @group LoginInvalidUserPassword
     * @group InvalidLogin
     * @group AuthorKyle
     */
    public function LoginInvalidUserPassword()
    {
        $user = $this->testAccounts["invalid-pswd"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('These credentials do not match our records.')
                ->assertSee('These credentials do not match our records.')
                ->assertPathIs('/login');
        });
    }
    /**
     * A Dusk test for a manager user account that exists but with invalid password.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LoginInvalidManagerPassword
     * @group InvalidLogin
     * @group AuthorKyle
     */
    public function LoginInvalidManagerPassword()
    {
        $user = $this->testAccounts["invalid-org-manager"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('These credentials do not match our records.')
                ->assertSee('These credentials do not match our records.')
                ->assertPathIs('/login');
        });
    }
    /**
     * A Dusk test example.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LoginOrgAdminUser
     * @group LoginInvalidOrgAdminPassword
     * @group InvalidLogin
     * @group AuthorKyle
     */
    public function LoginInvalidOrgAdminPassword()
    {
        $user = $this->testAccounts["invalid-org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('These credentials do not match our records.')
                ->assertSee('These credentials do not match our records.')
                ->assertPathIs('/login');
        });
    }
    /**
     * A Dusk test for login without any credentials.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LoginBlank
     * @group AuthorKyle
     */
    public function LoginBlankFail()
    {
        $user = $this->testAccounts["blank-user"];

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Login')
                ->assertSee('Login')
                ->waitForLocation('/login')
                ->assertPathIs('/login');
        });
    }
    /**
     * A Dusk test for test user logout.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LogoutUser
     * @group AuthorKyle
     */
    public function LogoutUser()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test for test user logout.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LogoutUser
     * @group AuthorKyle
     */
    public function LogoutDnaAnalyst()
    {
        $user = $this->testAccounts["dna-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test for test user logout.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LogoutUser
     * @group AuthorKyle
     */
    public function LogoutIsoAnalyst()
    {
        $user = $this->testAccounts["isotope-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome')
                ->pause(500)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test for test user logout.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LogoutUser
     * @group AuthorKyle
     */
    public function LogoutAnthropologist()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test for test user logout.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LogoutUser
     * @group AuthorKyle
     */
    public function LogoutLeadAnthropologist()
    {
        $user = $this->testAccounts["project-lead"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test for manager user logout.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group Manager
     * @group LogoutManager
     * @group AuthorKyle
     */
    public function LogoutManager()
    {
        $user = $this->testAccounts["org-manager"];

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test for org admin user logout.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LogoutOrgAdmin
     * @group AuthorKyle
     */
    public function LogoutOrgAdmin()
    {
        $user = $this->testAccounts["org-admin"];

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test for user login.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group Loginanthro-analyst
     * @group AuthorKyle
     */
    public function LoginUser()
    {
        $user = $this->testAccounts["anthro-analyst"];

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome')
                ->assertDontSee('Administration')
                ->waitForLocation('/')
                ->assertPathIs('/');
        });
    }
    /**
     * A Dusk test for user login.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group Loginanthro-analyst
     * @group AuthorKyle
     */
    public function LoginDnaAnalyst()
    {
        $user = $this->testAccounts["dna-analyst"];

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome')
                ->assertDontSee('Administration')
                ->waitForLocation('/')
                ->assertPathIs('/');
        });
    }
    /**
     * A Dusk test for user login.
     *
     * @return void
     * @throws
     * @test
     * @group Login1
     * @group Loginanthro-analyst
     * @group AuthorKyle
     */
    public function LoginIsoAnalyst()
    {
        $user = $this->testAccounts["isotope-analyst"];

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome')
                ->assertDontSee('Administration')
                ->waitForLocation('/')
                ->assertPathIs('/');
        });
    }
    /**
     * A Dusk test for user login.
     *
     * @return void
     * @throws
     * @test
     * @group Login1
     * @group Loginanthro-analyst
     * @group AuthorKyle
     */
    public function LoginAnthropologist()
    {

        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome')
                ->assertDontSee('Administration')
                ->waitForLocation('/')
                ->assertPathIs('/');
        });
    }
    /**
     * A Dusk test for user login.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group Loginanthro-analyst
     * @group AuthorKyle
     */
    public function LoginLeadAnthro()
    {
        $user = $this->testAccounts["project-lead"];

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->pause(3000)
                ->assertSee('Welcome')
                ->assertDontSee('Administration')
                ->waitForLocation('/')
                ->assertPathIs('/');
        });
    }
    /**
     * A Dusk test for manager user login.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LoginManagerUser
     * @group Manager
     * @group AuthorKyle
     */
    public function LoginManager()
    {
        $user = $this->testAccounts["org-manager"];

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome')
                ->assertDontSee('Administration')
                ->waitForLocation('/')
                ->assertPathIs('/');
        });
    }
    /**
     * A Dusk test for admin user login.
     *
     * @return void
     * @throws
     * @test
     * @group Login
     * @group LoginOrgAdminUser
     * @group AuthorKyle
     */
    public function LoginOrgAdmin()
    {
        $user = $this->testAccounts["org-admin"];

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Pages\loginPage)
                ->loginUser($user['email'], $user['password'])
                ->waitForText('Welcome')
                ->assertSee('Welcome')
                ->waitForLocation('/')
                ->assertPathIs('/');
        });
    }
}
