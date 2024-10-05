<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigInteger('idPedido')->primaryKey()->autoIncrement()->unsigned();
            $table->date('fechaPedido');
            $table->String('nombre_med', 150);
            $table->enum('tipo_med', ['ANALGESICO', 'ANALEPTICO', 'ANESTESICO', 'ANTIACIDO', 'ANTIDEPRESIVO', 'ANTIBIOTICOS', 'OTROS'])->default('ANALGESICO');
            $table->biginteger('cantidad');
            $table->enum('proveedor_med', ['COFARMA', 'EMPSEPHAR', 'CEMEFAR'])->default('COFARMA');
            $table->boolean('f_principal')->default(false);
            $table->boolean('f_secundaria')->default(false);
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
        Schema::dropIfExists('pedidos');
    }
}
