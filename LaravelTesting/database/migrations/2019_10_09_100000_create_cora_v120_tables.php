<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoraV120Tables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('skeletal_bones', function (Blueprint $table) {
            $table->boolean('morphology')->nullable()->default(false);
            $table->boolean('methods')->nullable()->default(false);
            $table->boolean('middle')->nullable()->default(false);
        });

        Schema::table('skeletal_elements', function (Blueprint $table) {
            $table->boolean('3D_scanned')->nullable()->default(false);
            $table->text('notes')->nullable();  // Notes Field
        });

        Schema::table('bone_groups', function (Blueprint $table) {
            $table->boolean('middle')->nullable()->default(false);
        });

        Schema::table('dnas', function (Blueprint $table) {
            $table->boolean('resample_indicator')->nullable()->default(false);
            $table->text('notes')->nullable();  // Notes Field
        });

        Schema::table('se_pair', function (Blueprint $table) {
            $table->string('measurement_means', 1024)->nullable();    // json of means
            $table->string('measurement_sd', 1024)->nullable();      // json of sd
        });

        Schema::create('morphologys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sb_id')->unsigned();
            $table->integer('morphology_id')->unsigned();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['sb_id', 'morphology_id']);
            $table->foreign('sb_id')->references('id')->on('skeletal_bones')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('morphology_id')->references('id')->on('skeletal_bones')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('se_morphology', function(Blueprint $table)
        {
            $table->integer('se_id')->unsigned();
            $table->integer('morphology_id')->unsigned();
            $table->integer('org_id')->unsigned();          // Org that this SE belongs to
            $table->integer('project_id')->unsigned();      // Project that this SE belongs to
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['se_id', 'morphology_id']);
            $table->foreign('se_id')->references('id')->on('skeletal_elements')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('morphology_id')->references('id')->on('skeletal_elements')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('org_id')->references('id')->on('orgs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('skeletal_bones', 'morphology')) {
            Schema::table('skeletal_bones', function (Blueprint $table) {
                $table->dropColumn(['morphology', 'methods', 'middle']);
            });
        }

        if (Schema::hasColumn('skeletal_elements', '3D_scanned')) {
            Schema::table('skeletal_elements', function (Blueprint $table) {
                $table->dropColumn(['3D_scanned', 'notes']);
            });
        }

        if (Schema::hasColumn('bone_groups', 'middle')) {
            Schema::table('bone_groups', function (Blueprint $table) {
                $table->dropColumn(['middle']);
            });
        }

        if (Schema::hasColumn('dnas', 'resample_indicator')) {
            Schema::table('dnas', function (Blueprint $table) {
                $table->dropColumn(['resample_indicator', 'notes']);
            });
        }

        if (Schema::hasColumn('se_pair', 'measurement_means')) {
            Schema::table('se_pair', function (Blueprint $table) {
                $table->dropColumn(['measurement_means', 'measurement_sd']);
            });
        }

        Schema::dropIfExists('morphologys');
        Schema::dropIfExists('se_morphology');
    }
}


