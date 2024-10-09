<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $titulo
 * @property string $editora
 * @property integer $edicao
 * @property string $anoPublicacao
 * @property string $assunto
 * @property string $autor
 * @property float $valor
 */
class ReportBookView extends Model
{
    protected $table = 'vw_report_book';

    protected $primaryKey = false;

    public $timestamps = false;

    public $incrementing = false;
}
