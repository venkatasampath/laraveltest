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
use Tests\Browser\Pages\userManagementPage;
use App\User;


/**
 * Overall test file for the User Management section
 * that lies underneath the Administration section
 *
 * @return void
 * @throws
 * @group section_ADMIN
 * @group part_user_management
 * @group full_user_test
 * @group AuthorJohn
 *
 */

class admin_UserManagementTest extends DuskTestCase
{

    /**
     * A Dusk test to create a new user
     *
     * @return void
     * @throws
     * @group UserManagement
     * @group UserCreate
     * @group AuthorJohn
     *
     */
    public function testUserCreate()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $username = uniqid('TestUser_');
            $browser->loginAs($user)
                ->visit(new userManagementPage)
                ->assertPathIs('/users')
                ->assertSee('Users')
                ->press('@actions-button')
                ->press('@actions-create-menu')
                ->assertPathIs('/users/create')
                ->assertSee('New User')
                ->type('@name',$username)
                ->type('@email', $username.'@unomaha.edu')
                ->check('@active','1')
                ->select('@role','3')
                ->type('@password','Password!23')
                ->type('@password-confirm','Password!23')
                ->press('@save-button')
                ->assertPathIs('/users/create')
                ->assertsee('User successfully added');
        });
    }

    /**
     * A Dusk test to cause failures when creating user.
     *
     * @return void
     * @throws
     * @group UserManagement
     * @group UserCreateFail
     * @group AuthorJohn
     *
     */
    public function testUserCreateFail()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new userManagementPage)
                ->assertSee('Users')
                ->press('@actions-button')
                ->press('@actions-create-menu')
                ->assertPathIs('/users/create')
                ->assertSee('New User')

                //Error on duplicate email address
                ->type('@name', 'TestUserFail')
                ->type('@email', 'profiletest@unomaha.edu')
                ->check('@active', '1')
                ->type('@password', 'Password!23')
                ->type('@password-confirm', 'Password!23')
                ->press('@save-button')
                ->assertsee('The email has already been taken')

                //Error on bad password length and format
                ->type('@email', 'testuser9999@unomaha.edu')
                ->type('@password', 'abc123')
                ->type('@password-confirm', 'abc123')
                ->press('@save-button')
                ->assertsee('The password must be at least 10 characters')
                ->assertSee('The password format is invalid')

                //Error on bad password format
                ->type('@password', 'abc123456789')
                ->type('@password-confirm', 'abc123456789')
                ->press('@save-button')
                ->assertSee('The password format is invalid');
        });

        //Additional function created due to max lines per function limit
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new userManagementPage)
                ->assertSee('Users')
                ->press('@actions-button')
                ->press('@actions-create-menu')
                ->assertSee('New User')

                //Error on password not matching
                ->type('@name', 'TestUserFail')
                ->type('@email', 'testuser9999@unomaha.edu')
                ->check('@active', '1')
                ->type('@password', 'Password!23')
                ->type('@password-confirm','!23Password')
                ->press('@save-button')
                ->assertsee('The password confirmation does not match')

                //Error on no password entered
                ->press('@save-button')
                ->assertsee('The password field is required');
        });
    }


    /**
     * A Dusk test to edit a user.  Utilizes search feature
     * and tests that login fails when making a user account
     * inactive.
     *
     * @return void
     * @throws
     * @group UserManagement
     * @group UserEdit
     * @group AuthorJohn
     *
     */
    public function testUserEdit()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new userManagementPage)
                ->assertPathIs('/users')
                ->assertSee('Users')
                ->type('@search', 'testuser1000')
                ->click('@searchtopresult')
                ->assertsee('View User - TestUser1000')
                ->press('@actions-button')
                ->press('@actions-edit-menu')
                ->assertsee('Edit User - TestUser1000')
                ->type('@name', 'TestUserEdit1000')
                ->type('@email', 'testedit1000@unomaha.edu')
                ->uncheck('@active', '1')
                ->select('@role','5')
                ->press('@save-button')
                ->assertSee('Users');
        });

        //test inactive user login
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new userManagementPage)
                ->press('@user-menu')
                ->press('@user-logout')
                ->press('@login-menu-button')
                ->type('@login-email', 'testuseredit1000@unomaha.edu')
                ->type('@login-password', 'Password!23')
                ->press('@login-button')
                //->waitForText('These credentials do not match our records');
                ->assertsee('Login');
        });

        //change user info back
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new userManagementPage)
                ->type('@search', 'testuseredit1000')
                ->click('@searchtopresult')
                ->assertsee('View User - TestUserEdit1000')
                ->press('@actions-button')
                ->press('@actions-edit-menu')
                ->assertsee('Edit User - TestUserEdit1000')
                ->type('@name', 'TestUser1000')
                ->type('@email','testuser1000@unomaha.edu')
                ->check('@active','1')
                ->select('@role','3')
                ->press('@save-button')
                ->assertSee('Users');
        });
    }

    /**
     * A Dusk test to test Discard Changes option
     * when editing a user account.
     *
     * @return void
     * @throws
     * @group UserManagement
     * @group UserEditDiscard
     * @group AuthorJohn
     *
     */
    public function testUserEditDiscard()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new userManagementPage)
                ->assertPathIs('/users')
                ->assertSee('Users')
                ->type('@search', 'testuser1000')
                ->click('@searchtopresult')
                ->assertsee('View User - TestUser1000')
                ->press('@actions-button')
                ->press('@actions-edit-menu')
                ->assertsee('Edit User - TestUser1000')
                ->type('@name', 'EditDiscard')
                ->type('@email', 'editdiscard@unomaha.edu')
                ->press('@actions-button')
                ->press('@actions-discard-menu')
                ->assertsee('View User - TestUser1000');
                });
    }

    /**
     * A Dusk test to test Discard Changes option
     * when editing a user account.
     *
     * @return void
     * @throws
     * @group UserManagement
     * @group UserEditFail
     * @group AuthorJohn
     *
     */
    public function testUserEditFail()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new userManagementPage)
                ->assertSee('Users')
                ->type('@search', 'testuser1000')
                ->click('@searchtopresult')
                ->assertsee('View User - TestUser1000')
                ->press('@actions-button')
                ->press('@actions-edit-menu')
                ->assertsee('Edit User - TestUser1000')
                ->type('@email', 'editfail')
                ->press('@save-button')
                ->assertsee('The email must be a valid email address');
                });
    }
}
