<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $livro_codL
 * @property int $autor_codAu
 */
class BookAuthor extends Model
{
    use HasFactory;

    protected $table = 'livro_autor';

    protected $fillable = [
        'livro_codL',
        'autor_codAu',
    ];
}
