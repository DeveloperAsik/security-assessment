<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tbl_a_users', function (Blueprint $table) {
            $table->id()->length(32);
            $table->string('user_name', 255);
            $table->string('first_name', 100);
            $table->string('last_name', 155);
            $table->string('email', 255);
            $table->string('password', 128);
            $table->text('description');
            $table->integer('registered_type_id', false, false)->length(6)->unsigned();
            $table->tinyInteger('is_active', false, false)->length(1)->unsigned()->default('0');
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
        Schema::drop('tbl_a_users');
    }
};
