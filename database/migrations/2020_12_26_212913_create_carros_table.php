<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artigos', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('id_usuario');
            $table->string('img',200);
            $table->string('link',200);
            $table->string('nome',200);
            $table->integer('ano');
            $table->integer('km');
            $table->string('combustivel',50);
            $table->string('cambio',50);
            $table->string('portas',30);
            $table->string('cor',50);
            $table->decimal('preco',9,2);           
            $table->primary(['id_usuario','id']);         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artigos');
    }
}
