<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTokensTable extends Migration
{
    public function up()
    {
        Schema::create('admin_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('admin_email');
            $table->string('token', 255);
            $table->dateTime('creat_at');
            $table->dateTime('expires_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_tokens');
    }
}
