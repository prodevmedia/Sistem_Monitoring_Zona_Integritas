<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterUnitKerja extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name'];

    /**
     * Get the user that owns the Mast
     *
     * @return \IlluminUnitKerjaTo
     */
    public function userunitkerja()
    {
        // return $this->belongsTo(UnitKerja::class,'unit_kerja_id','id');
        return $this->belongsTo(UnitKerja::class,'id');
    }

    public function areaperubahan(){
        return $this->hasMany(AreaPerubahan::class,'master_unit_kerja_id','id');
    }
}
