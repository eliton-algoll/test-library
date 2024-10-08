<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livro', function (Blueprint $table) {
            $table->unsignedBigInteger('codL')
                ->autoIncrement()
                ->primary()
                ->index();
            $table->string('titulo', 40)->index();
            $table->string('editora', 40)->index();
            $table->integer('edicao');
            $table->string('anoPublicacao', 4);
            $table->float('valor');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livro');
    }
};
