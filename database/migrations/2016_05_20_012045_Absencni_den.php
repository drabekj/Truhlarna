<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AbsencniDen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Absencni_den', function (Blueprint $table) {
          $table->increments('id');
          $table->date('Datum');
          $table->integer('ID_Zam');
          $table->integer('Hodiny');
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
        Schema::drop('Absencni_den');
    }
}
