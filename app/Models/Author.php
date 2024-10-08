<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $codAu
 * @property string $nome
 */
class Author extends Model
{
    use HasFactory;

    protected $table = 'autor';

    protected $primaryKey = 'codAu';

    public $fillable = [
        'nome'
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'Livro_Autor', 'CodAu', 'CodL')
            ->withTimestamps();
    }
}
