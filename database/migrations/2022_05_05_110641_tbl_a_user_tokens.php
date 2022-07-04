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
        Schema::create('tbl_a_user_tokens', function (Blueprint $table) {
            $table->id()->length(32);
            $table->text('token', 32);
            $table->dateTime('expiry');
            $table->integer('module_id', false, false)->length(32)->unsigned();
            $table->integer('group_id', false, false)->length(32)->unsigned();
            $table->tinyInteger('is_logged_in', false, false)->length(1)->default(0)->unsigned();
            $table->tinyInteger('is_expiry', false, false)->length(1)->default(0)->unsigned();
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
        Schema::drop('tbl_a_user_tokens');
    }
};
