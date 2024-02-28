<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('skpd_id')->unsigned()->nullable();
            $table->bigInteger('account_id')->unsigned()->nullable();
            $table->date('date')->nullable();
            $table->string('evidance')->nullable();
            $table->longText('description')->nullable();
            $table->bigInteger('value')->nullable();
            $table->string('last_year')->nullable();
            $table->longText('last_year_description')->nullable();
            $table->boolean('mark')->default(0);
            $table->timestamps();

            $table->foreign('skpd_id')->references('id')->on('skpd')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journals');
    }
}
