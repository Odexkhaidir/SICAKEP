<?php

namespace App\Models;

use App\Models\Suboutput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    protected $load = ['score'];
    
    protected $with = ['team', 'month', 'suboutput'];
    
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function month()
    {
        return $this->belongsTo(Month::class);
    }
    
    public function score()
    {
        return $this->hasMany(Score::class);
    }

    public function suboutput()
    {
        return $this->belongsTo(Suboutput::class);
    }

}
