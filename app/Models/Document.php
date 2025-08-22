<?php

namespace App\Models;

use App\Models\Archieve;
use App\Models\Criteria;
use App\Models\Permindok;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $load = ['criteria', 'archieve'];
    protected $with = ['permindok'];

    
    public function permindok()
    {
        return $this->belongsTo(Permindok::class);
    }

    public function criteria()
    {
        return $this->hasMany(Criteria::class);
    }

    public function archieve()
    {
        return $this->hasMany(Archieve::class);
    }
}
