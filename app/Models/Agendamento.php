<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'usuario_id', 'hora_inicio', 'hora_fim', 'data', 'avaliacao',
    ];

    protected $keyType = 'string'; 
    public $incrementing = false;
    protected $dates = ['data']; 
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}
