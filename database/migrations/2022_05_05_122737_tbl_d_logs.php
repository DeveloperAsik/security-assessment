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
        Schema::create('tbl_d_logs', function (Blueprint $table) {
            $table->id()->length(32);
            $table->longText('fraud_scan');
            $table->string('ip_address', 16);
            $table->text('browser');
            $table->string('class', 16);
            $table->string('method', 16);
            $table->string('event', 16);
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
        Schema::drop('tbl_d_logs');
    }
};
