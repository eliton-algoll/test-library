<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $CodAu
 * @property string $nome
 */
class Autor extends Model
{
    use HasFactory;

    protected $table = 'Autor';

    public $timestamps = false;

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'Livro_Autor', 'CodAu', 'CodL');
    }
}
