<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAreaPerubahan extends Model
{
    use HasFactory;
    
    protected $fillable = ['area_perubahan_id','name_sub_area_perubahan','penjelasan','pilihan_jawaban']; 

    public function area(){
        return $this->belongsToMany(AreaPerubahan::class);
    }

    public function areaperubahan(){
        return $this->hasOne(AreaPerubahan::class,'id','area_perubahan_id');
    }
}
