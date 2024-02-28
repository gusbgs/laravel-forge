<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();

            $table->tinyInteger('roles_view')->default(0);
            $table->tinyInteger('roles_create')->default(0);
            $table->tinyInteger('roles_edit')->default(0);
            $table->tinyInteger('roles_delete')->default(0);

            $table->tinyInteger('users_view')->default(0);
            $table->tinyInteger('users_create')->default(0);
            $table->tinyInteger('users_edit')->default(0);
            $table->tinyInteger('users_delete')->default(0);

            $table->tinyInteger('accounts_view')->default(0);
            $table->tinyInteger('accounts_create')->default(0);
            $table->tinyInteger('accounts_edit')->default(0);
            $table->tinyInteger('accounts_delete')->default(0);
            $table->tinyInteger('accounts_mark')->default(0);
            $table->tinyInteger('accounts_target')->default(0);

            $table->tinyInteger('skpd_view')->default(0);
            $table->tinyInteger('skpd_create')->default(0);
            $table->tinyInteger('skpd_edit')->default(0);
            $table->tinyInteger('skpd_delete')->default(0);
            $table->tinyInteger('skpd_account')->default(0);

            $table->tinyInteger('journals_view')->default(0);
            $table->tinyInteger('journals_create')->default(0);
            $table->tinyInteger('journals_edit')->default(0);
            $table->tinyInteger('journals_delete')->default(0);
            $table->tinyInteger('journals_mark')->default(0);

            $table->tinyInteger('reports_summary_view')->default(0);
            $table->tinyInteger('reports_summary_print')->default(0);
            $table->tinyInteger('reports_summary_all')->default(0);
            $table->tinyInteger('reports_ledger_view')->default(0);
            $table->tinyInteger('reports_ledger_print')->default(0);
            $table->tinyInteger('reports_income_view')->default(0);
            $table->tinyInteger('reports_income_print')->default(0);
            $table->tinyInteger('reports_overall_view')->default(0);
            $table->tinyInteger('reports_overall_print')->default(0);

            $table->tinyInteger('profile_edit')->default(0);
            $table->tinyInteger('about_edit')->default(0);

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
        Schema::dropIfExists('roles');
    }
}
