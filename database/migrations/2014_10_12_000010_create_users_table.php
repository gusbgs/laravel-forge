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
            $table->bigInteger('role_id')->unsigned()->nullable();
            $table->bigInteger('skpd_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('email')->collation('utf8_unicode_ci')->unique();
            $table->string('username')->collation('utf8_unicode_ci')->unique();
            $table->string('profile_picture')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('year')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('reset_token')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->foreign('skpd_id')->references('id')->on('skpd')->onDelete('set null');
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
