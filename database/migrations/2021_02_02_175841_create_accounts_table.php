<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('order_number')->nullable();
            $table->integer('level')->nullable();
            $table->string('name')->nullable();
            $table->string('year')->nullable();
            $table->bigInteger('target_before')->nullable();
            $table->bigInteger('target_after')->nullable();
            $table->string('legal_basis')->nullable();
            $table->text('description')->nullable();
            $table->string('account_regulations')->nullable();
            $table->string('account_editable')->nullable();
            $table->boolean('mark_1')->nullable();
            $table->boolean('mark_2')->nullable();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
