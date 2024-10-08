<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Assunto', function (Blueprint $table) {
            $table->unsignedBigInteger('CodAs')
                ->autoIncrement()
                ->primary()
                ->index();
            $table->string('Descricao', 20)->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Assunto');
    }
};
