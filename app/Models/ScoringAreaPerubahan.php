<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoringAreaPerubahan extends Model
{
    use HasFactory;
    
    protected $fillable = ['type','bobot','penjelasan','pilihan_jawaban','jawaban','nilai','presentase','unit_kerja_id','file_id'];

    public function user(){
        $this->hasOne(UnitKerja::class);
    }

    public function file(){
        $this->hasOne(FileUpload::class);
    }
}
