@extends('layouts.main')
@section('content')
    @if($model)
    <table class="table table-responsive table-bordered">
        <tr>
            <td>First Name</td>
            <td>{{$model->first_name}}</td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td>{{$model->last_name}}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{$model->email}}</td>
        </tr>
        <tr>
            <td>Gender</td>
            <td>{{$model->gender}}</td>
        </tr>
        <tr>
            <td>Bithday</td>
            <td>{{$model->birthdate}}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{$model->address}}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{$model->phone}}</td>
        </tr>
    </table>
    @else
        <h4>No Data Found For You </h4>
    @endif

@endsection
