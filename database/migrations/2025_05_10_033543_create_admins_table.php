<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('ip_address')->nullable();
            $table->string('device_info')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin');
    }
}