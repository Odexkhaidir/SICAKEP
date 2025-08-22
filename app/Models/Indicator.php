<?php

namespace App\Models;

use App\Models\Target;
use App\Models\Sasaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Indicator extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['sasaran'];
    protected $load = ['target'];
    
    public function sasaran()
    {
        return $this->belongsTo(Sasaran::class);
    }
    
    public function target()
    {
        return $this->hasMany(Target::class);
    }
}
