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

        Student::insert([
            'idNumber' => '20101013809',
            'slmisNumber' => '32000',
            'sex' => 'Female',
            'firstName' => 'Alexia',
            'middleName' => 'Clear',
            'lastName' => 'Suaner',
            'birthday' => '2020/10/10',
        ]);

        Student::insert([
            'idNumber' => '20101013801',
            'slmisNumber' => '32001',
            'sex' => 'Female',
            'firstName' => 'Alex',
            'middleName' => 'Claro',
            'lastName' => 'Suaner',
            'birthday' => '2020/10/10',
        ]);

        Student::insert([
            'idNumber' => '2010101380',
            'slmisNumber' => '320000',
            'sex' => 'Female',
            'firstName' => 'Alow',
            'middleName' => 'Claro',
            'lastName' => 'Suaner',
            'birthday' => '2020/10/10',
        ]);
    }
}
