<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Student::insert([
            'idNumber' => '20180013809',
            'slmisNumber' => '32151',
            'sex' => 'Female',
            'firstName' => 'Iris',
            'middleName' => 'Clear',
            'lastName' => 'Suaner',
            'birthday' => '2020/10/10',
        ]);
    }
}
