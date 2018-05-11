<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handbooks', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('owner_id');
            $table->string('owner_type');
            $table->unsignedInteger('order')->nullable()->index();
            $table->string('title');
            $table->text('description');
            $table->longText('content');
            $table->uuid('created_by')->index();
            $table->uuid('last_updated_by')->index();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('created_by')->references('id')->on('characters');
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
        Schema::dropIfExists('handbooks');
    }
}
