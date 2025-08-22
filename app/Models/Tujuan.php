<?php

namespace App\Models;

use App\Models\Sasaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tujuan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $load = ['sasaran'];
    
    public function sasaran()
    {
        return $this->hasMany(Sasaran::class);
    }
}
