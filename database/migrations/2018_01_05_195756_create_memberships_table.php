<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->uuid('id');
            $table->morphs('owner');
            $table->morphs('member');
            $table->unsignedInteger('membership_level_id');
            $table->text('notes');
            $table->unsignedInteger('added_by');
            $table->unsignedInteger('last_updated_by');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('membership_level_id')->references('id')->on('membership_levels');
            $table->foreign('added_by')->references('id')->on('characters');
            $table->foreign('last_updated_by')->references('id')->on('characters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memberships');
    }
}
