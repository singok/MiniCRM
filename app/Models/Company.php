<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Company extends Model
{
    use HasFactory;
    protected $table = "companies";
    protected $fillable = [
        'name',
        'email',
        'website',
        'logo',
        'provinceid',
        'districtid',
        'vdcormunicipalityid'
    ];

    // one to many relation with employee
    public function employee() {
        return $this->hasMany(Employee::class, 'company');
    }

    public function province() {
        return $this->belongsTo('App\Models\Province', 'provinceid');
    }

    public function district() {
        return $this->belongsTo('App\Models\District', 'districtid');
    }

    public function vdcormunicipalities() {
        return $this->belongsTo('App\Models\Vdcormunicipality', 'vdcormunicipalityid');
    }
}
