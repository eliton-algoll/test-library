<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $livro_codL
 * @property int $assunto_codAs
 */
class BookSubject extends Model
{
    use HasFactory;

    protected $table = 'livro_assunto';

    protected $fillable = [
        'livro_codL',
        'assunto_codAs',
    ];
}
