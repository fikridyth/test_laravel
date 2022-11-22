<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_role');
            $table->foreign('id_role')->references('id')->on('tbl_master_role');
            $table->string('name');
            $table->string('nrik');
            $table->string('email')->unique();
            $table->string('password');
            $table->date('tanggal_lahir');
            $table->integer('id_unit_kerja');
            $table->integer('status_data')->default(1);
            $table->smallInteger('is_blokir')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->dateTime('last_activity')->nullable();
            $table->date('expired_password');
            $table->timestamp('email_verified_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
