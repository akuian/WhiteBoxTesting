@extends('student.layout')
@section('content')
<style type="text/css">
		.pagination li{
			float: left;
			list-style-type: none;
			margin:5px;
		}
	</style>
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>INFORMATION TECHNOLOGY-STATE POLYTECHNIC OF MALANG</h2>
        </div>
        <h1>Grade Card</h1>
    </div>
</div>

<table class="table table-bordered">
    <tr>
        <th>Course Name</th>
        <th>SKS</th>
        <th>Semester</th>
        <th>Grade</th>
    </tr>
    @foreach ($course as $crs)
    <tr>
        <td>{{ $course ->course_name }}</td>
        <td>{{ $course ->sks }}</td>
        <td>{{ $course ->semester }}</td>
        <td>{{ $course ->course_student ->value }}</td>
    </tr>
    @endforeach
</table>
@endsection
