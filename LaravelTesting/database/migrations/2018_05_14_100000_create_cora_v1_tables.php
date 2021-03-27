<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoraV1Tables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->default("Image");
            $table->string('url');
            $table->boolean('archived')->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('url');
        });

        Schema::create('bone_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_name');
            $table->integer('sb_id')->unsigned();
            $table->boolean('side')->default(false);
            $table->integer('display_order')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sb_id')->references('id')->on('skeletal_bones');
        });

        Schema::create('import_file_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('table_names');
            $table->string('display_name');
            $table->string('template_location', 512)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('import_file_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->nullable();
            $table->string('filename')->nullable();
            $table->integer('type_id');
            $table->string('file_location', 512)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('type_id')->references('id')->on('import_file_types')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('import_csv_file_table_map', function (Blueprint $table) {
            $table->increments('id');
            $table->string('csv_column_name');
            $table->string('table_column_name');
            $table->string('table_name');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('project_se_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->integer('se_total')->nullable()->default(0);
            $table->integer('num_complete')->nullable()->default(0);
            $table->integer('num_measured')->nullable()->default(0);
            $table->integer('num_dna_sampled')->nullable()->default(0);
            $table->integer('num_isotope_sampled')->nullable()->default(0);
            $table->integer('num_ct_scanned')->nullable()->default(0);
            $table->integer('num_xray_scanned')->nullable()->default(0);
            $table->integer('num_clavicle')->nullable()->default(0);
            $table->integer('num_clavicle_triage')->nullable()->default(0);
            $table->integer('num_inventoried')->nullable()->default(0);
            $table->integer('num_reviewed')->nullable()->default(0);
            $table->integer('num_individuals')->nullable()->default(0);
            $table->integer('num_unique_individuals')->nullable()->default(0);

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('project_dna_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->integer('se_total')->nullable()->default(0);
            $table->integer('num_sampled')->nullable()->default(0);
            $table->integer('num_results_received')->nullable()->default(0);
            $table->integer('num_results_reportable')->nullable()->default(0);
            $table->integer('num_results_inconclusive')->nullable()->default(0);
            $table->integer('num_results_unable_to_assign')->nullable()->default(0);
            $table->integer('num_results_cancelled')->nullable()->default(0);
            $table->integer('num_mito_sequences')->nullable()->default(0);

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('export_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('group');
            $table->string('table_names')->nullable();
            $table->string('query')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('export_file_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('org_id');
            $table->integer('project_id');
            $table->integer('user_id');
            $table->string('filename')->nullable();
            $table->string('file_location', 512)->nullable();
            $table->string('export_type')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('org_id')->references('id')->on('orgs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->integer('org_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('category')->nullable();
            $table->string('description')->nullable();
            $table->string('color')->nullable();

            $table->foreign('org_id')->references('id')->on('orgs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['org_id', 'project_id', 'category', 'name'], 'unique_org_project_category_name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('cell_phone')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('display_name')->nullable();
            $table->string('default_timezone')->nullable()->default('America/Chicago');

            $table->string('default_language')->nullable()->default('en')->change();
            $table->string('default_country')->nullable()->default('US')->change();
        });

        Schema::table('orgs', function (Blueprint $table) {
            $table->string('default_language')->nullable()->default('en');
            $table->string('default_country')->nullable()->default('US');
            $table->string('default_timezone')->nullable()->default('America/Chicago');

            $table->unique('acronym');
        });

        Schema::table('methods', function (Blueprint $table) {
            $table->string('display_help', 1024)->nullable();
            $table->string('help_url', 1024)->nullable();
        });

        Schema::table('method_features', function (Blueprint $table) {
            $table->string('display_interval', 1024)->nullable();
        });

        Schema::table('measurements', function (Blueprint $table) {
            $table->string('help_url', 1024)->nullable();
        });

        Schema::table('zones', function (Blueprint $table) {
            $table->string('display_help', 1024)->nullable();
            $table->string('help_url', 1024)->nullable();
        });

        Schema::table('accessions', function (Blueprint $table) {
            $table->boolean('consolidated_an')->default(false);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('geo_lat', 10, 7)->nullable();
            $table->decimal('geo_long', 10, 7)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->boolean('allow_user_accession_create')->default(false);
            $table->string('slack_channel')->nullable();

            $table->unique('name');
        });

        Schema::table('dnas', function (Blueprint $table) {
            $table->integer('analysis_type_id')->unsigned()->nullable();         // region type:- ystr, astr, vr1, vr2 and ps5
            $table->string('results_confidence')->nullable();
            $table->string('method')->nullable();
            $table->string('external_sample_number')->nullable();
            $table->string('dispostion_of_evidence')->nullable();
            $table->string('regions', 2048)->nullable();
            $table->string('num_bases', 2048)->nullable();
            $table->string('locus', 2048)->nullable();
            $table->integer('num_loci')->nullable();
            $table->timestamp('mcc_date')->nullable();

            $table->foreign('analysis_type_id')->references('id')->on('dna_analysis_types');

            $table->index(['se_id']);
            $table->index(['org_id']);
            $table->index(['project_id']);
            $table->index(['external_case_id']);
            $table->index(['sample_number']);
            $table->index(['mito_haplogroup_id']);
            $table->index(['analysis_type_id']);
        });

        Schema::table('bone_groups', function (Blueprint $table) {
            $table->boolean('for_inventory')->default(true);
            $table->boolean('for_articulation')->default(true);
        });

        Schema::table('skeletal_bones', function (Blueprint $table) {
            $table->boolean('countable')->default(false);

            $table->unique('name');
        });

        Schema::table('skeletal_elements', function (Blueprint $table) {
            $table->string('consolidated_an')->nullable();
            $table->boolean('isotope_sampled')->default(false);
            $table->integer('count')->nullable();
            $table->decimal('mass')->nullable();
            $table->string('bone_group')->nullable();
            $table->uuid('bone_group_id')->nullable();

            $table->index(['sb_id']);
            $table->index(['org_id']);
            $table->index(['project_id']);
            $table->index(['user_id']);
            $table->index(['reviewer_id']);

            $table->index(['accession_number']);
            $table->index(['provenance1']);
            $table->index(['provenance2']);
            $table->index(['designator']);
            $table->index(['individual_number']);
            $table->index(['consolidated_an']);
        });

        Schema::table('se_pair', function (Blueprint $table) {
            $table->string('compare_method')->nullable()->default('Visual');
            $table->string('compare_method_settings', 512)->nullable();
            $table->string('measurements_used')->nullable();
            $table->integer('num_measurements')->nullable();
            $table->integer('sample_size')->nullable();
            $table->decimal('pvalue')->nullable();
            $table->decimal('mean')->nullable();
            $table->decimal('sd')->nullable();
            $table->string('elimination_reason')->nullable();
            $table->timestamp('elimination_date')->nullable();
        });

        Schema::table('se_articulation', function (Blueprint $table) {
            $table->string('compare_method')->nullable();
            $table->string('compare_method_settings', 512)->nullable();
            $table->string('measurements_used')->nullable();
            $table->integer('num_measurements')->nullable();
            $table->integer('sample_size')->nullable();
            $table->decimal('pvalue')->nullable();
            $table->decimal('mean')->nullable();
            $table->decimal('sd')->nullable();
            $table->string('elimination_reason')->nullable();
            $table->timestamp('elimination_date')->nullable();
        });

        //change column size
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('display_values', 1024)->change();
        });

        // Remove the old audit table if it exists
        if (Schema::hasTable('audits')) {
            if (Schema::hasColumn('audits', 'activity')) {
                Schema::dropIfExists('audits');
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medias');
        Schema::dropIfExists('bone_groups');
        Schema::dropIfExists('project_se_summary');
        Schema::dropIfExists('project_dna_summary');
        Schema::dropIfExists('import_csv_file_table_map');
        Schema::dropIfExists('import_file_details');
        Schema::dropIfExists('import_file_types');
        Schema::dropIfExists('export_maps');
        Schema::dropIfExists('export_file_details');

        if (Schema::hasColumn('tags', 'color')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->dropUnique('unique_org_project_category_name');

                $table->dropColumn(['org_id', 'project_id', 'category', 'description', 'color']);
            });
        }
        if (Schema::hasColumn('users', 'first_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['first_name', 'last_name', 'display_name', 'cell_phone', 'default_timezone']);
            });
        }
        if (Schema::hasColumn('orgs', 'default_language')) {
            Schema::table('orgs', function (Blueprint $table) {
                $table->dropUnique('orgs_acronym_unique');

                $table->dropColumn(['default_language', 'default_country', 'default_timezone']);
            });
        }
        if (Schema::hasColumn('methods', 'help_url')) {
            Schema::table('methods', function (Blueprint $table) {
                $table->dropColumn(['display_help']);
                $table->dropColumn(['help_url']);
            });
        }
        if (Schema::hasColumn('method_features', 'display_interval')) {
            Schema::table('method_features', function (Blueprint $table) {
                $table->dropColumn(['display_interval']);
            });
        }
        if (Schema::hasColumn('measurements', 'help_url')) {
            Schema::table('measurements', function (Blueprint $table) {
                $table->dropColumn(['help_url']);
            });
        }
        if (Schema::hasColumn('zones', 'help_url')) {
            Schema::table('zones', function (Blueprint $table) {
                $table->dropColumn(['display_help']);
                $table->dropColumn(['help_url']);
            });
        }
        if (Schema::hasColumn('accessions', 'consolidated_an')) {
            Schema::table('accessions', function (Blueprint $table) {
                $table->dropColumn(['consolidated_an']);
            });
        }
        if (Schema::hasColumn('projects', 'geo_lat')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropUnique('projects_name_unique');

                $table->dropColumn(['geo_lat', 'geo_long', 'start_date', 'allow_user_accession_create', 'slack_channel']);
            });
        }
        if (Schema::hasColumn('dnas', 'results_confidence')) {
            Schema::table('dnas', function (Blueprint $table) {
                $table->dropIndex(['se_id']);
                $table->dropIndex(['org_id']);
                $table->dropIndex(['project_id']);
                $table->dropIndex(['external_case_id']);
                $table->dropIndex(['sample_number']);
                $table->dropIndex(['mito_haplogroup_id']);
                $table->dropIndex(['analysis_type_id']);

                $table->dropColumn(['results_confidence', 'method', 'analysis_type_id', 'external_sample_number',
                    'dispostion_of_evidence', 'regions', 'num_bases', 'locus', 'num_loci', 'mcc_date']);
            });
        }
        Schema::dropIfExists('dna_analysis');
        Schema::dropIfExists('dna_resamples');

        if (Schema::hasColumn('methods', 'display_help')) {
            Schema::table('methods', function (Blueprint $table) {
                $table->dropColumn(['display_help']);
            });
        }
        if (Schema::hasColumn('bone_groups', 'for_inventory')) {
            Schema::table('bone_groups', function (Blueprint $table) {
                $table->dropColumn(['for_inventory', 'for_articulation']);
            });
        }
        if (Schema::hasColumn('skeletal_bones', 'countable')) {
            Schema::table('skeletal_bones', function (Blueprint $table) {
                $table->dropUnique('skeletal_bones_name_unique');

                $table->dropColumn(['countable']);
            });
        }
        if (Schema::hasColumn('skeletal_elements', 'consolidated_an')) {
            Schema::table('skeletal_elements', function (Blueprint $table) {
                $table->dropIndex(['sb_id']);
                $table->dropIndex(['org_id']);
                $table->dropIndex(['project_id']);
                $table->dropIndex(['user_id']);
                $table->dropIndex(['reviewer_id']);

                $table->dropIndex(['accession_number']);
                $table->dropIndex(['provenance1']);
                $table->dropIndex(['provenance2']);
                $table->dropIndex(['designator']);
                $table->dropIndex(['individual_number']);
                $table->dropIndex(['consolidated_an']);

                $table->dropColumn(['consolidated_an', 'isotope_sampled', 'count', 'mass', 'bone_group', 'bone_group_id']);
            });
        }

        if (Schema::hasColumn('se_pair', 'compare_method')) {
            Schema::table('se_pair', function (Blueprint $table) {
                $table->dropColumn(['compare_method', 'compare_method_settings', 'measurements_used', 'num_measurements',
                    'sample_size', 'pvalue', 'mean', 'sd', 'elimination_reason', 'elimination_date']);
            });
        }

        if (Schema::hasColumn('se_articulation', 'compare_method')) {
            Schema::table('se_articulation', function (Blueprint $table) {
                $table->dropColumn(['compare_method', 'compare_method_settings', 'measurements_used', 'num_measurements',
                    'sample_size', 'pvalue', 'mean', 'sd', 'elimination_reason', 'elimination_date']);
            });
        }

    }
}
