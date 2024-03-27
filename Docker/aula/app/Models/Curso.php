<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    public function eixo() {
        return $this->belongsTo('\App\Models\Eixo');
    }

    public function nivel() {
        return $this->belongsTo('\App\Models\Nivel');
    }

    public function turma() {
        return $this->hasMany('\App\Models\Turma');
    }

    public function categoria() {
        return $this->hasMany('\App\Models\Categoria');
    }

    public function user() {
        return $this->hasMany('\App\Models\User');
    }

    public function aluno() {
        return $this->hasMany('\App\Models\Aluno');
    }
}
