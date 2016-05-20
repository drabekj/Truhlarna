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
            $table->date('Datum');
            $table->integer('ID_Obj');
            $table->integer('Hodiny');
            $table->integer('ID_Zam');
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
