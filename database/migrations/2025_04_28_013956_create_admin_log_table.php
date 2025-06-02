<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLogTable extends Migration
{
    public function up()
    {
        Schema::create('admin_log', function (Blueprint $table) {
            $table->id();
            $table->string('admin_email');
            $table->string('action'); // Exemplo: 'login', 'logout', 'password_change'
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps(); // created_at -> hora da ação
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_log');
    }
}
