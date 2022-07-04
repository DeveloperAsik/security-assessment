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
    public function up() {
        Schema::create('tbl_a_user_profiles', function (Blueprint $table) {
            $table->id()->length(32);
            $table->text('address');
            $table->string('lat', 155);
            $table->string('lng', 155);
            $table->integer('zoom', false, false)->length(4)->unsigned();
            $table->string('facebook', 255);
            $table->string('twitter', 255);
            $table->string('instagram', 255);
            $table->string('linkedin', 255);
            $table->string('photo', 255);
            $table->string('last_education', 255);
            $table->string('last_education_institution', 255);
            $table->text('skill');
            $table->text('notes');
            $table->text('description');
            $table->tinyInteger('is_active', false, false)->length(1)->default(0)->unsigned();
            $table->integer('created_by', false, false)->length(32)->unsigned();
            $table->dateTime('created_date');
            $table->integer('updated_by', false, false)->length(32)->unsigned();
            $table->dateTime('updated_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('tbl_a_user_profiles');
    }
};
