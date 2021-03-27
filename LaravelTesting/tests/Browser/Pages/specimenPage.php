<?php
/**
 * SkeletalElementsPage TestsBrowserPage
 *
 * @category   SkeletalElementsPage
 * @package    CoRA-TestsBrowserPage
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */
namespace Tests\Browser\Pages;
use Laravel\Dusk\Browser;
class specimenPage extends page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        //return '/skeletalelements';
        return '/';
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

            // New Search Bar Dusk Tags
            '@cora-project-switcher' => '[dusk="cora-project-switcher"]',
            '@cora-project-switcher-button' => '[dusk="cora-project-switcher-button"]',
            '@search-type-selector' => '[dusk="cora-search-options"]',
            '@cora-search-options' => '[dusk="cora-search-options"]',
            '@cora-search-options-bones' => '[dusk="cora-search-options-bones"]',
            '@cora-search-options-accessions' => '[dusk="cora-search-options-accessions"]',
            '@cora-search-options-provenance1' => '[dusk="cora-search-options-provenance1"]',
            '@cora-search-options-provenance2' => '[dusk="cora-search-options-provenance2"]',
            '@cora-search-options-individual-number' => '[dusk="cora-search-options-individual-number"]',
            '@cora-search-options-tags' => '[dusk="cora-search-options-tags"]',
            '@cora-search-datatable' => '[dusk="search-datatable"]',
            '@cora-search' => '[dusk="cora-search"]',
            '@cora-search-button' => '[dusk="cora-search-button"]',
            '@cora-search-btn' => '[dusk="cora-search-btn"]',
            '@search-btn' => '[dusk="search-btn"]',
            '@cora-search-accessions' => '#accessions',
            '@sidebar-collapse' => '#sidebarCollapse',
            //'@se-menu' => '@se-menu',
            '@se-advance-search' => '[dusk="se-advance_search"]',
            '@item.text' =>'[dusk="item.text"]',


            // Navigation Menu Dusk Tags
            '@se-details-menu' => '[dusk="se-details-menu"]',
            '@se-biological-profile-menu' => '[dusk="se-biological-profile-menu"]',
            '@se-age-menu' => '[dusk="se-age-menu"]',
            '@se-sex-menu' => '[dusk="se-sex-menu"]',
            '@se-stature-menu' => '[dusk="se-stature-menu"]',
            '@se-ancestry-menu' => '[dusk="se-ancestry-menu"]',
            '@se-taphonomys-menu' => '[dusk="se-taphonomys-menu"]',
            '@se-zones-menu' => '[dusk="se-zones-menu"]',
            '@se-measurements-menu' => '[dusk="se-measurements-menu"]',
            '@se-associations-menu' => '[dusk="se-associations-menu"]',
            '@se-articulations-menu' => '[dusk="se-articulations-menu"]',
            '@se-pairs-menu' => '[dusk="se-pairs-menu"]',
            '@se-refits-menu' => '[dusk="se-refits-menu"]',
            '@se-morphology-menu' => '[dusk="se-morphology-menu"]',
            '@se-pathology-menu' => '[dusk="se-pathology-menu"]',
            '@se-traumas-menu' => '[dusk="se-traumas-menu"]',
            '@se-pathologys-menu' => '[dusk="se-pathologys-menu"]',
            '@se-anomalys-menu' => '[dusk="se-anomalys-menu"]',
            '@se-review-menu' => '[dusk="se-review-menu"]',
            '@rightsidebar-expand' => '[dusk="rightSideBar-menu"]',
            '@leftsidebar-expand' => '[dusk="leftSideBar-menu"]',

            //Tags and comments
            '@comment-tag' => '[dusk="comment-tag"]',
            '@comment-text' => '[dusk="comment-text"]',
            '@tag_button' =>'[dusk="tag_button"]',
            '@comment-save' => '[dusk="comment-save"]',
            '@tag-edit-save' =>'[dusk="tag-edit-save"]',
            '@tag-reset' =>'[dusk="tag-reset"]',
            '@tag-select' =>'[dusk="tag-select"]',

            //Tag Create
            '@tag-create-project' => '[dusk="tag-select-project"]',
            '@tag-create-set-org' =>'[dusk="tag-set-org"]',
            '@tag-create-name' => '[dusk="tag-name"]',
            '@tag-create-description' => '[dusk="tag-description"]',
            '@tag-create-category' => '[dusk="tag-category"]',
            '@tag-create-set-tag-type' => '[dusk="set-tag-type"]',
            '@tag-create-select-color' => '[dusk="tag-color-selector"]',
            '@tag-color-picker' => '[dusk="tag-color-picker"]',
            '@tag-create-icon' => '[dusk="tag-icon"]',
            '@tag-create-new' => '[dusk="new-tag"]',
            '@tag-create-save' => '[dusk="tag-save"]',



            //Actions Buttons on Specimens
            '@actions-button' => '[dusk="actions-button"]',
            '@actions-create-menu' =>'[dusk="actions-create-menu"]',
            '@actions-edit-menu' =>'[dusk="actions-edit-menu"]',
            '@actions-save' => '#save',
            '@new-button' =>'[dusk="new-button"]',
            '@edit-button' =>'[dusk="edit-button"]',
            '@save-button' =>'[dusk="save-button"]',
            '@delete-button' =>'[dusk="delete-button"]',
            '@reset-button' =>'[dusk="reset-button"]',
            '@generate-button' =>'[dusk="generate-button"]',
            '@rest-dashboard-button' =>'[dusk="reset-dashboard-button"]',

            //report
            '@accession-report' => '[dusk="accession-report"]',
            '@provenance1-report' => '[dusk="provenance1-report"]',
            '@provenance2-report' => '[dusk="provenance2-report"]',
            '@bone-report' => '[dusk="bone-report"]',
            '@bone-side-report' => '[dusk="bone-side-report"]',
            '@group-report' => '[dusk="group-report"]',
            '@group-side-report' => '[dusk="group-side-report"]',
            '@search-se-btn' =>'[dusk="search-se-btn"]',
            '@specimen-report' =>'[dusk="specimen-report"]',
            '@excel' =>'[dusk="excel"]',
            '@column-visibility' =>'[dusk="column-visibility"]',
            '@header.text' =>'[dusk="header.text"]',
            '@collapse-button' =>'[dusk="collapse-button"]',
            '@project-report-button' => '#vue-app > div.v-application--wrap > nav > nav.v-navigation-drawer.v-navigation-drawer--clipped.v-navigation-drawer--fixed.v-navigation-drawer--is-mobile.v-navigation-drawer--open.v-navigation-drawer--temporary.theme--light > div.v-navigation-drawer__content > div > a:nth-child(7) > div.v-list-item__title',







            // Search Functionality Tags
            '@searchstring' => '@searchstring',
            '@se-menu' => '[dusk="se-menu"]',
            '@se-search' => '[dusk="se-search"]',
            '@se-search-icon' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-header > form > div > div > div > div > button',
            '@se-new' => '[dusk="se-new"]',

            '@se-new-group' => '[dusk="se-new-group"]',
            '@se-method-create' => '@se-method-create',
            '@se-methods-select' => '@se-methods-select',
            '@se-method-save' => '@se-method-save',
            '@se-reports-dashboard' => '[dusk="se-reports_dashboard"]',
            '@report.type' => '[dusk="report.type"]',
            '@se-advanced-search' => '[dusk="se-advance_search"]',
            '@se-search-box' => '#DataTables_Table_0_filter > label > input',
            '@se-key-sort' => '#DataTables_Table_0 > thead > tr > th.sorting_asc',
            '@se-bone-sort' => '#DataTables_Table_0 > thead > tr > th:nth-child(2)',
            '@se-side-sort' => '#DataTables_Table_0 > thead > tr > th:nth-child(3)',
            '@se-DNA-sampled-sort' => '#DataTables_Table_0 > thead > tr > th:nth-child(4)',
            '@se-entries' => '#DataTables_Table_0_length > label > select',

            '@se-entries10' => '#DataTables_Table_0_length > label > select > option:nth-child(1)',
            '@se-entries25' => '#DataTables_Table_0_length > label > select > option:nth-child(2)',
            '@se-entries50' => '#DataTables_Table_0_length > label > select > option:nth-child(3)',
            '@se-entries100' => '#DataTables_Table_0_length > label > select > option:nth-child(4)',
            '@se-page-previous' => '#DataTables_Table_0_previous > a',
            '@se-page-next' => '#DataTables_Table_0_next > a',
            '@se-page1' => '#DataTables_Table_0_paginate > ul > li:nth-child(2) > a',
            '@se-page2' => '#DataTables_Table_0_paginate > ul > li:nth-child(3) > a',
            '@se-page3' => '#DataTables_Table_0_paginate > ul > li:nth-child(4) > a',
            '@se-next'=>'//*[@id="vue-app"]/div[1]/main/div/div/div/div/div/div[4]/div[2]/div[4]/button[1]',
            '@se-next' => '[dusk="se-next"]',
            '@se-next1' => '[dusk="se-next1"]',
            '@se-previous1' =>'[dusk="se-previous"]',
            '@se-previous' =>'//*[@id="vue-app"]/div[1]/main/div/div/div/div/div/div[4]/div[2]/div[3]/button[2]',
            '@se-firstpage' => '//*[@id="vue-app"]/div[1]/main/div/div/div/div/div/div[4]/div[2]/div[3]/button[1]',
            '@se-lastpage' => '//*[@id="vue-app"]/div[1]/main/div/div/div/div/div/div[4]/div[2]/div[4]/button[2]',

            // Specimen Attribute Tags
            '@accession-number' => '[dusk="se-accession"]',
            '@provenance1' => '[dusk="se-provenance1"]',
            '@provenance2' => '[dusk="se-provenance2"]',
            '@designator' => '[dusk="se-designator"]',
            '@se-bone' => '[dusk="se-bone"]',
            '@se-side' => '[dusk="se-side"]',
            '@se-completeness' => '[dusk="se-completeness"]',
            '@se-count' => '[dusk="se-count"]',
            '@se-mass' => '[dusk="se-mass"]',
            '@se-measured' => '[dusk="se-measured"]',
            '@se-dna-sampled' => '[dusk="se-dna_sampled"]',
            '@se-isotope-sampled' => '[dusk="se-isotope_sampled"]',
            '@se-inventoried' => '[dusk="se-inventoried"]',
            '@se-created' => '[dusk="se-created"]',
            '@se-reviewedBy' => '[dusk="se-reviewedBy"]',
            '@se-reviewed' => '[dusk="se-reviewed"]',
            '@se-ct-scanned' => '[dusk="se-ct_scanned"]',
            '@se-xray-scanned' => '[dusk="se-xray_scanned"]',
            '@se-clavicle-triage' => '[dusk="se-clavicle_triage"]',
            '@se-individual-number' => '[dusk="se-individual_number"]',
            '@ct_scanned_date' =>'[dusk="ct_scanned_date"]',
            '@se-3d_scanned' => '[dusk="se-3d_scanned"]',
            '@se-identification_date' =>  '[dusk="se-identification_date"]',
            '@se-remains_status' => '[dusk="se-remains_status"]',
            '@remains_release_date' => '[dusk="remains_release_date"]',
            '@xray_scanned_date' => '[dusk="xray_scanned_date"]',
            '@3D_scanned_date' =>'[dusk="3D_scanned_date"]',
            '@se-inventory_date' =>'[dusk="se-inventory_date"]',
            '@se-inventory_completed' =>'[dusk="se-inventory_completed"]',

            //Isotope Create Tags
            '@iso-lab' => '[dusk="iso-lab"]',
            '@iso-ext-case' => '[dusk="iso-ext-case"]',
            '@iso-sample' => '[dusk="iso-sample"]',
            '@isoanalysis-save' => '[dusk="isoanalysis-save"]',

            //se-accession Codes
            '@dental-collapse' =>'[dusk="dental-collapse"]',
            '@primary-tab' => '[dusk="primary-tab"]',
            '@secondary-tab' => '[dusk="secondary-tab"]',
            '@primary-switch' => '[dusk="primary-switch"]',
            '@secondary-switch' => '[dusk="secondary-switch"]',
            '@numbering-system' => '[dusk="numbering-system"]',
            '@tooth-selection' => '[dusk="tooth-selection"]',
            '@dental-codes' => '[dusk="dental-codes"]',
            '@teeth' => '[dusk="teeth"]',
            '@save-edit' => '[dusk="save-edit"]',
            '@save-add' => '[dusk="save-add"]',

            '@se-taphonomy' => '[dusk="se-taphonomys"]',
            '@se-pathologys' => '[dusk="se-pathologys"]',
            '@se-traumas' => '[dusk="se-traumas"]',
            '@se-bone-grouping' => '[dusk="se-bone-grouping"]',
            '@se-select-bone1' => '#list-item-282-0',
            '@se-pathology-select1' => '[dusk="se-pathology-select"]',
            '@se-taph' => '[dusk="se-taph"]',
            '@se-path' => '[dusk="se-path"]',
            '@se-trauma' => '[dusk="se-trauma"]',
            '@clear-se-taph' => '[dusk="se-taph"]',
            '@clear-se-path' => '[dusk="se-path"]',
            '@clear-se-trauma' => '[dusk="se-trauma"]',



            //Review
            '@methods-review-accept' => '[dusk = "methods-review-accept"]',
            '@general-badge' => '[dusk="general-badge"]',
            '@se-completeness' =>'[dusk="se-completeness"]',
            '@review-general' => '[dusk="review-general"]',
            '@biological-review' => '[dusk="biological-review"]',
            '@dna-review' => '[dusk="dna-review"]',
            '@general-step' => '[dusk="general-step"]',
            '@taphonomy-review' =>'[dusk = "taphonomy-review" ]',
            '@taphonomy-step' =>'[dusk="taphonomy-step"]',
            '@review-taphonomy' =>'[dusk="review-taphonomy"]',
            '@zones-step' =>'[dusk="zones-step"]',
            '@measurements-step' =>'[dusk="measurements-step"]',
            '@associations-step' =>'[dusk="associations-step"]',
            '@articulations-review' =>'[dusk="articulations-review"]',
            '@articulations-panel' =>'[dusk="articulations-panel"]',
            '@pairmatching-panel' =>'[dusk="pairmatching-panel"]',
            '@refits-panel' =>'[dusk="refits-panel"]',
            '@morphology-panel' =>'[dusk="morphology-panel"]',
            '@pathology-review' =>'[dusk="pathology-review"]',
            '@pathology-panel' =>'[dusk="pathology-panel"]',
            '@trauma-panel' =>'[dusk="trauma-panel"]',
            '@anomaly-panel' =>'[dusk="anomaly-panel"]',
            '@bone-review' =>'[dusk="bone-review"]',
            '@side-review' =>'[dusk="side-review"]',
            '@completeness-review' =>'[dusk="completeness-review"]',
            '@review-save' =>'[dusk="review-save"]',
            '@review-accept' =>'[dusk="review-accept"]',
            '@dna-expansion' =>'[dusk="dna-expansion"]',
            '@samplenumber-review' =>'[dusk="samplenumber-review"]',
            '@externalcasenumber-review' =>'[dusk="externalcasenumber-review"]',
            '@lab-review' =>'[dusk="lab-review"]',
            '@requestdate-review' =>'[dusk="requestdate-review"]',
            '@resultdate-review' =>'[dusk="resultdate-review"]',
            '@resampling-review' =>'[dusk="resampling-review"]',
            '@dna-save-review' =>'[dusk="dna-save-review"]',


            //mito dna review
            '@mito-review' =>'[dusk="mito-review"]',
            '@austr-review' =>'[dusk="austr-review"]',
            '@ystr-review' =>'[dusk="ystr-review"]',
            '@mitomethod-review' =>'[dusk="mitomethod-review"]',
            '@mitorequestdate-review' =>'[dusk="mitorequestdate-review"]',
            '@mitoreceivedate-review' =>'[dusk="mitoreceivedate-review"]',
            '@mito-result-confidence-review' =>'[dusk="mito-result-confidence-review"]',
            '@mito-seq-number-review' =>'[dusk="mito-seq-number-review"]',
            '@mito-seq-subgroup-review' =>'[dusk="mito-seq-subgroup-review"]',
            '@mito-base-pairs-review' =>'[dusk="mito-base-pairs-review"]',
            '@mito-total-count-review' =>'[dusk="mito-total-count-review"]',
            '@mito-match-count-review' =>'[dusk="mito-match-count-review"]',
            '@mito-confirmed-region-review' =>'[dusk="mito-confirmed-region-review"]',
            '@mito-polymorphisms-review' =>'[dusk="mito-polymorphisms-review"]',
            '@mito-haplosubgroup-review' =>'[dusk="mito-haplosubgroup-review"]',
            '@mito-mcc-date-review' =>'[dusk="mito-mcc-date-review"]',
            '@mito-seq-similiar-review' =>'[dusk="mito-seq-similiar-review"]',
            '@mito-num-loci-review' =>'[dusk="mito-num-loci-review"]',
            '@mito-save-review' =>'[dusk="mito-save-review"]',

            //austr dna review
            '@austrmethod-review' =>'[dusk="austrmethod-review"]',
            '@austrrequestdate-review' =>'[dusk="austrrequestdate-review"]',
            '@austrreceivedate-review' =>'[dusk="austrreceivedate-review"]',
            '@austr-result-confidence-review' =>'[dusk="austr-result-confidence-review"]',
            '@austr-seq-number-review' =>'[dusk="austr-seq-number-review"]',
            '@austr-seq-subgroup-review' =>'[dusk="austr-seq-subgroup-review"]',
            '@austr-seq-similiar-review' =>'[dusk="austr-seq-similiar-review"]',
            '@austr-num-loci-review' =>'[dusk="austr-num-loci-review"]',
            '@austr-loci-review' =>'[dusk="austr-loci-review"]',
            '@austr-mcc-date-review' =>'[dusk="austr-mcc-date-review"]',
            '@austr-save-review' =>'[dusk="austr-save-review"]',

            //ystr dna review
            '@ystrmethod-review' =>'[dusk="ystrmethod-review"]',
            '@ystrrequestdate-review' =>'[dusk="ystrrequestdate-review"]',
            '@ystrreceivedate-review' =>'[dusk="ystrreceivedate-review"]',
            '@ystr-result-confidence-review' =>'[dusk="ystr-result-confidence-review"]',
            '@ystr-seq-number-review' =>'[dusk="ystr-seq-number-review"]',
            '@ystr-seq-similiar-review' =>'[dusk="ystr-seq-similiar-review"]',
            '@ystr-num-loci-review' =>'[dusk="ystr-num-loci-review"]',
            '@ystr-loci-review' =>'[dusk="ystr-loci-review"]',
            '@ystr-total-count-review' =>'[dusk="ystr-total-count-review"]',
            '@ystr-haplosubgroup-review' =>'[dusk="ystr-haplosubgroup-review"]',
            '@ystr-mcc-date-review' =>'[dusk="ystr-mcc-date-review"]',
            '@ystr-save-review' =>'[dusk="ystr-save-review"]',
            '@dna-review-save' =>'[dusk = "dna-review-save"]',

            //taphonomy review
            '@taphonomy-review-save' =>'[dusk="taphonomy-review-save"]',
            '@taphonomy-review-accept' =>'[dusk="taphonomy-review-save"]',
            //zones review
            '@zones-switch-review-1 - Superior portion of acetabulum' =>'[dusk="zones-switch-review-1 - Superior portion of acetabulum"]',
            '@zones-switch-review-3 - Anterior half of the inferior portion' => '[dusk=@zones-switch-review-3 - Anterior half of the inferior portion"]',
            '@zones-switch-review' =>'[dusk="zones-switch-review"]',
            '@zones-review-save' =>'[dusk="zones-review-save"]',
            '@zones-review-accept' =>'[dusk="zones-review-accept"]',
            //measurements review
            '@measurements-review-save' =>'[dusk="measurements-review-save"]',
            '@measurements-review-accept' =>'[dusk="measurements-review-accept"]',
            '@measurements-review-101' =>'[dusk="measurements-review-101"]',
            '@measurements-review-102' =>'[dusk="measurements-review-102"]',
            '@measurements-review-103' =>'[dusk="measurements-review-103"]',
            '@measurements-review-104' =>'[dusk="measurements-review-104"]',
            '@measurements-review-105' =>'[dusk="measurements-review-105"]',
            '@measurements-review-106' =>'[dusk="measurements-review-106"]',
            '@measurements-review-107' =>'[dusk="measurements-review-107"]',
            '@measurements-review-108' =>'[dusk="measurements-review-108"]',
            '@measurements-review-109' =>'[dusk="measurements-review-109"]',
            '@measurements-review-110' =>'[dusk="measurements-review-110"]',
            '@measurements-review-111' =>'[dusk="measurements-review-111"]',
            '@measurements-review-112' =>'[dusk="measurements-review-112"]',
            '@measurements-review-113' =>'[dusk="measurements-review-113"]',
            '@measurements-review-114' =>'[dusk="measurements-review-114"]',
            '@measurements-review-115' =>'[dusk="measurements-review-115"]',
            '@measurements-review-116' =>'[dusk="measurements-review-116"]',
            '@measurements-review-117' =>'[dusk="measurements-review-117"]',
            '@measurements-review' =>'[dusk="measurements-review"]',
            //association review
            '@association-review-option' =>'[dusk="association-review-option"]',
            '@association-review-save' =>'[dusk="association-review-save"]',
            '@association-review-accept' =>'[dusk="association-review-accept"]',
            //anomaly review
            '@anomaly-review-option' =>'[dusk="anomaly-review-option"]',
            '@anomaly-review-save' =>'[dusk="anomaly-review-save"]',
            '@anomaly-review-accept' =>'[dusk="anomaly-review-accept"]',
            //trauma review
            '@trauma-zone-review' =>'[dusk="trauma-zone-review"]',
            '@trauma-state-review' =>'[dusk="trauma-state-review"]',
            '@trauma-add-info-review' =>'[dusk="trauma-add-info-review"]',
            '@trauma-review-save' =>'[dusk="trauma-review-save"]',
            '@trauma-review-accept' =>'[dusk="trauma-review-accept"]',

            //pathology review
            '@pathology-zone-review' =>'[dusk="pathology-zone-review"]',
            '@pathology-state-review' =>'[dusk="pathology-state-review"]',
            '@pathology-add-info-review' =>'[dusk="pathology-add-info-review"]',
            '@pathology-review-save' =>'[dusk="pathology-review-save"]',
            '@pathology-review-accept' =>'[dusk="pathology-review-accept"]',
            //specimen highlight
            '@specimenhighlight-review' =>'[dusk="specimenhighlight-review"]',
            '@taphonomy-menu' => '#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.v-card__text > div > div:nth-child(8) > div > div > div > div.v-card__text > div > div:nth-child(2) > div > div > div.v-input__slot > div.v-select__slot > div.v-input__append-inner > div > i',
            '@zones-switch6' => '#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.v-card__text > div > div:nth-child(10) > div > div > div > div.v-card__text > div > div:nth-child(2) > div:nth-child(6) > div > div.v-input__slot > label',
            '@2-caputswitch'=>'#vue-app > div > main > div > div > div > div > div > div:nth-child(3) > div.v-card__text > div > div:nth-child(10) > div > div > div > div.v-card__text > div > div:nth-child(2) > div:nth-child(2) > div > div.v-input__slot > label',
            '@measurement-test' =>'#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.v-card__text > div > div:nth-child(12) > div > div > div > div > div.v-card__text > div > div:nth-child(2) > form > div:nth-child(2) > div > div.v-input__slot > div > label',
            '@articulations-menu' =>'#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.v-card__text > div > div:nth-child(14) > div > div:nth-child(1) > div > div > div > div > div > div > div > div.v-card__text > div > div:nth-child(2) > div > div > div.v-input__slot > div.v-select__slot > div.v-input__append-inner > div > i',
            '@pairmatching-menu' => '#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.v-card__text > div > div:nth-child(14) > div > div:nth-child(2) > div > div > div > div > div > div > div > div.v-card__text > div > div:nth-child(2) > div > div > div.v-input__slot > div.v-select__slot > div.v-input__append-inner > div > i',
            '@refits-menu' =>'#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.v-card__text > div > div:nth-child(14) > div > div:nth-child(3) > div > div > div > div > div > div > div > div.v-card__text > div > div:nth-child(2) > div > div > div.v-input__slot > div.v-select__slot > div.v-input__append-inner > div > i',
            '@anomaly-menu' =>'#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.v-card__text > div > div:nth-child(16) > div > div:nth-child(3) > div > div > div > div > div > div > div.v-card__text > div > div:nth-child(2) > div > div > div.v-input__slot > div.v-select__slot > div.v-input__append-inner > div > i',
            '@trauma-selection'=> '#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.v-card__text > div > div:nth-child(16) > div > div:nth-child(2) > div > div > div > div > div > div > div.v-card__text > div > div > button',

            // New Group Specimens
            '@se-grouping' => '#bone_grouping',
            '@se-bone-select' => '#bone_select',
            '@se-trauma-select' => '#trauma_select',
            '@se-pathology-select' => '#pathology_select',
            '@se-taphonomy-select' => '#taphonomy_select',
            '@accession-number-group' => '#accession_number',
            '@provenance1-group' => '#provenance1',
            '@provence2-group' => '#provenance2',
            '@side-group' => '#side',
            '@completeness-group' => '#completeness',
            '@save-group' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form > div:nth-child(13) > div > button',
            '@se-bone-group-save' => '[dusk="se-bone_group-save"]',


            // Biological Profile Tags
            '@se-feature-score-select-0' => '[dusk="se-feature_score_select-0"]',
            '@se-feature-score-select-1' => '[dusk="se-feature_score_select-1"]',
            '@se-feature-score-select-2' => '[dusk="se-feature_score_select-2"]',
            '@se-feature-score-select-3' => '[dusk="se-feature_score_select-3"]',


            // DNA Profile Tags
            //'@se-dna-profile-menu' => '#toggleAppContent > div > div > div > div > div.card-header > div > div.float-left.col-4 > div ex> ul > li:nth-child(2) > a',
            '@se-dna-profile-menu' => '[dusk="se-dna-menu-2"]',
            '@dna-lab' => '@dna-lab',
            '@external-case-number' => '[dusk="dna-external_case"]',
            '@sample-number' => '[dusk="dna-sample_number"]',
            '@dna-mito-receive-date' => '[dusk="dna-mito_receive_date"]',
            '@dna-results-confidence' => '[dusk="dna-mito_results_confidence"]',
            '@dna-mito-sequence-number' => '[dusk="dna-mito_sequence_number"]',
            '@dna-mito-sequence-subgroup' => '[dusk="dna-mito_sequence_subgroup"]',
            '@dna-mito-sequence-similar' => '[dusk="dna-mito_sequence_similar"]',
            '@dna-mito-match-count' => '[dusk="dna-mito_match_count"]',
            '@dna-mito-total-count' => '[dusk="dna-mito_total_count"]',
            '@dna-mito-haplogroup' => '[dusk="dna-mito_haplogroup"]',
            '@dna-save' => '@dna-save',
            '@mito-save' => '[dusk="dna-save-form"]',
            '@dna-menu' => '[dusk="dna-menu"]',
            '@dna-search' => '[dusk="dna-search"]',
            '@dna-mt-dna' => '[dusk="dna-mtDNA"]',
            //#pageSubmenu > li:nth-child(2) > a

            '@dna-projects' => '[dusk="dna-projects"]',
            '@dna-priority' => '[dusk="dna-priority"]',
            '@dna-result-status' => '[dusk="dna-result-status"]',
            '@dna-sequence-number' => '[dusk="dna-sequence-number"]',
            '@dna-subgroup' => '[dusk="dna-subgroup"]',
            '@dna-request-date-start' => '[dusk="dna-request-date-start"]',
            '@dna-request-date-end' => '[dusk="dna-request-date-end"]',
            '@dna-receive-date-start' => '[dusk="dna-receive-date-start"]',
            '@dna-receive-date-end' => '[dusk="dna-receive-date-end"]',

            // Additional Test Dusk Tags
            '@dna-additional-test-create' => '[dusk="dna-additional_test-create"]',
            '@dna-analysistest_type' => '[dusk="dna-analysistest_type"]',
            '@dna-region-request-date' => '[dusk="dna-region_request_date"]',
            '@dna-region-results' => '[dusk="dna-region_results"]',
            '@dna-region-receive-date' => '[dusk="dna-region_receive_date"]',
            '@dna-analysis-save' => '[dusk="dna-analysis-save"]',
            '@dna-analysis-action-menu' => '[dusk="dna-analysis-action-menu"]',
            '@dna-analysis-edit-menu' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-header > div > ul > li > a',


            // Resample Dusk Tags
            '@dna-resampling-create' => '[dusk="dna-resampling-create"]',
            '@dna-resample-number' => '[dusk="dna-resample-number"]',
            '@dna-resample-request-date' => '[dusk="dna-resample-request_date"]',
            '@dna-resample-results' => '[dusk="dna-resample-results"]',
            '@dna-resample-receive-date' => '[dusk="dna-resample-receive"]',
            '@dna-resample-save' => '[dusk="dna-resample-save"]',
            '@dna-resampling-action-menu' => '[dusk="dna-resampling-action-menu"]',
            '@dna-resampling-edit-menu' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-header > div > ul > li > a',


            // Taphonomy Tags
            '@taphonomy-actions-edit' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-header > div > ul',
            '@taphonomy-delete' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > div > div.col-lg-12.form-group.taphonomys > span > span.selection > span > ul > li.select2-selection__choice > span',
            '@se-taphonomy-save' => '@se-taphonomy-save',
            '@se-taphonomy-list' => '@se-taphonomy-list',
            '@se-taphonomy-edit' => '@se-taphonomy-edit',
            '@se-taphonomy-reset' => '@se-taphonomy-reset',
            '@se-taphonomy-collapse' => '@se-taphonomy-collapse',


            // Zones
            '@zones-edit-button' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-header > div > ul > li > a',
            '@se-zone-save' => '@se-zone-save',
            '@se-zone-checkbox' => '@se-zone-checkbox',
            '@se-zone-switch' => '@se-zone-switch',
            '@se-zone-collapse' => '@se-zone-collapse',
            '@se-zone-edit' => '@se-zone-edit',
            '@se-zone-saveButton' => '@se-zone-saveButton',
            '@se-zone-resetUndo' =>  '@se-zone-resetUndo',
            '@se-zone-coraDoc' => '@se-zone-coraDoc',
            '@se-zone-select-all-checkbox' => '#vue-app > div > main > div > div > div > div > form > div > div:nth-child(3) > div > div > div > div:nth-child(3) > div > div > div > div.v-input__slot > label',
            '@se-zone-Tuber-calcis'  => '#vue-app > div > main > div > div > div > div > form > div > div:nth-child(3) > div > div > div > div:nth-child(4) > div > div:nth-child(1) > div > div.v-input__slot > label',
            '@se-zone-Distal-portion-of-the-body'  => '#vue-app > div > main > div > div > div > div > form > div > div:nth-child(3) > div > div > div > div:nth-child(4) > div > div:nth-child(2) > div > div.v-input__slot > label',
            '@se-zone-Proximal-articulation'  => '#vue-app > div > main > div > div > div > div > form > div > div:nth-child(3) > div > div > div > div:nth-child(4) > div > div:nth-child(3) > div > div.v-input__slot > label',
            '@se-zone-Sustentaculum-tali'  => '#vue-app > div > main > div > div > div > div > form > div > div:nth-child(3) > div > div > div > div:nth-child(4) > div > div:nth-child(4) > div > div.v-input__slot > label',
            '@se-zone-Proximal-portion-of-the-body'  => '#vue-app > div > main > div > div > div > div > form > div > div:nth-child(3) > div > div > div > div:nth-child(4) > div > div:nth-child(5) > div > div.v-input__slot > label',
            '@1 - Head' => '[dusk="@1 - Head"]',



            //zonereport
            '@se-zone-accession' =>'@se-zone-accession',
            '@se-zone-provenance1' => '@se-zone-provenance1',
            '@se-zone-provenance2' =>  '@se-zone-provenance2' ,
            '@se-zone-bone' => '@se-zone-bone',
            '@se-zone-side' =>  '@se-zone-side',
            '@se-zone-zone' =>   '@se-zone-zone',
            '@se-zone-search'  =>     '@se-zone-search',
            '@se-zone-search-datatable' => '@se-zone-search-datatable',
            '@se-zone-contentheader' => '@se-zone-contentheader',
            '@selectprojectReports' => '#vue-app > div.v-application--wrap > nav > nav.v-navigation-drawer.v-navigation-drawer--clipped.v-navigation-drawer--fixed.v-navigation-drawer--is-mobile.v-navigation-drawer--open.v-navigation-drawer--temporary.theme--light > div.v-navigation-drawer__content > div > a:nth-child(7) > div.v-list-item__title',
            '@se-zone-zoneTextCombo' => '#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.container.container--fluid > div:nth-child(3) > div:nth-child(1) > div > div > div.v-input__slot',
            '@se-zone-zoneText' => '#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.container.container--fluid > div:nth-child(3) > div:nth-child(1) > div > div > div.v-input__slot',
            '@se-zone-zoneTextChoice' => '#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.container.container--fluid > div:nth-child(3) > div:nth-child(1) > div > div > div.v-input__slot > div.v-select__slot > label',
            '@se-zone-rib'  => '#vue-app > div > main > div > div > div > div > form > div > div:nth-child(3) > div > div > div > div:nth-child(4) > div > div:nth-child(5) > div > div.v-input__slot > label',

            //traumaReport
            '@se-trauma-accession' =>'@se-trauma-accession',
            '@se-trauma-provenance1' =>'@se-trauma-provenance1',
            '@se-trauma-provenance2' =>'@se-trauma-provenance2',
            '@se-trauma-contentheader' =>'@se-trauma-contentheader',
            '@se-trauma-select-1' =>'@se-trauma-select',
            '@se-trauma-bone' =>'@se-trauma-bone',
            '@se-trauma-side' =>'@se-trauma-side',
            '@se-trauma-search-datatable' =>'@se-trauma-search-datatable',
            '@se-trauma-select-new' =>'#vue-app > div.v-application--wrap > main > div > div > div > div > div > div:nth-child(3) > div.container.container--fluid > div:nth-child(2) > div > div > div > div.v-input__slot > div.v-select__slot > div.v-select__selections',



            //'@zones-save' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > div.form-group > div > button',
            //'@zones-actions-button' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-header > div > button',


            // Association Tags
            '@associations-actions-button' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-header > div > button',
            '@associations-edit-button' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-header > div > ul > li > a',
            '@se-articulation-list' => '@se-articulation-list',
            '@se-articulations-edit' => '@se-articulations-edit',
            '@se-articulation-save' => '@se-articulation-save',
            '@se-pairs-list' => '@se-pairs-list',
            '@se-pairs-edit' => '@se-pairs-edit',
            '@se-pairs-save' => '@se-pairs-save',
            '@se-refits-list' => '@se-refits-list',
            '@se-refits-edit' => '@se-refits-edit',
            '@se-refits-save' => '@se-refits-save',

            '@se-morphology-list' => '@se-morphology-list',
            '@se-morphology-edit' => '@se-morphology-edit',
            '@se-morphology-save' => '@se-morphology-save',



            // Pathology Tags
            '@create-button' => '@create-button',
            '@se-trauma-menu' => '@se-trauma-menu',
            '@se-trauma-zone' => '@se-trauma-zone',
            '@se-trauma-trauma' => '@se-trauma-trauma',
            '@se-trauma-edit' => '@se-trauma-edit',
            '@se-trauma-additional-info' => '[dusk="se-trauma-additional_info"]',
            '@se-trauma-save' => '@se-trauma-save',
            '@se-pathology-zone' => '@se-pathology-zone',
            '@se-pathology' => '@se-pathology',
            '@se-pathology-additional-info' => '[dusk="se-pathology-additional_info"]',
            '@se-pathology-save' => '@se-pathology-save',
            '@se-anomaly-list' => '@se-anomaly-list',
            '@se-anomalys-edit-button' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-header > div > ul > li > a',
            '@se-anomaly-save' => '@se-anomaly-save',


            // Measurements Tags
            '@se-measurement-menu' => '@se-measurement-menu',
            '@se-measurements-edit-button-1' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-header > div > ul > li',
            //'@se-measurement-0' => '@se-measurement-0',
            //'@se-measurement-0' => '[dusk="se-measurement-0"]',
            //'@se-measurement-1' => '[dusk="se-measurement-1"]',
            //'@se-measurement-2' => '[dusk="se-measurement-2"]',
            //'@se-measurement-3' => '[dusk="se-measurement-3"]',
            //'@se-measurement-4' => '[dusk="se-measurement-4"]',
            //'@se-measurement-5' => '[dusk="se-measurement-5"]',
            //'@se-measurement-6' => '[dusk="se-measurement-6"]',
            //'@se-measurement-7' => '[dusk="se-measurement-7"]',
            //'@se-measurement-8' => '[dusk="se-measurement-8"]',
            //'@se-measurement-save' => '@se-measurement-save',
            '@se-measurements-edit-button-2' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(3) > div > div.card-header > div > ul > li > a',
            '@se-measurement-0' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > fieldset:nth-child(3) > div > div > input.col-md-12.form-control.measurement',
            '@se-measurement-1' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > fieldset:nth-child(4) > div > div > input.col-md-12.form-control.measurement',
            '@se-measurement-2' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > fieldset:nth-child(5) > div > div > input.col-md-12.form-control.measurement',
            '@se-measurement-3' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > fieldset:nth-child(6) > div > div > input.col-md-12.form-control.measurement',
            '@se-measurement-4' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > fieldset:nth-child(7) > div > div > input.col-md-12.form-control.measurement',
            '@se-measurement-5' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > fieldset:nth-child(8) > div > div > input.col-md-12.form-control.measurement',
            '@se-measurement-6' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > fieldset:nth-child(9) > div > div > input.col-md-12.form-control.measurement',
            '@se-measurement-7' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > fieldset:nth-child(10) > div > div > input.col-md-12.form-control.measurement',
            '@se-measurement-8' => '#app > div > div.container-fluid.app-content > div > div > div > div > div.card-body > form:nth-child(2) > div > div.card-body > fieldset:nth-child(11) > div > div > input.col-md-12.form-control.measurement',

            // Advanced Reports Tags
            //'@report-go-advanced' => '[dusk="report-go-0"]',
            '@report-go-mt-dna' => '[dusk="report-go-0"]',
            '@report-go-zones' => '[dusk="report-go-1"]',
            '@report-go-methods' => '[dusk="report-go-2"]',
            '@report-go-measurements' => '[dusk="report-go-3"]',
            '@report-go-articulations' => '[dusk="report-go-4"]',
            '@report-go-individual-number' => '[dusk="report-go-5"]',
            '@report-go-trauma' => '[dusk="report-go-6"]',
            '@report-go-anomaly' => '[dusk="report-go-7"]',
            '@report-go-pathology' => '[dusk="report-go-8"]',
            '@report-generate' => '#accordion > div > div.card-header > div.float-right > button',

            // Logout Buttons
            '@profile-picture' => '[dusk="profile-img"]',
            '@logout-menu' => '[dusk="logout-menu"]',

            //Project Measurement Report tags
            '@inumber-side' => '[dusk="inumber-side"]',

            //Project Methods Report tags
            '@se-methodfeature' => '[dusk="se-methodfeature"]',
            '@se-methodtype' => '[dusk="se-methodtype"]',
            '@se-method' => '[dusk="se-method"]',
            '@se-score' => '[dusk="se-score"]',
            '@se-range' => '[dusk="se-range"]',

            //Create New Tooth Tags
            '@se-tooth' => '[dusk="se-tooth"]',
            '@tooth-save-edit' =>'[dusk="tooth-save-edit"]',
            '@tooth-save-add' =>'[dusk="tooth-save-add"]',

            //Anomaly
            '@anomaly_bone' =>'[dusk="bone"]',
            '@anomaly_accessions' =>'[dusk="accessions"]',
            '@anomaly_p1' =>'[dusk="provenance1"]',
            '@anomaly_p2' =>'[dusk="provenance2"]',
            '@anomaly_a' =>'[dusk="anomaly"]',
            '@anomaly_side' =>'[dusk="side"]',


            // Specimen Measurements
            '@specimen-measurements-button' =>'[dusk="Measurements"]',
            '@specimen-measurements-edit-button' =>'[dusk="edit-button"]',
            '@specimen-measurements-collapse-button' =>'[dusk="collapse-button-measurements"]',
            '@Osc_01' =>'[dusk="Osc_01 Maximum Innominate Height"]',
            '@Osc_02' =>'[dusk="Osc_02 Maximum Iliac Breadth"]',
            '@Osc_03' =>'[dusk="Osc_03 Pubis Length"]',
            '@Osc_04' =>'[dusk="Osc_04 Ischium Length"]',
            '@Osc_05' =>'[dusk="Osc_05 Minimum Iliac Breadth"]',
            '@Osc_06' =>'[dusk="Osc_06 Maximum Pubis Length (XPL)"]',
            '@Osc_07' =>'[dusk="Osc_07 Minimum Pubis Length (WPL)"]',
            '@Osc_08' =>'[dusk="Osc_08 Ischial Length (ISL)"]',
            '@Osc_09' =>'[dusk="Osc_09 Minimum Ischial Length (WISL)"]',
            '@Osc_10' =>'[dusk="Osc_10 Maximum Ischiopubic Ramus Length (XIRL)"]',
            '@Osc_11' =>'[dusk="Osc_11 Anterior Superior Iliac Spine to Symphysion (ASISS)"]',
            '@Osc_12' =>'[dusk="Osc_12 Maximum Posterior Iliac Spine to Symphysion (PSISS)"]',
            '@Osc_13' =>'[dusk="Osc_13 Minimum Apical Border to Symphysion (WAS)"]',
            '@Osc_14' =>'[dusk="Osc_14 Thickness of the Ilium at the Sciatic Notch"]',
            '@Osc_15' =>'[dusk="Osc_15 Maximum Breadth of the Ischium"]',
            '@Osc_16' =>'[dusk="Osc_16 Minimum Breadth of the Pubis"]',
            '@Osc_17' =>'[dusk="Osc_17 Maximum Diameter of the Acetabulum"]',

            //dna ystr
            '@dna_ystr_accession' =>'[dusk="accession"]',
            '@dna_ystr_p1' =>'[dusk="provenance1"]',
            '@dna_ystr_p2' =>'[dusk="provenance2"]',
            '@dna_ystr_r' =>'[dusk="results-status"]',
            '@dna_ystr_seq' =>'[dusk="sequence-number"]',
            '@dna_ystr_sub' =>'[dusk="sequence-subgroup"]',
            '@dna_ystr_reqDF' =>'[dusk="request-dates-from-number"]',
            '@dna_ystr_reqDT' =>'[dusk="request-date-end"]',
            '@dna_ystr_recDF' =>'[dusk="receive-date-start"]',
            '@dna_ystr_recDT' =>'[dusk="receive-date-end"]',

            //isotope
            '@isotope_menu' => '[dusk="Isotope"]',
            '@isotope_batches_menu' => '[dusk="Isotope Batches"]',
            '@new_isotope_batch_menu' => '[dusk="New Isotope Batch"]',
            '@iso_lab' => '[dusk="lab"]',
            '@iso_external_case' => '[dusk="externalcase"]',
            '@iso_batch_number' => '[dusk="isotopebatchnumber"]',
            '@iso-batch_save' => '[dusk="save-btn"]',
            '@associate_iso_project' => '[dusk="select-project"]',
            '@associate_iso_select' => '[dusk="select-isotopes"]',
            '@associated_istopes' => '[dusk="associated-isotopes"]',
            '@associated_iso_save' => '[dusk="save"]',
            '@associated_start_processing' => '[dusk="se-next"]',
            '@isobatch_edit' => '[dusk="edit-button"]',
            '@isobatch_label_tubes' => '[dusk="label-tubes"]',
            '@isobatch_remove_all' => '[dusk="remove-all"]',
            '@isobatch_rinse_samples' => '[dusk="rinse-samples"]',
            '@isobatch_sonicate_samples_cycle1' => '[dusk="sonicate-samples-cycle1"]',
            '@isobatch_sonicate_samples_cycle2' => '[dusk="sonicate-samples-cycle2"]',
            '@isobatch_sonicate_samples_95' => '[dusk="sonicate-samples-95"]',
            '@isobatch_sonicate_samples_100' => '[dusk="sonicate-samples-100"]',
            '@isobatch_dry_samples' => '[dusk="dry-samples"]',
            '@isobatch_save' => '[dusk="iso-save"]',



        ];
    }
    /**
     * Logout a user.
     *
     * @param \Laravel\Dusk\Browser $browser
     * @return void
     */
    public function logoutUser(Browser $browser)
    {
        //$browser->click('#app > header > nav > div > ul > li.nav-item.dropdown > a > span')
        $browser->click('@profile-picture')
            ->pause(500)
            ->press('@logout-menu')
            ->waitForText('Login')
            ->waitForLocation('/login')
            ->assertDontSee('Administration');
    }
}
