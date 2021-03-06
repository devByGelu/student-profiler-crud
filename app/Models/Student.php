<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = ['idNumber', 'slmisNumber', 'sex', 'firstName', 'middleName', 'lastName', 'birthday'];
    public $timestamps = false;
}
