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
        Schema::create('tbl_d_app_social_medias', function (Blueprint $table) {
            $table->id()->length(32);
            $table->string('title', 255);
            $table->string('value', 255);
            $table->text('description');
            $table->tinyInteger('is_active', false, false)->length(1)->default(0);
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
        Schema::drop('tbl_d_app_social_medias');
    }
};
