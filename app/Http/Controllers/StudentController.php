<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Student::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'idNumber' => ['required', 'integer', 'gt:0', 'unique:App\Models\Student,idNumber'], 'slmisNumber' => ['required', 'integer', 'gt:0', 'unique:App\Models\Student,slmisNumber'],
            'sex' => ['required', 'in:Male,Female'], 'firstName' => ['required', 'alpha', 'between:2,20'],
            'middleName' => ['required', 'alpha', 'between:2,20'], 'lastName' => ['required', 'alpha', 'between:2,20'], 'birthday' => ['required', 'date'],
        ]);

        return Student::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        return Student::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if ($request->method() == 'PUT') {
            $request->validate([
                'idNumber' => ['required', 'integer', 'gt:0', 'unique:App\Models\Student,idNumber'], 'slmisNumber' => ['required', 'integer', 'gt:0', 'unique:App\Models\Student,slmisNumber'],
                'sex' => ['required', 'in:Male,Female'], 'firstName' => ['required', 'alpha', 'between:2,20'],
                'middleName' => ['required', 'alpha', 'between:2,20'], 'lastName' => ['required', 'alpha', 'between:2,20'], 'birthday' => ['required', 'date'],
            ]);
        } else {
            $request->validate([
                'idNumber' => ['sometimes', 'integer', 'gt:0', 'unique:App\Models\Student,idNumber'],
                'slmisNumber' => ['sometimes', 'integer', 'gt:0', 'unique:App\Models\Student,slmisNumber'],
                'sex' => ['sometimes', 'in:Male,Female'],
                'firstName' => ['sometimes', 'alpha', 'between:2,20'],
                'middleName' => ['sometimes', 'alpha', 'between:2,20'],
                'lastName' => ['sometimes', 'alpha', 'between:2,20'],
                'birthday' => ['sometimes', 'date'],
            ]);
        }
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return $student;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $student = Student::findOrFail($id);
        $student->delete();
        return $student;
    }
}
