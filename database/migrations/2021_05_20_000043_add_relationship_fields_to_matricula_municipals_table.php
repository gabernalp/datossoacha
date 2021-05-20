<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMatriculaMunicipalsTable extends Migration
{
    public function up()
    {
        Schema::table('matricula_municipals', function (Blueprint $table) {
            $table->unsignedBigInteger('sede_id')->nullable();
            $table->foreign('sede_id', 'sede_fk_3949617')->references('id')->on('sedes');
            $table->unsignedBigInteger('jornada_id')->nullable();
            $table->foreign('jornada_id', 'jornada_fk_3949618')->references('id')->on('jornadas');
        });
    }
}
