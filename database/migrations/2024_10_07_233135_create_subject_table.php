<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assunto', function (Blueprint $table) {
            $table->unsignedBigInteger('codAs')
                ->autoIncrement()
                ->primary()
                ->index();
            $table->string('descricao', 20)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assunto');
    }
};
