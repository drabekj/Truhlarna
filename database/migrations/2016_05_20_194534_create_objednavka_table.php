<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjednavkaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Objednavka', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Cislo_VP');
            $table->string('Jmeno');
            $table->date('Od');
            $table->date('Do');
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
        Schema::drop('Objednavka');
    }
}
