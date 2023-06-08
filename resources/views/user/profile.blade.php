@extends('layouts.main')
@section('content')
    <form method="post"  enctype="multipart/form-data" >
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name" value="{{$model->name}}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Profile Photo </label>
            <input type="file" class="form-control" id="name" aria-describedby="emailHelp" name="file">
            @if($file && $file->id)
                <img src="{{url('/file/view/'.$file->hash)}}" height="100px" width="100px">
             @endif
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
