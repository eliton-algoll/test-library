<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Livro_Assunto', function (Blueprint $table) {
            $table->unsignedBigInteger('Livro_CodL');
            $table->unsignedBigInteger('Autor_CodAs');

            $table->foreign('Livro_CodL')
                ->references('CodL')
                ->on('Livro');

            $table->foreign('Autor_CodAs')
                ->references('CodAs')
                ->on('Assunto');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Livro_Assunto');
    }
};
