<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(<<<'SQL'
            CREATE VIEW `vw_report_book`
            AS SELECT
            l.titulo, l.editora, l.edicao, l.anoPublicacao, l.valor, a.descricao AS assunto, au.nome  AS autor
            FROM livro l
            JOIN livro_autor la ON la.livro_codL = l.codL
            JOIN livro_assunto las ON las.livro_codL = l.codL
            JOIN autor au ON au.codAu = la.autor_codAu
            JOIN assunto a ON a.codAs = las.assunto_codAs
            ORDER BY au.nome
         SQL);
    }

    public function down(): void
    {
        DB::statement(<<<'SQL'
            DROP VIEW `vw_report_book`
        SQL);
    }
};
