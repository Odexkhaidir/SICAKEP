<?php

namespace App\Models;

use App\Models\Output;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Suboutput extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
     
    public function output()
    {
        return $this->belongsTo(Output::class);
    }

    public function evaluation()
    {
        return $this->hasMany(Evaluation::class);
    }
}
