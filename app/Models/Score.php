<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    protected $with = ['satker', 'evaluation'];
    
    public function satker()
    {
        return $this->belongsTo(Satker::class);
    }
    
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
    
    
}
