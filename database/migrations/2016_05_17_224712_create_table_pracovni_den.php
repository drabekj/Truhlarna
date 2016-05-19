<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePracovniDen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Pracovni_den', function (Blueprint $table) {
            $table->increments('id');
            $table->date('datum');
            $table->integer('Cislo_VP');
            $table->integer('Hodiny');
            $table->integer('Zamestnanec_id');
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
        Schema::drop('Pracovni_den');
    }
}
