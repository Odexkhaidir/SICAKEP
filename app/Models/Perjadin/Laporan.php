<?php

namespace App\Models\Perjadin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $table = 'perjadin_laporan';
    public function formulir()
    {
        return $this->belongsTo(Formulir::class, 'formulir_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
