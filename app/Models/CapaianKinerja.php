<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapaianKinerja extends Model
{
    use HasFactory;
    protected $table = 'capaian_kinerja_satker';

    // protected $with = [
    //     'target_kinerja_satker',
    // ];
    public function target_kinerja_satker()
    {
        return $this->belongsTo(TargetKinerja::class, 'target_kinerja_satker_id');
    }
}
