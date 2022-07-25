<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class RencanaKerja extends Model
{
    use HasFactory;

    protected $table = "rencana_kerjas";
    protected $primaryKey='id';
    protected $fillable = ['area_perubahan_id','tanggal_waktu','realisasi','rencana_aksi','user_id','unit_kerja_id'];

    public function areaperubahan(){
        return $this->hasOne(AreaPerubahan::class,'id','area_perubahan_id');
    }
    static function get_by_area($area_perubahan_id){
        $data = DB::table("rencana_kerjas")->where('area_perubahan_id',$area_perubahan_id)->get();
        return $data;
    }
    static function get_by_unit($unit_kerja_id){
        $data = DB::table("rencana_kerjas")->where('unit_kerja_id',$unit_kerja_id)->get();
        return $data;
    }
    public function unitkerja(){
        return $this->hasMany(UnitKerja::class);
    }
    
}
