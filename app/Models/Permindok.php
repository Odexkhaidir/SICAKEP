<?php

namespace App\Models;

use App\Models\Document;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permindok extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $load = ['document', 'submission'];
    
    public function document()
    {
        return $this->hasMany(Document::class);
    }
    
    public function submission()
    {
        return $this->hasMany(Submission::class);
    }
}
