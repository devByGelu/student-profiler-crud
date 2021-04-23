<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $primaryKey = 'idNumber';
    public $incrementing = false;
    protected $fillable = ['idNumber', 'slmisNumber', 'sex', 'firstName', 'middleName', 'lastName', 'birthday'];
    public $timestamps = false;
}
