<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $CodAu
 * @property string $Descricao
 */
class Assunto extends Model
{
    use HasFactory;

    protected $table = 'Assunto';

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'Livro_Assunto', 'CodAs', 'CodL');
    }
}
