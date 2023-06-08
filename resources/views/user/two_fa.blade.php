@extends('layouts.login')
@section('content')
    <form method="post" id="form">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Verification Code </label>
            <input type="number" class="form-control" id="code" aria-describedby="emailHelp" name="code">
            <div id="emailHelp" class="form-text">Please Enter Verification Code that We Sent to {{$email}} </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
