<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $CodL
 * @property string $Titulo
 * @property string $Editora
 * @property integer $Edicao
 * @property string $AnoPublicacao
 * @property float $Valor
 */
class Livro extends Model
{
    use HasFactory;

    protected $table = 'Livro';

    protected $casts = [
        'Valor' => 'float',
    ];

    protected $fillable = [
        'Titulo',
        'Editora',
        'Edicao',
        'AnoPublicacao',
        'Valor',
    ];

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'Livro_Autor', 'CodL', 'CodAu');
    }

    public function assuntos()
    {
        return $this->belongsToMany(Assunto::class, 'Livro_Assunto', 'CodL', 'CodAs');
    }
}
