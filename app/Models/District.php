<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = "districts";
    protected $fillable = [
        'districtname',
        'provinceid',
        'status',
    ];

    public function province() {
        return $this->belongsTo('App\Models\Province', 'provinceid', 'id');
    }

    public function vdcormunicipality() {
        return $this->hasMany('App\Models\Vdcormunicipality', 'districtid');
    }
}
