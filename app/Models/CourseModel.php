<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class CourseModel extends Model
{
    use HasFactory;

    protected $table = 'course'; //define that this model is related to the class table

    public function student()
    {
        return $this->hasMany(Student::class);
    }
}
