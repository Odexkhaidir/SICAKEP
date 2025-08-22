<?php

namespace App\Models\Perjadin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ringkasan extends Model
{
    use HasFactory;
    protected $table = 'perjadin_ringkasan';

    public function formulir()
    {
        return $this->belongsTo(Formulir::class, 'formulir_id');
    }
}
