<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $codAs
 * @property string $descricao
 */
class Subject extends Model
{
    use HasFactory;

    protected $table = 'assunto';

    protected $primaryKey = 'codAs';

    protected $fillable = ['descricao'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'livro_assunto', 'codAs', 'codL')
            ->withTimestamps();
    }
}
