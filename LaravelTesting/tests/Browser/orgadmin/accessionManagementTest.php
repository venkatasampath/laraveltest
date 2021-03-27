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
use Tests\Browser\Pages\accessionManagementPage;
use App\User;


/**
 * Overall test file for the Accessions Management section
 * that lies underneath the Administration section
 *
 * @return void
 * @throws
 * @group section_ADMIN
 * @group part_accession_management
 * @group full_accession_test
 * @group AuthorJohn
 *
 */

class admin_AccessionManagementTest extends DuskTestCase
{

    /**
     * A Dusk test to create a new accession
     *
     * @return void
     * @throws
     * @group AccessionCreate
     *
     */
    //TODO: Create not working

    public function testAccessionCreate()
    {
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password']);

        // Test user login
        //$user = ['email' => 'profiletest@unomaha.edu', 'password' => 'Password!32'];
        //$this->browse(function (Browser $browser) {
            //$user = user::find(1);
            $browser->visit(new accessionManagementPage())
                //->assertPathIs('/accessions')
                ->press('@actions-button')
                ->press('@actions-create-menu')
                //->assertSee('****FORCED FAIL****')
                ->assertSee('Create Accession')
                ->assertPathIs('/accessions/create')
                ->select('@project','CoRA Demo') //TODO: if does not work, value is 1
                ->check('@consolidated-check')
                ->type('@number',uniqid('TestAccession_'))
                ->type('@provenance1', 'Delete')
                ->type('@provenance2', '9998')
                ->assertsee('****FORCED FAIL****')

                ->click('@start_date')
                ->press('@save-button')
                ->assertsee('View Project - TestProject');
        });
    }




    /**
     * A Dusk test to create a edit an accession
     *
     * @return void
     * @throws
     * @group AccessionEdit
     *
     */

    public function testAccessionEdit()
    {
    // Test user login
    //$user = ['email' => 'profiletest@unomaha.edu', 'password' => 'Password!32'];
    $this->browse(function (Browser $browser) {
    $user = User::find(1);
    $browser->loginAs($user)
    ->visit(new accessionManagementPage())
    ->assertPathIs('/accessions')
    ->type('@search', 'MainTest_1000')
        ->assertSee('****FORCED FAIL****')
        ->click('@searchtopresult')
        ->assertSee('Associate Accessions')
        ->assertPathIs('/accessions/354')
        ->press('@actions-button')
        ->press('@actions-edit-menu')
        ->assertSee('Edit Accession - MainTest_1000')

        ->assertSee('****FORCED FAIL****');
    });
    }

}
