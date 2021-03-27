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
use Tests\Browser\Pages\projectManagementPage;
use App\User;


    /**
     * Overall test file for the Project Management section
     * that lies underneath the Administration section
     *
     * @return void
     * @throws
     * @group section_ADMIN
     * @group part_project_management
     * @group full_project_test
     * @group author_John
     *
     */

class admin_ProjectManagementTest extends DuskTestCase
{

    /**
     * A Dusk test to create a new project
     *
     * @return void
     * @throws
     * @group ProjectCreate
     *
     */
    public function testProjectCreate()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new projectManagementPage)
                ->assertsee('CoRA Demo')
                ->press('@actions-button')
                ->press('@actions-create-menu')
                ->assertSee('New Project')
                ->type('@name',uniqid('TestProject_'))
                ->type('@description', 'Test project for Laravel Dusk testing - safe to delete')
                ->select('@status','1')
                ->click('@start_date')
                //->type('@start_date','2272010')
                ->select('@project_manager','2')
                ->type('@project_lat',rand(-90,90))
                ->type('@project_long',rand(-180,180))
                ->uncheck('@public')
                ->press('@save-button')
                ->assertsee('View Project - TestProject');
        });
    }



    /**
     * A Dusk test to cause a failure when creating project by
     * leaving the description field empty
     *
     * @return void
     * @throws
     * @group ProjectCreateFail
     *
     */
    //TODO: Add test once Project Name is a unique field
    public function testProjectCreateFail()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new projectManagementPage)
                ->press('@actions-button')
                ->press('@actions-create-menu')
                ->assertSee('New Project')
                ->type('@name',uniqid('TestProject_'))
                //Keeping the Description field empty to make the create fail
                //->type('description', 'Test project for Laravel Dusk testing')
                ->press('@save-button')
                ->assertPathIs('/projects/create')
                ->assertsee('New Project');

        });
    }



    /**
     * A Dusk test to search for and edit a project
     * This test will edit the name of the project, and make it public,
     * than edit again to uncheck the public checkbox.
     *
     * Tests project search, edit, and discard changes
     *
     * @return void
     * @throws
     * @group ProjectEdit
     *
     */
    public function testProjectEdit()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new projectManagementPage)
                ->type('@search', 'TestProject1000')
                ->click('@searchtopresult')//TODO: Page tag??
                ->assertSee('View Project - TestProject')
                ->press('@actions-button')
                ->press('@actions-edit-menu')
                ->assertSee('Edit Project')
                ->type('@name', 'TestProjectEdit1000')
                ->type('@description', 'Edited the project')
                ->check('@public', '1')
                ->select('@status','3')
                ->assertsee('WIP')
                ->press('@save-button')
                ->assertsee('View Project - TestProjectEdit1000')
                ->assertChecked('@public', '1')

                //editing project again to revert to original values
                ->press('@actions-button')
                ->press('@actions-edit-menu')
                ->type('@name', 'TestProject1000')
                ->type('@description', 'Test project for Laravel Dusk testing')
                ->uncheck('@public', '1')
                ->select('@status','1')
                ->assertsee('Open')
                ->press('@save-button')
                ->assertNotChecked('@public', '1');
        });

        //testing Discard Changes option when editing
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new projectManagementPage)
                ->type('@search', 'testproject1000')
                ->click('@searchtopresult')
                ->assertsee('View Project - TestProject1000')
                ->press('@actions-button')
                ->press('@actions-edit-menu')
                ->check('@public', '1')
                ->press('@actions-button')
                ->press('@actions-discard-menu')
                ->assertNotChecked('@public', '1');
        });
    }



    /**
     * A Dusk test case that will test adding and removing
     * Users from a project
     *
     * @return void
     * @throws
     * @group ProjectUsers
     *
     */

    public function testProjectUsers()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit(new projectManagementPage)
                ->type('@search', 'TestProject1000')
                ->click('@searchtopresult')
                ->assertSee('View Project - TestProject')
                ->press('@actions-User-add-button')

                //Testing adding Users to project
                ->select('@Users-assigned-field','64')
                ->press('@save-button')
                ->assertSee('User(s) successfully associated')

                //Testing removing Users from project
                ->press('@Users-assigned-remove-button')
                ->keys('@Users-assigned-field',['{Escape]'])
                ->press('@save-button')
                ->assertSee('User(s) successfully associated')
                ->assertValue('@Users-assigned-field','TestUserOrgAdmin-UNO');
        });
    }
}
