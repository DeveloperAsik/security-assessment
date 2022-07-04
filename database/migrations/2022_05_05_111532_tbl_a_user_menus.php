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
        Schema::create('tbl_a_user_menus', function (Blueprint $table) {
            $table->id()->length(32);
            $table->string('title', 255);
            $table->text('path');
            $table->text('content_path');
            $table->string('icon', 255);
            $table->integer('level', false, false)->length(2);
            $table->integer('rank', false, false)->length(2);
            $table->tinyInteger('is_badge', false, false)->length(1)->default(0);
            $table->text('badge');
            $table->string('badge_id', 255);
            $table->string('badge_value', 255);
            $table->integer('module_id', false, false)->length(32);
            $table->integer('parent_id', false, false)->length(32);
            $table->integer('group_id', false, false)->length(32);
            $table->tinyInteger('is_open', false, false)->length(1)->default(0);
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
    public function down() {
        Schema::drop('tbl_a_user_menus');
    }
};
