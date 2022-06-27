<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Employee extends Model
{
    use HasFactory;
    protected $table = "employees";
    protected $fillable = [
        'firstname',
        'lastname',
        'company',
        'email',
        'phone'
    ];

    // reverse relation with company
    public function company() {
        return $this->belongsTo(Company::class, 'company', 'id');
    }
}
