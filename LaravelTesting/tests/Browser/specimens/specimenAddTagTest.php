<?php

namespace Tests\Browser;

use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\specimenPage;
use Tests\DuskTestCase;

class specimenAddTagTest extends coraBaseTest
{
    /**
     * A Dusk test to verify tags can be added to specimans.
     *
     * @return void
     * @throws
     * @test
     * @group general
     * @group Sprint21
     * @group specimenOrgAnalystSetTag
     *
     */
    public function specimenOrgAnalystSetTag()
    {
        $user = $this->testAccounts["anthro-analyst"];
        $this->browse(function ($browser) use ($user) {
            $browser->maximize();
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->pause(5000);
            //Setup Search parameters
            $browser->visit(new specimenPage)
                ->pause(5000);

            //Select current project to the first project in list.
            $browser->keys('@project-switcher-current-project',['{ARROW_DOWN}'])
                ->pause(1000)
                ->click()
                ->pause(1000)

                //Set Specimen Search to the first list item
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->click()
                ->pause(1000)

                //Set Search Option to the first list item
                ->keys('@cora-search-options-bones', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->pause(1000)

                //search the set parameters
                ->press('@search-btn')
                ->pause(5000);

            //Assert redirect page is correct
            $browser->assertPathIs('/skeletalelements/search');

            //Wait for API calls
            $browser->pause(5000);

            //Select link from table
            $browser->with('.v-data-table', function($table) {
            $table->assertSee('Bone')
            ->clickLink('CIL 2003-116:G-01:X-100:403')
            ->pause(10000);
            });

            //Clicking the table link opens in a new window. Switch to new tab.
            $window = collect($browser->driver->getWindowHandles())->last();
            $browser->driver->switchTo()->window($window);
            $browser->assertPathIs('/skeletalelements/54611')
                ->pause(3000);

            //Enter Edit mode
            $browser->click('@edit-button');

            //Wait for edit mode
            $browser->pause(10000);

            //Assert page is in edit mode
            $browser->assertPathIs('/skeletalelements/54611/edit');

            //Add a tag
            $browser->driver->executeScript('window.scrollTo(0, 500);');

            $browser->pause(1000);

            $browser->click('@new-tag')
                ->pause(1000)
                ->typeSlowly('@tag-create-name', 'blue')
                ->typeSlowly('@tag-create-description', 'blue specimen')
                ->typeSlowly('@tag-create-category', 'uss oklahoma blue')
                ->press('@tag-create-select-color');

            //Color Picker is a vendor product used xpath in liu of dusk selectors
            $red = '//*[@id="vue-app"]/div[5]/div/div/div[2]/div/div[2]/div[2]/div[1]/input';
            $browser->driver->findElement(WebDriverBy::xpath($red))
            ->click();
            $browser->driver->getKeyboard()->sendKeys('17');
            $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::TAB);
            $browser->driver->getKeyboard()->sendKeys('17');
            $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::TAB);
            $browser->driver->getKeyboard()->sendKeys('220');
            $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ESCAPE);

            $browser->typeSlowly('@tag-create-icon', 'mdi mdi-account')
                ->press('@tag-create-save')
                ->pause(1000);

            //Verify tag was saved
            $browser->click('@tag-edit-save')
                ->pause(1000)
                ->click('@tag-select')
                ->pause(2000)
                ->click('@tag-select')
                ->click('@tag-edit-save');

            //Save specimen
            $browser->driver->executeScript('window.scrollTo(0, 0);');
            $browser->click('@edit-button');
        });
    }

    /**
     * A Dusk test to verify tags can be added to specimans.
     *
     * @return void
     * @throws
     * @test
     * @group general
     * @group Sprint21
     * @group specimenOrgAdminSetTag
     *
     */
    public function specimenOrgAdminSetTag()
    {
        $user = $this->testAccounts["org-admin"];
        $this->browse(function ($browser) use ($user) {
            $browser->maximize();
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->pause(5000);
            //Setup Search parameters
            $browser->visit(new specimenPage)
                ->pause(5000);

            //Select current project to the first project in list.
            $browser->keys('@project-switcher-current-project',['{ARROW_DOWN}'])
                ->pause(1000)
                ->click()
                ->pause(1000)

                //Set Specimen Search to the first list item
                ->keys('@cora-search-options', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->click()
                ->pause(1000)

                //Set Search Option to the first list item
                ->keys('@cora-search-options-bones', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ARROW_DOWN}'])
                ->pause(1000)
                ->keys('@cora-search-options-bones', ['{ENTER}'])
                ->pause(1000)

                //search the set parameters
                ->press('@search-btn')
                ->pause(5000);

            //Assert redirect page is correct
            $browser->assertPathIs('/skeletalelements/search');

            //Wait for API calls
            $browser->pause(5000);

            //Select link from table
            $browser->with('.v-data-table', function($table) {
                $table->assertSee('Bone')
                    ->clickLink('CIL 2003-116:G-01:X-100:403')
                    ->pause(10000);
            });

            //Clicking the table link opens in a new window. Switch to new tab.
            $window = collect($browser->driver->getWindowHandles())->last();
            $browser->driver->switchTo()->window($window);
            $browser->assertPathIs('/skeletalelements/54611')
                ->pause(3000);

            //Enter Edit mode
            $browser->click('@edit-button');

            //Wait for edit mode
            $browser->pause(10000);

            //Assert page is in edit mode
            $browser->assertPathIs('/skeletalelements/54611/edit');

            //Add a tag
            $browser->driver->executeScript('window.scrollTo(0, 500);');

            $browser->pause(1000);

            $browser->click('@new-tag')
                ->pause(1000)
                ->click('@tag-create-set-org')
                ->typeSlowly('@tag-create-name', 'blue')
                ->typeSlowly('@tag-create-description', 'blue specimen')
                ->typeSlowly('@tag-create-category', 'uss oklahoma blue')
                ->press('@tag-create-select-color');

            //Color Picker is a vendor product used xpath in liu of dusk selectors
            $red = '//*[@id="vue-app"]/div[5]/div/div/div[2]/div/div[2]/div[2]/div[1]/input';
            $browser->driver->findElement(WebDriverBy::xpath($red))
                ->click();
            $browser->driver->getKeyboard()->sendKeys('17');
            $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::TAB);
            $browser->driver->getKeyboard()->sendKeys('17');
            $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::TAB);
            $browser->driver->getKeyboard()->sendKeys('220');
            $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ESCAPE);

            $browser->typeSlowly('@tag-create-icon', 'mdi mdi-account')
                ->press('@tag-create-save')
                ->pause(1000);

            //Verify tag was saved
            $browser->click('@tag-edit-save')
                ->pause(1000)
                ->click('@tag-select')
                ->pause(2000)
                ->click('@tag-select')
                ->click('@tag-edit-save');

            //Save specimen
            $browser->driver->executeScript('window.scrollTo(0, 0);');
            $browser->click('@edit-button');
        });
    }
}

