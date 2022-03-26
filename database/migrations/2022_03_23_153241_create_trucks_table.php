<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreign('owner_id')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('registration_number');
            $table->integer('total_capacity');
            $table->year('manufacturing_year');
            $table->date('available_from_date');
            $table->date('available_to_date');
            $table->boolean('available_for_book')->default(true)->comment('true means available');
            $table->integer('available_capacity')->comment('to identify available load capacity');
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
        Schema::dropIfExists('trucks');
    }
};
