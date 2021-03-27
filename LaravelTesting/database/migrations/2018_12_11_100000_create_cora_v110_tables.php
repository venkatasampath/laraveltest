<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoraV110Tables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('slack_channel')->nullable();
        });

        Schema::table('import_file_details', function (Blueprint $table) {
            $table->integer('org_id');
            $table->integer('project_id');
            $table->integer('user_id');
            $table->string('stats')->nullable();
            $table->softDeletes();

            $table->foreign('org_id')->references('id')->on('orgs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('export_maps', function (Blueprint $table) {
            $table->string('query', 1024)->nullable()->change();
        });

        Schema::table('export_file_details', function (Blueprint $table) {
            $table->softDeletes();
            $table->timestamp('last_downloaded_at')->nullable();
            $table->string('downloaded_by')->nullable();
        });

        Schema::table('skeletal_bones', function (Blueprint $table) {
            $table->boolean('mni')->default(true);
            $table->index('search_name');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('uses_isotope_analysis')->default(true);
            $table->boolean('zones_autocomplete')->default(true);
            $table->timestamp('latest_mcc_date')->nullable();
        });

        Schema::table('accessions', function (Blueprint $table) {
            $table->decimal('geo_lat', 10, 7)->nullable();
            $table->decimal('geo_long', 10, 7)->nullable();
            $table->timestamp('event_date')->nullable();
        });

        Schema::create('org_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('org_id');
            $table->string('stats', 1024)->nullable();
            $table->string('specimen_stats', 1024)->nullable();
            $table->string('dna_stats', 1024)->nullable();
            $table->string('isotope_stats', 1024)->nullable();
            $table->string('dental_stats', 1024)->nullable();
            $table->string('project_stats', 1024)->nullable();
            $table->string('user_stats', 1024)->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('org_id')->references('id')->on('orgs')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('org_id');
            $table->unsignedInteger('user_id');
            $table->string('stats', 1024)->nullable();
            $table->string('specimen_stats', 1024)->nullable();
            $table->string('dna_stats', 1024)->nullable();
            $table->string('isotope_stats', 1024)->nullable();
            $table->string('dental_stats', 1024)->nullable();
            $table->string('project_stats', 1024)->nullable();
            $table->string('user_stats', 1024)->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('org_id')->references('id')->on('orgs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('project_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('org_id');
            $table->unsignedInteger('project_id');
            $table->string('stats', 1024)->nullable();
            $table->string('specimen_stats', 1024)->nullable();
            $table->string('dna_stats', 1024)->nullable();
            $table->string('isotope_stats', 1024)->nullable();
            $table->string('dental_stats', 1024)->nullable();
            $table->string('project_stats', 1024)->nullable();
            $table->string('user_stats', 1024)->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('org_id')->references('id')->on('orgs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('instruments', function (Blueprint $table) {
            $table->boolean('active')->default(true);
            $table->unique(['code'], 'unique_code');
        });

        Schema::table('dna_analysis_types', function (Blueprint $table) {
            $table->string('type', 32)->nullable();

            $table->unique(['name', 'type'], 'unique_name_type');
        });

        Schema::table('dnas', function (Blueprint $table) {
            $table->unsignedInteger('sb_id')->nullable();
            $table->boolean('additional_testing')->default(false);
            $table->timestamp('priority_date')->nullable();
            $table->timestamp('btb_request_date')->nullable();
            $table->timestamp('btb_results_date')->nullable();
            $table->string('disposition')->nullable();
            $table->string('sample_condition')->nullable();
            $table->decimal('weight_sample_remaining')->nullable();

            // Drop columns
            $table->dropColumn(['sampled']);
            $table->dropColumn(['resample_number']);

            // Mito Fields and Rename columns
            $table->renameColumn('method', 'mito_method');
            $table->renameColumn('results_confidence', 'mito_results_confidence');
            $table->renameColumn('regions', 'mito_confirmed_regions');
            $table->renameColumn('num_bases', 'mito_base_pairs');
            $table->renameColumn('num_loci', 'mito_num_loci');
            $table->renameColumn('mcc_date', 'mito_mcc_date');
            $table->timestamp('mito_request_date')->nullable();
            $table->string('mito_polymorphisms')->nullable();
            $table->string('mito_fasta_sequence', 20000)->nullable(); // because mito is 16,000 base pairs
            $table->string('mito_haplosubgroup', 8)->nullable();      // e.g. 2b1a

            // AuStr Fields
            $table->string('austr_method')->nullable();
            $table->timestamp('austr_request_date')->nullable();
            $table->timestamp('austr_receive_date')->nullable();
            $table->string('austr_results_confidence')->nullable();
            $table->string('austr_sequence_number')->nullable();
            $table->string('austr_sequence_subgroup')->nullable();
            $table->string('austr_sequence_similar')->nullable();
            $table->integer('austr_match_count')->nullable();
            $table->integer('austr_total_count')->nullable();
            $table->integer('austr_num_loci')->nullable();
            $table->string('austr_loci')->nullable();
            $table->timestamp('austr_mcc_date')->nullable();

            // YStr Fields
            $table->string('ystr_method')->nullable();
            $table->timestamp('ystr_request_date')->nullable();
            $table->timestamp('ystr_receive_date')->nullable();
            $table->string('ystr_results_confidence')->nullable();
            $table->string('ystr_sequence_number')->nullable();
            $table->string('ystr_sequence_subgroup')->nullable();
            $table->string('ystr_sequence_similar')->nullable();
            $table->integer('ystr_match_count')->nullable();
            $table->integer('ystr_total_count')->nullable();
            $table->integer('ystr_num_loci')->nullable();
            $table->string('ystr_loci')->nullable();
            $table->unsignedInteger('ystr_haplogroup')->nullable();
            $table->string('ystr_haplosubgroup', 8)->nullable();      // e.g. 2b1a
            $table->timestamp('ystr_mcc_date')->nullable();

            $table->foreign('sb_id')->references('id')->on('skeletal_bones')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('haplogroups', function (Blueprint $table) {
            $table->string('subgroup')->nullable();
            $table->string('type', 32)->default('Mito');
            $table->string('ancestry')->nullable()->change();
        });

        Schema::create('isotope_batches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('org_id')->unsigned();              // Org that this Isotope belongs to
            $table->unsignedInteger('project_id')->unsigned()->nullable(); // Project that this IsotopeBatch belongs to
            $table->unsignedInteger('lab_id')->unsigned()->nullable();  // External Lab Id such as UC Davis
            $table->string('external_case_id')->nullable();             // External Case Id (e.g. UC Davis Case number)
            $table->string('batch_num')->nullable();                    // Batch Number
            $table->string('status', 32)->default('Open');       // Status (e.g. Open, Cleaning, Demineralizing, Removal Humic Acids, Solubilizing, Freeze Drying Collagen, Determining Collagen Yield, Closed)

            // isotope batch fields for cleaning
            $table->timestamp('cleaning_start_date')->nullable();
            $table->boolean('labeling_tubes')->nullable()->default(false);              // 1. Label tubes and caps. Print copy of bacth list
            $table->boolean('rsc')->nullable()->default(false);                         // 2. Remove all visible signs of surface contamination using rotary tool (remove_surface_contamination).
            $table->boolean('rinse_samples')->nullable()->default(false);               // 3. Rinse samples w/dH2O and place in labeled tubes.
            $table->boolean('sonicate_samples_dh2o_cycle1')->nullable()->default(false);    // 4. Sonicate samples (20 min each: 2x dH2O, 1x 95% ethanol, 1x 100% ethanol).
            $table->timestamp('sonicate_samples_dh2o_cycle1_start_date')->nullable();
            $table->boolean('sonicate_samples_dh2o_cycle2')->nullable()->default(false);    // 4. Sonicate samples (20 min each: 2x dH2O, 1x 95% ethanol, 1x 100% ethanol).
            $table->timestamp('sonicate_samples_dh2o_cycle2_start_date')->nullable();
            $table->boolean('sonicate_samples_ethanol95')->nullable()->default(false);      // 4. Sonicate samples (20 min each: 2x dH2O, 1x 95% ethanol, 1x 100% ethanol).
            $table->timestamp('sonicate_samples_ethanol95_start_date')->nullable();
            $table->boolean('sonicate_samples_ethanol100')->nullable()->default(false);     // 4. Sonicate samples (20 min each: 2x dH2O, 1x 95% ethanol, 1x 100% ethanol).
            $table->timestamp('sonicate_samples_ethanol100_start_date')->nullable();
            $table->boolean('dry_samples_start')->nullable()->default(false);           // 5. Dry Samples in oven started.
            $table->timestamp('dry_samples_start_date')->nullable();
            $table->boolean('dry_samples_end')->nullable()->default(false);             // 6. Dry Samples removed from oven.
            $table->timestamp('dry_samples_end_date')->nullable();
            $table->string('cleaning_initials')->nullable();                            // Initials of users who worked on this task

            // isotope batch fields for demineralizing whole bone
            $table->boolean('demineralizing_treatment_start')->nullable()->default(false);
            $table->boolean('demineralizing_treatment_end')->nullable()->default(false);
            $table->timestamp('demineralizing_treatment_start_date')->nullable();
            $table->timestamp('demineralizing_treatment_end_date')->nullable();
            $table->boolean('rinse_demineralized_samples')->nullable()->default(false);

            // isotope batch fields for removing humic acids
            $table->boolean('rha_treatment_start')->nullable()->default(false);
            $table->boolean('rha_treatment_end')->nullable()->default(false);
            $table->timestamp('rha_treatment_start_date')->nullable();
            $table->timestamp('rha_treatment_end_date')->nullable();
            $table->boolean('rha_sample_rinse1_start')->nullable()->default(false);
            $table->boolean('rha_sample_rinse1_end')->nullable()->default(false);
            $table->timestamp('rha_sample_rinse1_start_date')->nullable();
            $table->timestamp('rha_sample_rinse1_end_date')->nullable();
            $table->boolean('rha_sample_rinse2_start')->nullable()->default(false);
            $table->boolean('rha_sample_rinse2_end')->nullable()->default(false);
            $table->timestamp('rha_sample_rinse2_start_date')->nullable();
            $table->timestamp('rha_sample_rinse2_end_date')->nullable();
            $table->boolean('rha_sample_rinse3_start')->nullable()->default(false);
            $table->boolean('rha_sample_rinse3_end')->nullable()->default(false);
            $table->timestamp('rha_sample_rinse3_start_date')->nullable();
            $table->timestamp('rha_sample_rinse3_end_date')->nullable();
            $table->boolean('rha_sample_rinse4_start')->nullable()->default(false);
            $table->boolean('rha_sample_rinse4_end')->nullable()->default(false);
            $table->timestamp('rha_sample_rinse4_start_date')->nullable();
            $table->timestamp('rha_sample_rinse4_end_date')->nullable();
            $table->boolean('rha_sample_rinse5_start')->nullable()->default(false);
            $table->boolean('rha_sample_rinse5_end')->nullable()->default(false);
            $table->timestamp('rha_sample_rinse5_start_date')->nullable();
            $table->timestamp('rha_sample_rinse5_end_date')->nullable();

            // isotope batch fields for solubilizing collagen
            $table->boolean('sc_clean_vials_and_lids')->nullable()->default(false);
            $table->timestamp('sc_clean_vials_and_lids_date')->nullable();
            $table->boolean('sc_add_solubale')->nullable()->default(false);
            $table->boolean('sc_place_in_oven')->nullable()->default(false);
            $table->boolean('sc_centrifuge_tubes')->nullable()->default(false);
            $table->integer('sc_num_acid_heat_treatment')->nullable();
            $table->integer('sc_num_collagen_transfers')->nullable();
            $table->boolean('sc_freeze_vials')->nullable()->default(false);
            $table->timestamp('sc_freeze_vials_date')->nullable();

            // isotope batch fields for freeze-drying collagen
            $table->boolean('fdc_on')->nullable()->default(false);
            $table->boolean('fdc_samples_start')->nullable()->default(false);
            $table->boolean('fdc_samples_end')->nullable()->default(false);
            $table->timestamp('fdc_samples_start_date')->nullable();
            $table->timestamp('fdc_samples_end_date')->nullable();

            // isotope batch fields for determining collagen yield
            $table->boolean('combined_samples_weight')->nullable()->default(false);
            // auto calculate final collagen mass and percentage yield.

            $table->string('notes', 1024)->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('org_id')->references('id')->on('orgs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['batch_num'], 'unique_batch_num');
        });

        Schema::create('isotopes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('se_id')->unsigned();
            $table->unsignedInteger('sb_id')->unsigned();
            $table->unsignedInteger('org_id')->unsigned();              // Org that this Isotope belongs to
            $table->unsignedInteger('project_id')->unsigned();          // Project that this Isotope belongs to
            $table->unsignedInteger('lab_id')->unsigned()->nullable();  // External Lab Id such as UC Davis
            $table->unsignedInteger('batch_id')->unsigned()->nullable();  // Isotope Batch
            $table->string('sample_number')->nullable();
            $table->string('external_case_id')->nullable();             // External Case Id (e.g. UC Davis Case number)
            $table->string('results_confidence', 32)->nullable();

            // Add main isotope fields for cleaning and preparation here
            $table->decimal('weight_sample_cleaned')->nullable();
            $table->decimal('weight_vial_lid')->nullable();
            $table->decimal('weight_sample_vial_lid')->nullable();
            $table->decimal('weight_collagen')->nullable();             // calculated field
            $table->decimal('yield_collagen')->nullable();
            $table->timestamp('demineralizing_start_date')->nullable();
            $table->timestamp('demineralizing_end_date')->nullable();

            // Add main isotope fields after actual Isotope Analysis, once collagen is extracted
            $table->string('analysis_requested')->nullable();           // Analysis requested.
            $table->string('well_location')->nullable();                // Tray Well ID/location
            $table->decimal('collagen_weight_used_for_analysis')->nullable(); // Collagen Amount (ug) used for the analysis process
            $table->decimal('c_weight')->nullable();                   // Carbon Amount (ug)
            $table->decimal('n_weight')->nullable();                   // Nitrogen Amount (ug)
            $table->decimal('o_weight')->nullable();                   // Oxygen Amount (ug)
            $table->decimal('s_weight')->nullable();                   // Sulphur Amount (ug)
            $table->decimal('c_delta')->nullable();                     // delta Carbon Amount (ug)
            $table->decimal('n_delta')->nullable();                     // delta Nitrogen Amount (ug)
            $table->decimal('o_delta')->nullable();                     // delta Oxygen Amount (ug)
            $table->decimal('s_delta')->nullable();                     // delta Sulphur Amount (ug)
            $table->decimal('c_percent')->nullable();                   // percentage Carbon (%)
            $table->decimal('n_percent')->nullable();                   // percentage Nitrogen (%)
            $table->decimal('o_percent')->nullable();                   // percentage Oxygen (%)
            $table->decimal('s_percent')->nullable();                   // percentage Sulphur (%)
            $table->decimal('c_to_n_ratio')->nullable();                // Carbon to Nitrogen Ratio (%)
            $table->decimal('c_to_o_ratio')->nullable();                // Carbon to Oxygen Ratio (%)

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('se_id')->references('id')->on('skeletal_elements')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sb_id')->references('id')->on('skeletal_bones')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('org_id')->references('id')->on('orgs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('batch_id')->references('id')->on('isotope_batches');
            $table->index('sample_number');
        });

        Schema::table('skeletal_elements', function (Blueprint $table) {
            $table->unsignedInteger('inventoried_by_id')->nullable();
            $table->string('remains_status', 32)->nullable();
            $table->timestamp('remains_release_date')->nullable();
            $table->timestamp('identification_date')->nullable(); //date an individual has been identified by the medical examiner

            $table->index(['inventoried_by_id']);
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'slack_channel')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['slack_channel']);
            });
        }

        if (Schema::hasColumn('import_file_details', 'deleted_at')) {
            Schema::table('import_file_details', function (Blueprint $table) {
                $table->dropForeign(['org_id']);
                $table->dropForeign(['project_id']);
                $table->dropForeign(['user_id']);

                $table->dropColumn(['org_id', 'project_id', 'user_id', 'stats', 'deleted_at']);
            });
        }

        if (Schema::hasColumn('export_file_details', 'deleted_at')) {
            Schema::table('export_file_details', function (Blueprint $table) {
                $table->dropColumn(['deleted_at', 'last_downloaded_at', 'downloaded_by']);
            });
        }

        if (Schema::hasColumn('skeletal_bones', 'mni')) {
            Schema::table('skeletal_bones', function (Blueprint $table) {
                $table->dropColumn(['mni']);
                $table->dropIndex(['search_name']);
            });
        }

        if (Schema::hasColumn('projects', 'latest_mcc_date')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn(['latest_mcc_date', 'uses_isotope_analysis', 'zones_autocomplete']);
            });
        }

        if (Schema::hasColumn('accessions', 'geo_lat')) {
            Schema::table('accessions', function (Blueprint $table) {
                $table->dropColumn(['geo_lat', 'geo_long', 'event_date']);
            });
        }

        if (Schema::hasColumn('instruments', 'active')) {
            Schema::table('instruments', function (Blueprint $table) {
                $table->dropUnique('unique_code');
                $table->dropColumn(['active']);
            });
        }

        if (Schema::hasColumn('dna_analysis_types', 'type')) {
            Schema::table('dna_analysis_types', function (Blueprint $table) {
                $table->dropUnique('unique_name_type');
                $table->dropColumn(['type']);
            });
        }

        if (Schema::hasColumn('haplogroups', 'type')) {
            Schema::table('haplogroups', function (Blueprint $table) {
                $table->dropColumn(['type', 'subgroup']);
                $table->string('ancestry')->change();
            });
        }

        if (Schema::hasColumn('dnas', 'sb_id')) {
            Schema::table('dnas', function (Blueprint $table) {
                // drop index
                $table->dropForeign(['sb_id']);

                // Add the dropped columns
                $table->boolean('sampled')->nullable();
                $table->string('resample_number')->nullable();

                // Mito Fields and Rename columns
                $table->renameColumn('mito_method', 'method');
                $table->renameColumn('mito_results_confidence', 'results_confidence');
                $table->renameColumn('mito_confirmed_regions', 'regions');
                $table->renameColumn('mito_base_pairs', 'num_bases');
                $table->renameColumn('mito_num_loci', 'num_loci');
                $table->renameColumn('mito_mcc_date', 'mcc_date');

                $table->dropColumn(['sb_id', 'additional_testing', 'priority_date', 'btb_request_date', 'btb_results_date', 'disposition', 'sample_condition', 'weight_sample_remaining']);
                $table->dropColumn(['mito_request_date', 'mito_polymorphisms', 'mito_fasta_sequence', 'mito_haplosubgroup']);
                $table->dropColumn(['austr_method', 'austr_request_date', 'austr_receive_date', 'austr_results_confidence', 'austr_sequence_number', 'austr_sequence_subgroup', 'austr_sequence_similar',
                    'austr_match_count', 'austr_total_count', 'austr_num_loci', 'austr_loci', 'austr_mcc_date']);
                $table->dropColumn(['ystr_method', 'ystr_request_date', 'ystr_receive_date', 'ystr_results_confidence', 'ystr_sequence_number', 'ystr_sequence_subgroup', 'ystr_sequence_similar',
                    'ystr_match_count', 'ystr_total_count', 'ystr_num_loci', 'ystr_loci', 'ystr_haplogroup', 'ystr_haplosubgroup', 'ystr_mcc_date']);
            });
        }

        if (Schema::hasColumn('skeletal_elements', 'inventoried_by_id')) {
            Schema::table('skeletal_elements', function (Blueprint $table) {
                $table->dropIndex(['inventoried_by_id']);

                $table->dropColumn(['inventoried_by_id', 'remains_status', 'remains_release_date', 'identification_date']);
            });
        }

        if (Schema::hasColumn('tags', 'type')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->dropColumn(['type']);
            });
        }

        Schema::dropIfExists('isotopes');
        Schema::dropIfExists('isotope_batches');
        Schema::dropIfExists('org_summary');
        Schema::dropIfExists('user_summary');
        Schema::dropIfExists('project_summary');
    }
}
