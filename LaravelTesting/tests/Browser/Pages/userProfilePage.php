<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class userProfilePage extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/user/18/profile';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',

            //Navigation elements
            '@user_dropdown' => '#app > header > nav > div.collapse.navbar-collapse > ul > li.nav-item.dropdown.headerMenuOptions > a',
            '@user_profile_menu' => '[dusk="profiles-menu"]',
            '@personal_settings_profile' => '[dusk="profileTab"]',
            '@personal_settings_general' => '[dusk="generalTab"]',
            '@personal_settings_projects' => '[dusk="projectsTab"]',
            '@personal_settings_notifications' => '[dusk="notificationsTab"]',
            '@personal_settings_localization' => '[dusk="localizationTab"]',
            '@personal_settings_lastlogon' => '[dusk="lastlogonTab"]',
            '@personal_settings_activityfeed' => '[dusk="user activityTab"]',

            //Change profile picture


            //Profile section
            '@profile_name' => '[dusk="name_text"]',
            '@profile_cell_phone' => '[dusk="cell_phone"]',
            '@profile_alt_phone' => '[dusk="phone"]',
            '@profile_update' =>  '[dusk="update_profile"]',

            //General section
            '@general_lines_per_page' =>  '[dusk="lines_per_page"]',
            '@general_show_welcome_screen' =>  '[dusk="show_welcome_screen"]',
            '@general_update' =>  '[dusk="update_general"]',

            //Projects section
            '@project_default_project' =>  '[dusk="default_project"]',
            '@project_default_laboratory' =>  '[dusk="default_laboratory"]',
            '@project_mru_list' =>  '[dusk="mru_list_skeletalelements"]',
            '@project_accession_number' =>  '[dusk="accession"]',
            '@project_provenance1' =>  '[dusk="provenance1"]',
            '@project_provenance2' =>  '[dusk="provenance2"]',
            '@project_se_search_new_tab' =>  '[dusk="se_search_open_in_new_browser_tab"]',
            '@project_se_redirect' =>  '[dusk="se_new_redirect_url"]',
            '@project_update' =>  '[dusk="update_projects"]',

            //Notifications section
            '@notifications_data_transfer_job' =>  '[dusk="complete_data_transfer_job"]',
            '@notifications_remains_review' =>  '[dusk="complete_remains_review"]',
            '@notifications_method_email' =>  '[dusk="email_notification"]',
            '@notifications_sms' =>  '[dusk="sms_notification"]',
            '@notifications_slack' =>  '[dusk="slack_notification"]',
            '@notifications_update' =>  '[dusk="update_notifications"]',

            //Localization section
            '@localization_home_country' =>  '[dusk="default_country"]',
            '@localization_language' =>  '[dusk="default_language"]',
            '@localization_update' =>  '[dusk="update_localization"]',

            //Last Logon section
            //no items currently

        ];
    }
}
