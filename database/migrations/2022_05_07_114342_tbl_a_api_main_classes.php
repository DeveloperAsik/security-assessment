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
        Schema::connection('mysql_api')->create('tbl_a_api_main_classes', function (Blueprint $table) {
            $table->id()->length(32);
            $table->string('code', 32);
            $table->text('select');
            $table->text('condition');
            $table->text('order_by');
            $table->text('group_by');
            $table->string('offset', 155);
            $table->string('limit', 155);
            $table->tinyInteger('select_type', false, false)->length(1)->default(1); //1=all, 2=first, 3=last
            $table->tinyInteger('is_active', false, false)->length(1)->default(0);
            $table->integer('join_id', false, false)->length(32);
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
        Schema::connection('mysql_api')->drop('tbl_a_api_main_classes');
    }
};
