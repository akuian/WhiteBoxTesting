<?php

namespace App\Http\Controllers;


use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ClassModel;

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
        $student = Student::with('class')->get();
        $paginate = Student::orderBy('id_student','asc')->paginate(3);
        return view('student.index', ['student'=>$student,'paginate'=>$paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $class = ClassModel::all(); //get data from class table
        return view('student.create', ['class' => $class]);
    }

    public function search(Request $request){
        $search = $request->search;
        $student = Student::where('name','like','%'.$search.'%')->paginate();
        return view('student.index', ['student' => $student]);
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
            'Nim' => 'required',
            'Name'=> 'required',
            'Class'=> 'required',
            'Major' => 'required',
            'Address' => 'required',
            'date_of_birth' => 'required'
        ]);

        $student = new Student;
        $student -> nim = $request->get('Nim');
        $student -> name = $request->get('Name');
        $student -> major = $request->get('Major');
        $student -> address = $request->get('Address');
        $student -> date_of_birth = $request->get('date_of_birth');
        $student -> save();

        $class = new ClassModel;
        $class->id = $request->get('Class');
        //eloquent function to add data
        $student->class()->associate($class);
        $student->save();
        //if the date is added succesfully, returned to the main page
        return redirect()->route('student.index')
        ->with('success','Student Succesfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        //displays detailed data by finding/ by Student Nim
        $Student = Student::with('class')->where('nim', $nim)->first();
        return view('student.detail', ['Student'=> $Student]);
    }

    public function test($nim)
    {
        $Student = Student::with('course')->where('nim', $nim)->first();
        return view('student.grade', ['Student'=> $Student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        //displays detail data by finding on Student nim
        $Student = Student::with('class')->where('nim', $nim)->first();
        $class=classModel::all();
        return view('student.edit', compact('Student','class'));
        return redirect()->route('student.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        //validate the data
        $request->validate([
            'Nim' => 'required',
            'Name'=> 'required',
            'Class'=> 'required',
            'Major'=> 'required',
            'Address' => 'required',
            'date_of_birth' => 'required'
        ]);

        //Eloquent function to update the data
        $student = Student::with('class')->where('nim', $nim)->first();
        $student -> nim = $request->get('Nim');
        $student -> name = $request->get('Name');
        $student -> major = $request->get('Major');
        $student -> address = $request->get('Address');
        $student -> date_of_birth = $request->get('date_of_birth');
        $student -> save();

        $class = new ClassModel;
        $class->id = $request->get('Class');

        $student->class()->associate($class);
        $student->save();

        return redirect()->route('student.index')
        ->with('success', 'Student Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        //Eloquent function to delete the data
        Student::where('nim',$nim)->delete();
        return redirect()->route('student.index')
        -> with('success' . 'Student Succesfully Deleted');
    }
}
