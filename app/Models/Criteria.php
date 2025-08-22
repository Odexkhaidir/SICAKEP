<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $load = ['audit'];
    protected $with = ['document'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
    
    public function audit()
    {
        return $this->hasMany(Audit::class);
    }

}
