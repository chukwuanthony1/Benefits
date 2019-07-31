<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyInvite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_invites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('email_address');
            $table->integer('status')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('company_invites', function($table) {
            //$table->foreign('company_id')->references('id')->on('users');
            //$table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
