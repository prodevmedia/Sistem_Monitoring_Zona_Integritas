<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'is_active'
    ];

    public function rencanaKerja()
    {
        return $this->hasMany(RencanaKerja::class, 'periode_id', 'id');
    }
}
