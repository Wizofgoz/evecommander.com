<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('owner');
            $table->unsignedInteger('billing_condition_id')->nullable();
            $table->enum('amount_type', ['fixed', 'percent', 'per_member']);
            $table->decimal('amount', 20)->comment('If amount_type is fixed, amount is in ISK; If percent, amount is a percentage; If per_member, amount is fixed but multiplied by how many members the target has.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membership_fees');
    }
}
