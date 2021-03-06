<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewZamestnanecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Zamestnanec', function (Blueprint $table) {
            $table->increments('ID_Zam');
            $table->string('Jmeno');
            $table->string('Prijmeni');
            $table->integer('Sazba');
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
        Schema::drop('Zamestnanec');
    }
}
