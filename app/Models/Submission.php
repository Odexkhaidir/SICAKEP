<?php

namespace App\Models;

use App\Models\Archieve;
use App\Models\Permindok;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $load = ['archieve'];
    protected $with = ['permindok', 'satker', 'supervisor'];

    
    public function permindok()
    {
        return $this->belongsTo(Permindok::class);
    }

    public function satker()
    {
        return $this->belongsTo(Satker::class);
    }

    public function archieve()
    {
        return $this->hasMany(Archieve::class);
    }
    
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}

