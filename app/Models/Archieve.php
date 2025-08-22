<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archieve extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $load = ['audit'];
    protected $with = ['document','submission'];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
    
    public function audit()
    {
        return $this->hasMany(Audit::class);
    }
}
