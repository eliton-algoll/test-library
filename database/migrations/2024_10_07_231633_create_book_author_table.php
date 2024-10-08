<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livro_autor', function (Blueprint $table) {
            $table->unsignedBigInteger('livro_codL');
            $table->unsignedBigInteger('autor_codAu');
            $table->timestamps();

            $table->primary(['livro_codL', 'autor_codAu'])->unique();

            $table->foreign('livro_codL')
                ->references('codL')
                ->on('livro');

            $table->foreign('autor_codAu')
                ->references('codAu')
                ->on('autor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livro_autor');
    }
};
