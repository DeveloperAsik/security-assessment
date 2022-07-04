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
        Schema::create('tbl_a_user_menu_accesss', function (Blueprint $table) {
            $table->id()->length(32);
            $table->integer('user_menu_id', false, false)->length(32);
            $table->integer('group_id', false, false)->length(32);
            $table->tinyInteger('is_allowed', false, false)->length(1)->default(0);
            $table->tinyInteger('is_active', false, false)->length(32)->default(0);
            $table->integer('created_by', false, false)->length(32);
            $table->dateTime('created_date');
            $table->integer('updated_by', false, false)->length(32);
            $table->dateTime('updated_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_a_user_menu_accesss');
    }
};
