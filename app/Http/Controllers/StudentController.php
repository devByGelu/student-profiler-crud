<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Rules\FullNameUnique;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'idNumber' => ['required', 'integer', 'gt:0', 'unique:students'],
            'slmisNumber' => ['required', 'integer', 'gt:0', 'unique:students'],
            'sex' => ['required', 'in:Male,Female'],
            'firstName' => ['required', 'regex:/^[\pL\s\-]+$/u', 'between:2,20', new FullNameUnique($request->input('firstName'), $request->input('middleName'), $request->input('lastName'), -1)],
            'middleName' => ['required', 'regex:/^[\pL\s\-]+$/u', 'between:2,20'],
            'lastName' => ['required', 'alpha', 'between:2,20'], 'birthday' => ['required', 'date'],
            'birthday' => ['required', 'date'],
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
        $student = Student::findOrFail($id);

        if ($request->method() == 'PUT') {

            $s = Student::where('id', $id)->get()[0];
            $nameValidator = ['sometimes', 'regex:/^[\pL\s\-]+$/u', 'between:2,20', new FullNameUnique($request->input('firstName') ? $request->input('firstName') : $s->firstName, $request->input('middleName') ? $request->input('middleName') : $s->middleName, $request->input('lastName') ? $request->input('lastName') : $s->lastName, $s->id)];

            $request->validate([
                'idNumber' => ['required', 'integer', 'gt:0', Rule::unique('students')->ignore($id)],
                'slmisNumber' => ['required', 'integer', 'gt:0', Rule::unique('students')->ignore($id)],
                'sex' => ['required', 'in:Male,Female'],
                'firstName' => $nameValidator,
                'middleName' => $nameValidator,
                'lastName' => $nameValidator,
                'birthday' => ['required', 'date'],
            ]);

        } else {
            $s = Student::where('id', $id)->get()[0];
            $nameValidator = ['sometimes', 'regex:/^[\pL\s\-]+$/u', 'between:2,20', new FullNameUnique($request->input('firstName') ? $request->input('firstName') : $s->firstName, $request->input('middleName') ? $request->input('middleName') : $s->middleName, $request->input('lastName') ? $request->input('lastName') : $s->lastName, $s->id)];

            $request->validate([
                'idNumber' => ['sometimes', 'integer', 'gt:0', Rule::unique('students')->ignore($id)],
                'slmisNumber' => ['sometimes', 'integer', 'gt:0', Rule::unique('students')->ignore($id)],
                'sex' => ['sometimes', 'in:Male,Female'],
                'firstName' => $nameValidator,
                'middleName' => $nameValidator,
                'lastName' => $nameValidator,
                'birthday' => ['sometimes', 'date'],
            ]);
        }
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
