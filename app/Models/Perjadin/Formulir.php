<?php

namespace App\Models\Perjadin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formulir extends Model
{
    use HasFactory;
    protected $table = 'perjadin_formulir';

    protected $guarded = [];

    public function ringkasan()
    {
        return $this->hasMany(Ringkasan::class, 'formulir_id');
    }
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'formulir_id');
    }
    public function satker()
    {
        return $this->belongsTo(\App\Models\Satker::class, 'satker_id');
    }
}
