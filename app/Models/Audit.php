<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $with = ['archieve','criteria'];

    public function archieve()
    {
        return $this->belongsTo(Archieve::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
    
}
