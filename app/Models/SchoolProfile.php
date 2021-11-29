<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id_no',
        'school_name',
        'school_region',
        'school_division',
        'school_address',
        'school_logo',
        'school_enrollment_url',
        'grade_status'
    ];

    protected $casts=[
        'school_enrollment_url'=>'boolean',
        'grade_status'=>'boolean'
    ];
}
