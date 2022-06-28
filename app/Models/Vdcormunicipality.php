<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vdcormunicipality extends Model
{
    use HasFactory;
    protected $table = "vdcormunicipalities";
    protected $fillable = [
        'municipalityname',
        'districtid',
        'status',
    ];

    public function district() {
        return $this->belongsTo('App\Models\District', 'districtid', 'id');
    }
}
