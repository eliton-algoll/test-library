<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $codL
 * @property string $titulo
 * @property string $editora
 * @property integer $edicao
 * @property string $anoPublicacao
 * @property float $valor
 */
class Book extends Model
{
    use HasFactory;

    protected $table = 'livro';

    protected $primaryKey = 'codL';

    protected $casts = [
        'valor' => 'float',
    ];

    protected $fillable = [
        'titulo',
        'editora',
        'edicao',
        'anoPublicacao',
        'valor',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'livro_autor', 'livro_codL', 'autor_codAu')
            ->withTimestamps();
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'livro_assunto', 'livro_codL', 'assunto_codAs')
            ->withTimestamps();
    }
}
