<?php

namespace App\Rules;

use App\Models\Student;
use Illuminate\Contracts\Validation\Rule;

class FullNameUnique implements Rule
{
    private $firstName;
    private $middleName;
    private $lastName;
    private $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($f, $m, $l, $id)
    {
        //
        $this->firstName = $f;
        $this->middleName = $m;
        $this->lastName = $l;
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        if ($this->id > 0) {
            return Student::where('id', '<>', $this->id)->where('firstName', $this->firstName)->where('middleName', $this->middleName)->where('lastName', $this->lastName)->count() == 0;
        }
        $unique = Student::where('firstName', $this->firstName)->where('middleName', $this->middleName)->where('lastName', $this->lastName)->count() == 0;
        return $unique;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Full name is already taken.';
    }
}
