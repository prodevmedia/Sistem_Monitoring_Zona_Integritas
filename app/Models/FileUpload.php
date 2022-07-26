<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileUpload extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id','name_file','path_file','rencana_kerja_id'];
    
    public function user(){
        return $this->hasOne(UnitKerja::class,'id','user_id');
    }

    public function points(){
        return $this->hasOne(ScoringPengungkit::class,'file_id','id');
    }

    public function point(){
        return $this->belongsTo(ScoringPengungkit::class,'file_id','id');
    }
}
