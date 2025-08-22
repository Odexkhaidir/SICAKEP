<?php

namespace App\Models;

use App\Models\Team;
use App\Models\Suboutput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Output extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    protected $load = ['suboutput'];
    protected $with = ['team', 'supervisor','suboutput'];
    
     
    public function suboutput()
    {
        return $this->hasMany(Suboutput::class);
    }
         
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
