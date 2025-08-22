<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Satker;
use App\Models\CapaianKinerja;

class TargetKinerja extends Model
{
    use HasFactory;
    protected $table = 'target_kinerja_satker';
    protected $fillable = [
        'satker_id',
        'tahun',
        'indikator',
        'target',
        'satuan',
    ];
    // protected $with = [
    //     'satker',
    //     'capaian_kinerja_satker'
    // ];
    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id');
    }
    public function capaian_kinerja_satker()
    {
        return $this->hasOne(CapaianKinerja::class, 'target_kinerja_satker_id');
    }
}