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
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\userProfilePage;
use Tests\Browser\Pages\specimenPage;
use App\User;


/**
 * Overall test file for the user Profile section
 *
 * @return void
 * @throws
 * @group section_Profile
 * @group part_user_profile
 * @group full_profile_test
 * @group author_John
 *
 */

class ADMIN_UserProfileTest extends DuskTestCase
{

    /**
     *
     * @return void
     * @throws
     * @group UserProfile
     * @group UserNavigationCheck
     * @group AuthorJohn
     *
     */
    public function testUserNavigationCheck()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome to CoRA');

            $browser->visit(new userProfilePage())
                ->assertPathBeginsWith('/user/')
                ->assertsee('Profile')
                ->click('@personal_settings_general')
                ->assertsee('General')
                ->click('@personal_settings_projects')
                ->assertsee('Projects')
                ->click('@personal_settings_notifications')
                ->assertsee('Notifications')
                ->click('@personal_settings_localization')
                ->assertsee('Localization')
                ->click('@personal_settings_lastlogon')
                ->assertsee('Last Logon')
                ->click('@personal_settings_activityfeed')
                ->assertsee('Activity Feed')
                ->click('@personal_settings_profile')
                ->assertsee('Profile');
        });
    }


    /**
     *
     * @return void
     * @throws
     * @group UserProfile
     * @group UpdateProfile
     * @group AuthorJohn
     *
     */
    public function testUpdateProfile()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password']);

            $browser->visit(new userProfilePage())
                ->assertPathBeginsWith('/user/')
                ->assertsee('Profile')
                ->type('@profile_name','Profile Testing EDIT')
                ->type('@profile_cell_phone','4025551234')
                ->type('@profile_alt_phone','4021235555')
                ->press('@profile_update')
                ->click('@personal_settings_general')
                ->click('@personal_settings_profile')
                //->assertsee('Profile Testing EDIT')

                //reverting back to original data
                ->type('@profile_name','Profile Testing')
                ->type('@profile_cell_phone','4026661234')
                ->type('@profile_alt_phone','4021236666')
                ->press('@profile_update')
                ->click('@personal_settings_general')
                ->click('@personal_settings_profile');
                //->assertsee('Profile Testing')
        });
    }


    /**
     *
     * @return void
     * @throws
     * @group UserProfile
     * @group UpdateGeneral
     * @group AuthorJohn
     *
     */
    public function testUpdateGeneral()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password']);

            $browser->visit(new userProfilePage())
                ->click('@personal_settings_general')
                ->assertsee('General')
                ->select('@general_lines_per_page','50')
                ->check('@general_show_welcome_screen')
                ->click('@general_update')
                ->assertsee('25')
                ->assertchecked('@general_show_welcome_screen')
                ->visit('/skeletalelements')
                ->assertSee('Showing 1 to 25 of');

                //reverting back to original data
            $browser->visit(new userProfilePage())
                ->click('@personal_settings_general')
                ->assertsee('General')
                ->select('@general_lines_per_page','10')
                ->uncheck('@general_show_welcome_screen')
                ->click('@general_update')
                ->assertsee('10')
                ->assertnotchecked('@general_show_welcome_screen');
        });
    }


    /**
     *
     * @return void
     * @throws
     * @group UserProfile
     * @group UpdateProjects
     * @group AuthorJohn
     *
     */
    public function testUpdateProjects()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password']);

            $browser->visit(new userProfilePage())
                ->click('@personal_settings_projects')
                ->assertsee('Projects')
                ->select('@project_default_project','0')
                ->select('@project_default_laboratory','1')
                ->type('@project_mru_list','8')
                ->type('@project_accession_number','444444')
                ->type('@project_provenance1','88990')
                ->type('@project_provenance2','68102');

            //scroll page down to view Update button
            $browser->driver->executeScript('window.scrollTo(0, 500);');

            $browser
                ->check('@project_se_search_new_tab')
                ->select('@project_se_redirect','0')
                ->click('@project_update')
                ->assertsee('8')
                ->assertchecked('@project_se_search_new_tab');

            $browser->visit(new specimenPage())
                ->click('@sidebar-expand')
                ->click('@se-menu')
                ->click('@se-new-group')
                ->assertValue('@accession-number','444444')
                ->assertValue('@provenance1','88990')
                ->assertValue('@provenance2','68102');

                //reverting back to original data
            $browser->visit(new userProfilePage())
                ->select('@project_default_project','0')
                ->select('@project_default_laboratory','0')
                ->type('@project_mru_list','5')
                ->type('@project_accession_number','888888')
                ->type('@project_provenance1','12345')
                ->type('@project_provenance2','67890')
                ->uncheck('@project_se_search_new_tab')
                ->select('@project_se_redirect','1')
                ->press('@project_update')
                ->assertsee('5')
                ->assertnotchecked('@project_se_search_new_tab');
        });
    }


    /**
     *
     * @return void
     * @throws
     * @group UserProfile
     * @group UpdateNotifications
     * @group AuthorJohn
     *
     */
    public function testUpdateNotifications()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password']);

            $browser->visit(new userProfilePage())
                ->click('@personal_settings_notifications')
                ->assertsee('Notifications')
                ->uncheck('@notifications_data_transfer_job')
                ->uncheck('@notifications_remains_review')
                ->uncheck('@notifications_method_email')
                ->uncheck('@notifications_sms')
                ->uncheck('@notifications_slack')
                ->click('@notifications_update')
                ->assertnotchecked('@notifications_data_transfer_job')
                ->assertnotchecked('@notifications_remains_review')
                ->assertnotchecked('@notifications_method_email')
                ->assertnotchecked('@notifications_sms')
                ->assertnotchecked('@notifications_slack')

                //reverting back to original data
                ->check('@notifications_data_transfer_job')
                ->check('@notifications_remains_review')
                ->check('@notifications_method_email')
                ->check('@notifications_sms')
                ->check('@notifications_slack')
                ->click('@notifications_update')
                ->assertchecked('@notifications_data_transfer_job')
                ->assertchecked('@notifications_remains_review')
                ->assertchecked('@notifications_method_email')
                ->assertchecked('@notifications_sms')
                ->assertchecked('@notifications_slack');
        });
    }


    /**
     *
     * @return void
     * @throws
     * @group UserProfile
     * @group UpdateLocalization
     * @group Author John
     *
     */
    public function testUpdateLocalization()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password']);

            $browser->visit(new userProfilePage())
                ->click('@personal_settings_localization')
                ->assertsee('Localization')
                ->select('@localization_home_country','PT')
                ->select('@localization_language','bo')
                ->click('@localization_update')
                ->assertsee('Portugal')


                ->select('@localization_home_country','US')
                ->select('@localization_language','en')
                ->click('@localization_update')
                ->assertsee('United States');
        });
    }
}
