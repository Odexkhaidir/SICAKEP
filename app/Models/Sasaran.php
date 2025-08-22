<?php

namespace App\Models;

use App\Models\Tujuan;
use App\Models\Indicator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sasaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['tujuan'];
    protected $load = ['indicator'];
    
    public function tujuan()
    {
        return $this->belongsTo(Tujuan::class);
    }
    
    public function indicator()
    {
        return $this->hasMany(Indicator::class);
    }
}
