<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminCodeVerificationTbTable extends Migration
{
    public function up()
    {
        Schema::create('admin_code_verification_tb', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('code', 6);
            $table->dateTime('expires_at');
            $table->timestamps(); // Cria created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_password_verification_tb');
    }
}
