<?php

namespace App\Rules;

use App\Models\Student;
use Illuminate\Contracts\Validation\Rule;

class FullNameUnique implements Rule
{
    private $firstName;
    private $middleName;
    private $lastName;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($f, $m, $l)
    {
        //
        $this->firstName = $f;
        $this->middleName = $m;
        $this->lastName = $l;
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
