<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoraV300Tables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orgs', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('uses_file_export_import')->default(false);
            $table->boolean('uses_reporting')->default(false);
            $table->boolean('uses_analytics')->default(false);
            $table->boolean('uses_visualizations')->default(false);
            $table->boolean('uses_homunculus')->default(false);
            $table->boolean('uses_unstructured_data')->default(false);
            $table->string('provision', 4096)->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
            $table->string('api_token')->nullable();

            $table->text('profile_photo_path')->nullable();
            $table->text('two_factor_secret')->after('password')->nullable();
            $table->text('two_factor_recovery_codes')->after('two_factor_secret')->nullable();
//            $table->foreignId('current_team_id')->nullable();
        });

        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
            $table->boolean('uses_auto_increment_designator')->default(true);
        });

        Schema::table('skeletal_bones', function (Blueprint $table) {
            $table->boolean('methods_age')->default(false);
            $table->boolean('methods_sex')->default(false);
            $table->boolean('methods_ancestry')->default(false);
            $table->boolean('methods_stature')->default(false);
            $table->string('measurements_help_url', 1024)->nullable();
            $table->string('zones_help_url', 1024)->nullable();
        });

        Schema::table('skeletal_elements', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
            $table->timestamp('ct_scanned_date')->nullable();
            $table->timestamp('xray_scanned_date')->nullable();
            $table->timestamp('3D_scanned_date')->nullable();
            $table->string('custom_field_1')->nullable();
            $table->string('custom_field_2')->nullable();
            $table->string('custom_field_3')->nullable();

            $table->foreign('inventoried_by_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('skeletal_element_reviews', function (Blueprint $table) {
            $table->bigInteger('reviewer_id')->nullable();
            $table->string('subtype')->nullable();
            $table->boolean('accepted')->default(false);
            $table->boolean('completed')->default(false);

            $table->foreign('reviewer_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('dnas', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
            $table->unsignedInteger('user_id')->unsigned()->nullable();
            $table->string('custom_field_1')->nullable();
            $table->string('custom_field_2')->nullable();
            $table->string('custom_field_3')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('isotopes', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
            $table->unsignedInteger('user_id')->unsigned()->nullable();
            $table->string('custom_field_1')->nullable();
            $table->string('custom_field_2')->nullable();
            $table->string('custom_field_3')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('pathologys', function (Blueprint $table) {
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
        });

        Schema::table('traumas', function (Blueprint $table) {
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
        });

        Schema::table('anomalys', function (Blueprint $table) {
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
        });

        Schema::table('taphonomys', function (Blueprint $table) {
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->string('icon')->nullable();
        });

        Schema::table('methods', function (Blueprint $table) {
            $table->boolean('uses_measurements')->default(false);
            $table->string('measurements')->nullable();
        });

        Schema::table('instruments', function (Blueprint $table) {
            $table->string('used_for')->nullable();
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
        });

        Schema::table('org_summary', function (Blueprint $table) {
            $table->string('stats', 2048)->nullable()->change();
            $table->string('specimen_stats', 2048)->nullable()->change();
            $table->string('dna_stats', 2048)->nullable()->change();
            $table->string('isotope_stats', 2048)->nullable()->change();
            $table->string('dental_stats', 2048)->nullable()->change();
            $table->string('project_stats', 2048)->nullable()->change();
            $table->string('user_stats', 2048)->nullable()->change();
        });

        Schema::table('user_summary', function (Blueprint $table) {
            $table->string('stats', 2048)->nullable()->change();
            $table->string('specimen_stats', 2048)->nullable()->change();
            $table->string('dna_stats', 2048)->nullable()->change();
            $table->string('isotope_stats', 2048)->nullable()->change();
            $table->string('dental_stats', 2048)->nullable()->change();
            $table->string('project_stats', 2048)->nullable()->change();
            $table->string('user_stats', 2048)->nullable()->change();
        });

        Schema::table('project_summary', function (Blueprint $table) {
            $table->string('stats', 2048)->nullable()->change();
            $table->string('specimen_stats', 2048)->nullable()->change();
            $table->string('dna_stats', 2048)->nullable()->change();
            $table->string('isotope_stats', 2048)->nullable()->change();
            $table->string('dental_stats', 2048)->nullable()->change();
            $table->string('project_stats', 2048)->nullable()->change();
            $table->string('user_stats', 2048)->nullable()->change();
        });

        Schema::create('dental_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 3)->unique();
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('se_dental_code', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('se_id')->unsigned();
            $table->unsignedInteger('dc_id')->unsigned();
            $table->unsignedInteger('sb_id')->unsigned();
            $table->unsignedInteger('org_id')->unsigned();
            $table->unsignedInteger('project_id')->unsigned();
            $table->string('type')->nullable();
            $table->string('subtype')->nullable();
            $table->boolean('root')->default(false);
            $table->boolean('crown')->default(false);
            $table->boolean('mesial')->default(false);
            $table->boolean('occlusal')->default(false);
            $table->boolean('distal')->default(false);
            $table->boolean('facial')->default(false);
            $table->boolean('lingual')->default(false);

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('se_id')->references('id')->on('skeletal_elements')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dc_id')->references('id')->on('dental_codes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sb_id')->references('id')->on('skeletal_bones')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('org_id')->references('id')->on('orgs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('daily_weekly_monthly_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('org_id');
            $table->unsignedInteger('project_id');
            $table->string('type'); // Daily, Weekly or Monthly
            $table->string('stats', 2048)->nullable();
            $table->string('specimen_stats', 2048)->nullable();
            $table->string('dna_stats', 2048)->nullable();
            $table->string('isotope_stats', 2048)->nullable();
            $table->string('dental_stats', 2048)->nullable();
            $table->string('project_stats', 2048)->nullable();
            $table->string('user_stats', 2048)->nullable();
            $table->string('results_status', 32)->default("Complete"); // Complete, Partial or Incomplete

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('org_id')->references('id')->on('orgs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('analytics_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('org_id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('se_id')->nullable();
            $table->unsignedInteger('dna_id')->nullable();
            $table->string('type');
            $table->string('results_status', 32)->default("Complete"); // Complete, Partial or Incomplete
            $table->string('analytics_results', 4096)->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('org_id')->references('id')->on('orgs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('crons', function (Blueprint $table) {
            $table->string('command');
            $table->integer('next_run');
            $table->integer('last_run');
//            $table->datetime('next_run');
//            $table->datetime('last_run');
            $table->timestamps();

            $table->primary('command');
            $table->index('next_run');
        });

        Schema::table('export_file_details', function (Blueprint $table) {
            $table->integer('num_downloads')->default(0);
            $table->string('download_stats', 1024)->nullable();
        });
        Schema::table('import_file_types', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('import_csv_file_table_map', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::create('missing_persons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('org_id')->unsigned();
            $table->unsignedInteger('project_id')->unsigned()->nullable();
            $table->string('uuid')->unique()->nullable();
            $table->unsignedInteger('case_manager_id')->unsigned()->nullable();
            $table->unsignedInteger('lab_project_manager_id')->unsigned()->nullable();

            // Base Data
            $table->string('case_number')->nullable();
            $table->string('conflict')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('incident')->nullable();
            $table->string('case_status')->nullable();
            $table->string('field_grave')->nullable();
            $table->string('temp_field_grave')->nullable();
            $table->text('lab_notes')->nullable();
            $table->text('case_notes')->nullable();
            $table->string('case_manager')->nullable();
            $table->timestamp('case_assign_date')->nullable();
            $table->timestamp('case_complete_date')->nullable();
            $table->timestamp('case_partial_date')->nullable();
            $table->timestamp('case_exhausted_all_resources_date')->nullable();
            $table->timestamp('case_identification_date')->nullable();
            $table->timestamp('case_remains_in_lab_date')->nullable();

            // Service Member/Individual
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('correct_name')->nullable();
            $table->string('country')->nullable();
            $table->string('frs_xfile')->nullable();

            // priority
            $table->string('priority_dpaa')->nullable();
            $table->string('priority_pcrb')->nullable();

            // FRS Request and Lab Receive status and dates
            $table->boolean('frs_request_mtdna_1')->default(false);
            $table->boolean('frs_request_mtdna_2')->default(false);
            $table->boolean('frs_request_mtdna_3')->default(false);
            $table->boolean('frs_request_ystr_1')->default(false);
            $table->boolean('frs_request_ystr_2')->default(false);
            $table->boolean('frs_request_austr_1')->default(false);
            $table->boolean('frs_request_austr_2')->default(false);
            $table->timestamp('frs_request_mtdna_1_date')->nullable();
            $table->timestamp('frs_request_mtdna_2_date')->nullable();
            $table->timestamp('frs_request_mtdna_3_date')->nullable();
            $table->timestamp('frs_request_ystr_1_date')->nullable();
            $table->timestamp('frs_request_ystr_2_date')->nullable();
            $table->timestamp('frs_request_austr_1_date')->nullable();
            $table->timestamp('frs_request_austr_2_date')->nullable();
            $table->boolean('lab_receive_mtdna_1')->nullable();
            $table->boolean('lab_receive_request_mtdna_2')->nullable();
            $table->boolean('lab_receive_request_mtdna_3')->nullable();
            $table->boolean('lab_receive_request_ystr_1')->nullable();
            $table->boolean('lab_receive_request_ystr_2')->nullable();
            $table->boolean('lab_receive_request_austr_1')->nullable();
            $table->boolean('lab_receive_request_austr_2')->nullable();
            $table->timestamp('lab_receive_mtdna_1_date')->nullable();
            $table->timestamp('lab_receive_request_mtdna_2_date')->nullable();
            $table->timestamp('lab_receive_request_mtdna_3_date')->nullable();
            $table->timestamp('lab_receive_request_ystr_1_date')->nullable();
            $table->timestamp('lab_receive_request_ystr_2_date')->nullable();
            $table->timestamp('lab_receive_request_austr_1_date')->nullable();
            $table->timestamp('lab_receive_request_austr_2_date')->nullable();

            // Genealogy related fields
            $table->boolean('genealogy_request')->default(false);
            $table->boolean('genealogy_sent')->default(false);
            $table->boolean('genealogy_receive')->default(false);
            $table->boolean('genealogy_not_required')->default(false);
            $table->timestamp('genealogy_request_date')->nullable();
            $table->timestamp('genealogy_sent_date')->nullable();
            $table->timestamp('genealogy_receive_date')->nullable();
            $table->timestamp('genealogy_not_required_date')->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('org_id')->references('id')->on('orgs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('case_manager_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lab_project_manager_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('genealogys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('org_id')->unsigned();
            $table->unsignedInteger('project_id')->unsigned()->nullable();
            $table->string('uuid')->unique()->nullable();
            $table->unsignedInteger('mp_id')->unsigned();
            $table->unsignedInteger('case_manager_id')->unsigned()->nullable();

            $table->string('priority')->nullable();
            $table->text('notes')->nullable();
            $table->string('enclosed_documents', 1024)->nullable();
            $table->string('company')->nullable();
            $table->string('funded_by')->nullable();

            $table->timestamp('request_date')->nullable();
            $table->timestamp('receive_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('org_id')->references('id')->on('orgs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('mp_id')->references('id')->on('missing_persons')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('case_manager_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('orgs', 'uuid')) {
            Schema::table('orgs', function (Blueprint $table) {
                $table->dropColumn(['uuid', 'active', 'provision', 'uses_file_export_import',
                    'uses_reporting', 'uses_analytics', 'uses_visualizations', 'uses_homunculus', 'uses_unstructured_data']);
            });
        }

        if (Schema::hasColumn('users', 'uuid')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['uuid', 'api_token', 'profile_photo_path', 'two_factor_secret', 'two_factor_recovery_codes']);
            });
        }

        if (Schema::hasColumn('failed_jobs', 'uuid')) {
            Schema::table('failed_jobs', function (Blueprint $table) {
                $table->dropColumn(['uuid']);
            });
        }

        if (Schema::hasColumn('projects', 'uuid')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn(['uuid', 'uses_auto_increment_designator']);
            });
        }

        if (Schema::hasColumn('skeletal_bones', 'methods_age')) {
            Schema::table('skeletal_bones', function (Blueprint $table) {
                $table->dropColumn(['methods_age', 'methods_sex', 'methods_ancestry', 'methods_stature',
                    'measurements_help_url', 'zones_help_url']);
            });
        }

        if (Schema::hasColumn('skeletal_elements', 'uuid')) {
            Schema::table('skeletal_elements', function (Blueprint $table) {
                $table->dropColumn(['uuid', 'custom_field_1', 'custom_field_2', 'custom_field_3',
                    'ct_scanned_date', 'xray_scanned_date', '3D_scanned_date']);

                $table->dropForeign('skeletal_elements_inventoried_by_id_foreign');
            });
        }

        if (Schema::hasColumn('skeletal_element_reviews', 'reviewer_id')) {
            Schema::table('skeletal_element_reviews', function (Blueprint $table) {
                $table->dropColumn(['reviewer_id', 'subtype', 'accepted', 'completed']);
            });
        }

        if (Schema::hasColumn('dnas', 'uuid')) {
            Schema::table('dnas', function (Blueprint $table) {
                $table->dropColumn(['uuid', 'user_id', 'custom_field_1', 'custom_field_2', 'custom_field_3']);
            });
        }

        if (Schema::hasColumn('isotopes', 'uuid')) {
            Schema::table('isotopes', function (Blueprint $table) {
                $table->dropColumn(['uuid', 'user_id', 'custom_field_1', 'custom_field_2', 'custom_field_3']);
            });
        }

        if (Schema::hasColumn('pathologys', 'icon')) {
            Schema::table('pathologys', function (Blueprint $table) {
                $table->dropColumn(['icon', 'color']);
            });
        }

        if (Schema::hasColumn('traumas', 'icon')) {
            Schema::table('traumas', function (Blueprint $table) {
                $table->dropColumn(['icon', 'color']);
            });
        }

        if (Schema::hasColumn('anomalys', 'icon')) {
            Schema::table('anomalys', function (Blueprint $table) {
                $table->dropColumn(['icon', 'color']);
            });
        }

        if (Schema::hasColumn('taphonomys', 'icon')) {
            Schema::table('taphonomys', function (Blueprint $table) {
                $table->dropColumn(['icon', 'color']);
            });
        }

        if (Schema::hasColumn('tags', 'icon')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->dropColumn(['icon']);
            });
        }

        if (Schema::hasColumn('methods', 'uses_measurements')) {
            Schema::table('methods', function (Blueprint $table) {
                $table->dropColumn(['uses_measurements', 'measurements']);
            });
        }

        if (Schema::hasColumn('instruments', 'used_for')) {
            Schema::table('instruments', function (Blueprint $table) {
                $table->dropColumn(['used_for', 'description', 'icon', 'color']);
            });
        }

        if (Schema::hasColumn('export_file_details', 'num_downloads')) {
            Schema::table('export_file_details', function (Blueprint $table) {
                $table->dropColumn(['num_downloads', 'download_stats']);
            });
        }
        if (Schema::hasColumn('import_file_types', 'deleted_at')) {
            Schema::table('import_file_types', function (Blueprint $table) {
                $table->dropColumn(['deleted_at']);
            });
        }
        if (Schema::hasColumn('import_csv_file_table_map', 'deleted_at')) {
            Schema::table('import_csv_file_table_map', function (Blueprint $table) {
                $table->dropColumn(['deleted_at']);
            });
        }

        Schema::dropIfExists('se_dental_code');
        Schema::dropIfExists('dental_codes');
        Schema::dropIfExists('daily_weekly_monthly_summary');
        Schema::dropIfExists('analytics_summary');
        Schema::dropIfExists('crons');
        Schema::dropIfExists('genealogys');
        Schema::dropIfExists('missing_persons');
    }
}
