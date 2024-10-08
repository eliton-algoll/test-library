<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Livro', function (Blueprint $table) {
            $table->unsignedBigInteger('CodL')
                ->autoIncrement()
                ->primary()
                ->index();
            $table->string('Titulo', 40)->index();
            $table->string('Editora', 40)->index();
            $table->integer('Edicao');
            $table->string('AnoPublicacao', 4);
            $table->float('Valor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Livro');
    }
};
