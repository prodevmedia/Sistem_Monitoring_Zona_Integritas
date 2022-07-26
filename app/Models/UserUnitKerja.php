<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class UserUnitKerja extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "unit_kerjas";
    protected $primaryKey='id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'username',
        'master_unit_kerja_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user associated with the UnitKerja
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function masterunitkerja()
    {
        return $this->hasOne(MasterUnitKerja::class,'id','master_unit_kerja_id');
    }

    public function file(){
        return $this->belongsTo(FileUpload::class,'id','user_id');
    }
    static function get_all(){
        $data = DB::table('unit_kerjas')->get();
        return $data;
    }
    static function get_by_id($id){
        $data = DB::table("unit_kerjas")->where('id',$id)->get();
        return $data;
    }
    public function rencanakerja(){
        return $this->belongsTo(RencanaKerja::class,'unit_kerja_id');
    }
    
}
