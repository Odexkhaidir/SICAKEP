<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['month'];
    
    public function month()
    {
        return $this->belongsTo(Month::class);
    }
}
