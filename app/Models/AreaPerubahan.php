<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaPerubahan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_area_perubahan','master_unit_kerja_id'];    

    public function subarea(){
        return $this->hasMany(SubAreaPerubahan::class,'area_perubahan_id','id');
    }

    public function subareas(){
        return $this->belongsTo(SubAreaPerubahan::class);
    }

    public function rencanakerja(){
        return $this->belongsTo(RencanaKerja::class,'area_perubahan_id');
    }
    public function masterunitkerja(){
        return $this->belongsToMany(MasterUnitKerja::class,'id');
    }
}
