<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMasterMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_master_menu', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->text('link');
            $table->smallInteger('status_data')->default(1);
            $table->integer('urutan');
            $table->bigInteger('created_by')->default(2);
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('tbl_master_menu');
    }
}
