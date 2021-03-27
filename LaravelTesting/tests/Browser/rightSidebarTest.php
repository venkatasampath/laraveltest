<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\homePage;
use Tests\Browser\Pages\specimenPage;
use App\User;

class rightSidebarTest extends DuskTestCase
{
    /**
     * A Dusk test to functionality in the right sidebar
     *
     * @return void
     * @throws
     * @test
     * @group RightSidebar
     * @group UNO
     * @group RSB-Navigation
     * @group AuthorJohn
     */
        public function RSB_Navigation()
        {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            //testing navigation
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->click('@right-sidebar')
                ->assertSee('Layout Options')
                ->click('@right-sb-media')
                ->assertSee('Media')
                //->click('@right-sb-help')
                //->assertSee('Help')
                ->click('@right-sb-home')
                ->assertSee('Home')
                ->click('@right-sb-settings')
                ->assertSee('Settings')
                ->click('@right-sb-layout')
                ->assertSee('Layout Options');
        });
        }

    /**
     * A Dusk test to functionality in the right sidebar
     *
     * @return void
     * @throws
     * @test
     * @group RightSidebar
     * @group UNO
     * @group RSB-Layout
     * @group AuthorJohn
     */
    public function RSB_Layout()
        {
            // Test user login
            $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
            $this->browse(function ($browser) use ($user) {
                $browser->visit(new loginPage)
                    ->loginUser($user['email'], $user['password'])
                    ->assertSee('Welcome to CoRA')
                    ->assertSee('Home');

                //testing Layout Options check boxes
                $browser->visit(new homePage)
                    ->visit('/')
                    ->assertSee('Welcome to CoRA')
                    ->assertPathIs('/')
                    ->click('@right-sidebar')
                    ->assertSee('Layout Options')
                    ->check('@right-sb-layout-Ltoggle')
                    ->assertSee('Dashboard')
                    ->assertSee('Administration')
                    ->uncheck('@right-sb-layout-Ltoggle')
                    ->assertDontSee('Dashboard')
                    ->assertDontSee('Administration')
                    ->check('@right-sb-layout-Rtoggle')
                    ->check('@right-sb-layout-skin')
                    ->assertChecked('@right-sb-layout-Rtoggle')
                    ->assertChecked('@right-sb-layout-skin')
                    ->uncheck('@right-sb-layout-Rtoggle')
                    ->click('@right-sidebar')
                    ->uncheck('@right-sb-layout-skin')
                    ->assertnotChecked('@right-sb-layout-Rtoggle')
                    ->assertnotChecked('@right-sb-layout-skin');


                //testing Layout Options theme skins
                $browser->visit(new homePage)
                    ->visit('/')
                    ->assertSee('Welcome to CoRA')
                    ->assertPathIs('/')
                    ->click('@right-sidebar')
                    ->assertSee('Layout Options');
                    $browser->driver->executeScript('window.scrollTo(0, 900);');
                    $browser
                    ->click('@right-sb-skin-bluedark')
                    ->click('@right-sb-skin-blackdark')
                    ->click('@right-sb-skin-purpledark')
                    ->click('@right-sb-skin-greendark')
                    ->click('@right-sb-skin-reddark')
                    ->click('@right-sb-skin-yellowdark')
                    ->click('@right-sb-skin-bluelight')
                    ->click('@right-sb-skin-blacklight')
                    ->click('@right-sb-skin-purplelight')
                    ->click('@right-sb-skin-greenlight')
                    ->click('@right-sb-skin-redlight')
                    ->click('@right-sb-skin-yellowlight');
            });
        }

    /**
     * A Dusk test to functionality in the right sidebar
     *
     * @return void
     * @throws
     * @test
     * @group RightSidebar
     * @group UNO
     * @group RSB-Media
     * @group AuthorJohn
     */
    public function RSB_Media()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            //testing Layout Options check boxes
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->click('@right-sidebar')
                ->assertSee('Layout Options')
                ->click('@right-sb-media')
                ->assertSee('Media')
                ->assertSee('Video')
                ->assertSee('Images');
        });
    }

     /**
     * A Dusk test to functionality in the right sidebar
     *
     * @return void
     * @throws
     * @test
     * @group RightSidebar
     * @group UNO
     * @group RSB-Help
     * @group AuthorJohn
     */
    public function RSB_Help()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            //testing Layout Options check boxes
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->click('@right-sidebar')
                ->assertSee('Layout Options')
                ->click('@right-sb-help')
                ->pause('1000');
                //Cannot click into the CoRA Docs element itself nor assert text in it
        });
    }

    /**
     * A Dusk test to functionality in the right sidebar
     *
     * @return void
     * @throws
     * @test
     * @group RightSidebar
     * @group UNO
     * @group RSB-ActivityFeed
     * @group AuthorJohn
     */
    public function RSB_ActivityFeed()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            //testing Layout Options check boxes
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->click('@right-sidebar')
                ->assertSee('Layout Options')
                ->click('@right-sb-feed')
                ->assertSee('Activity Feed')
                ->assertSee('User Activity Feed for Specimens')
                ->assertSee('User Activity Feed for DNA')

                //testing the top link on the specimens table
                ->click('@right-sb-feed-se')
                ->assertSee('View Specimen - ')
                ->assertPathBeginsWith('/skeletalelements')


                ->click('@right-sidebar')
                ->assertSee('Layout Options')
                ->click('@right-sb-feed')
                ->assertSee('Activity Feed')
                //testing the top link on the dna table
                ->click('@right-sb-feed-dna')
                ->assertSee('View Specimen - ABC999-888-777-556')
                ->assertPathIs('/skeletalelements/1221');

            //creating a new element to test that it appears in the feed
            $newSkeletalElement = 'TEST'.rand(10000,99999);
            $browser->visit(new specimenPage)
                ->visit('/skeletalelements/create')
                ->assertPathIs('/skeletalelements/create')
                ->select('@accession-number','54321')
                ->select('@provenance1','8888')
                ->select('@provenance2','7777')
                ->type('@designator',$newSkeletalElement)
                ->select('sb_id',rand(1,166))
                ->select('side','Left')
                ->select('completeness','Complete')
                ->pause(500)
                ->press('@se-save')
                ->pause(500)
                ->waitForText($newSkeletalElement)
                ->assertPathIs('/skeletalelements');

            $browser->visit(new homePage)
                ->assertSee('Welcome to CoRA')
                ->click('@right-sidebar')
                ->assertSee('Layout Options')
                ->click('@right-sb-feed')
                ->assertSee('Activity Feed')
                ->click('@right-sb-feed-se')
                ->assertPathBeginsWith('/skeletalelements')
                ->assertSee($newSkeletalElement);
        });
    }

    /**
     * A Dusk test to functionality in the right sidebar
     *
     * @return void
     * @throws
     * @test
     * @group RightSidebar
     * @group UNO
     * @group RSB-Settings
     * @group AuthorJohn
     */
    public function RSB_Settings()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            //testing setting lines per page
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->click('@right-sidebar')
                ->assertSee('Layout Options')
                ->click('@right-sb-settings')
                ->assertSee('General Settings')
                ->select('@right-sb-settings-lines', '25')
                ->click('@right-sb-settings-update-general')
                ->visit('/projects')
                ->click('@right-sidebar')
                ->click('@right-sb-settings')
                ->assertSee('General Settings')
                ->assertValue('@right-sb-settings-lines', '25')
                ->visit('/skeletalelements')
                ->assertSee('Showing 1 to 25 of');

            //testing the setting of the default project values
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->click('@right-sidebar')
                ->assertSee('Layout Options')
                ->click('@right-sb-settings')
                ->assertSee('General Settings')
                ->type('@accession','888888')
                ->type('@provenance1','54321')
                ->type('@provenance2','09876');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@right-sb-settings-update-se');
            $browser->visit(new specimenPage())
                ->click('@sidebar-expand')
                ->click('@se-menu')
                ->click('@se-new-group')
                ->assertValue('@accession-number','888888')
                ->assertValue('@provenance1','54321')
                ->assertValue('@provenance2','09876');

            //testing the setting of the DNA settings
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->click('@right-sidebar')
                ->assertSee('Layout Options')
                ->click('@right-sb-settings')
                ->assertSee('General Settings');
            $browser->driver->executeScript('window.scrollTo(0, 9000);');
            $browser
                ->assertSee('DNA Profile Settings')
                ->select('@right-sb-settings-lab','2')
                ->assertValue('@right-sb-settings-lab','Another Lab')
                ->select('@right-sb-settings-dna','NGS')
                ->assertValue('@right-sb-settings-dna','NGS')
                ->visit('/dashboard')
                ->click('@right-sidebar')
                ->assertSee('Layout Options')
                ->click('@right-sb-settings')
                ->assertSee('General Settings');
            $browser->driver->executeScript('window.scrollTo(0, 9000);');
            $browser
                ->assertSee('DNA Profile Settings')
                ->assertValue('@right-sb-settings-lab','Another Lab')
                ->assertValue('@right-sb-settings-dna','NGS')
                ->select('@right-sb-settings-lab','1')
                ->select('@right-sb-settings-dna','Sanger')
                ->visit('/dashboard')
                ->click('@right-sidebar')
                ->assertSee('Layout Options')
                ->click('@right-sb-settings')
                ->assertSee('General Settings');
            $browser->driver->executeScript('window.scrollTo(0, 9000);');
            $browser
                ->assertSee('DNA Profile Settings')
                ->assertValue('@right-sb-settings-lab','AFDIL')
                ->assertValue('@right-sb-settings-dna','Sanger');
        });
    }

}
