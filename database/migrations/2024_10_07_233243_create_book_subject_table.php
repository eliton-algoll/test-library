<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livro_assunto', function (Blueprint $table) {
            $table->unsignedBigInteger('livro_codL');
            $table->unsignedBigInteger('assunto_codAs');
            $table->timestamps();

            $table->primary(['livro_codL', 'assunto_codAs'])->unique();

            $table->foreign('livro_codL')
                ->references('codL')
                ->on('livro');

            $table->foreign('assunto_codAs')
                ->references('codAs')
                ->on('assunto');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livro_assunto');
    }
};
