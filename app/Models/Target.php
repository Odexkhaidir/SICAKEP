<?php

namespace App\Models;

use App\Models\Result;
use App\Models\Satker;
use App\Models\Indicator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Target extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['indicator', 'satker'];
    protected $load = ['result'];
    
    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function satker()
    {
        return $this->belongsTo(Satker::class);
    }
    
    public function result()
    {
        return $this->hasMany(Result::class);
    }
}
