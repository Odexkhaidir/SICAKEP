<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Satker extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function team()
    {
        return $this->hasMany(Team::class);
    }

    public static function getKabKota()
    {
        return Satker::where('code', '!=', '7100')->get();
    }
    public function score(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
