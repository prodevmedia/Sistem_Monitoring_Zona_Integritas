<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoringSubAreaPerubahan extends Model
{
    use HasFactory;
    protected $fillable = ['type','bobot','nilai','presentase','unit_kerja_id','file_id'];

    public function user(){
        $this->hasOne(UnitKerja::class);
    }

    public function file(){
        $this->hasOne(FileUpload::class);
    }
}
