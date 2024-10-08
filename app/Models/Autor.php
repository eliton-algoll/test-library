<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $CodAu
 * @property string $Nome
 */
class Autor extends Model
{
    use HasFactory;

    protected $table = 'Autor';

    protected $primaryKey = 'CodAu';

    public $timestamps = false;

    public $fillable = [
        'Nome'
    ];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'Livro_Autor', 'CodAu', 'CodL');
    }
}
