<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('password_hash');
            $table->enum('role', ['admin', 'engineer', 'operator', 'requester']);
            $table->timestamps();
            $table->timestamp('last_login')->nullable();
            
            $table->rememberToken();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};