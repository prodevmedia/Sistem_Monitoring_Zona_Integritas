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
        return $this->hasMany(UserUnitKerja::class,'master_unit_kerja_id', 'id');
    }

    public function areaperubahan(){
        return $this->hasMany(AreaPerubahan::class,'master_unit_kerja_id','id');
    }
}
