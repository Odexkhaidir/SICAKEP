<?php

namespace App\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'user_id'];
    
    public function team()
    {
        return $this->hasMany(Team::class);
    }
    
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
