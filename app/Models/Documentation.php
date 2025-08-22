<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'file_path',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function jenis_kegiatan()
    {
        return $this->belongsTo(JenisKegiatan::class);
    }
}
