<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaKerja extends Model
{
    use HasFactory;

    protected $fillable = ['area_perubahan_id','tanggal_waktu','realisasi','rencana_aksi'];

    public function areaperubahan(){
        return $this->hasOne(AreaPerubahan::class,'id','area_perubahan_id');
    }
}
