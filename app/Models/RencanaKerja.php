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
    protected $fillable = ['tanggal_waktu','realisasi','rencana_aksi'];

    public function masterunitkerja(){
        return $this->belongsTo(MasterUnitKerja::class,'master_unit_kerja_id','id');
    }

    public function fileuploads(){
        return $this->hasMany(FileUpload::class,'rencana_kerja_id','id');
    }
    
}
