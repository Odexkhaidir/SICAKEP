<?php

namespace App\Models;

use App\Models\Target;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['target', 'team'];
    
    public function target()
    {
        return $this->belongsTo(Target::class);
    }
    
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
