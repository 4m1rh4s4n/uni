@extends('adminlte::page')

@section('content')
<div class="card mt-3 p-5">
    @include('components.lang' , ['route' => 'user.profile' , 'data' => '' , 'dataEn' => 'en'])
    <form action="{{ route('user.profile.set', ['lang'=>$lang]) }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="name" class="sr-only">Name</label>
            <input value="{{$user->name}}" type="text" class="form-control" id="name" placeholder="Name" name="name"
                required>
        </div>
        <div class="form-group mb-3">
            <label for="last_name" class="sr-only">Last Name</label>
            <input value="{{$user->last_name}}" type="text" class="form-control" id="last_name" placeholder="Last Name"
                last_name="name" required>
        </div>
        <div class="form-group mb-3">
            <label for="phone" class="sr-only">Phone</label>
            <input value="{{$user->phone}}" type="text" class="form-control" id="phone" placeholder="phone" name="Phone"
                required>
        </div>
        <div class="form-group mb-3">
            <label for="public_mail" class="sr-only">Public Email</label>
            <input value="{{$user->public_mail}}" type="email" class="form-control" id="public_mail"
                placeholder="Public Email" name="public_mail" required>
        </div>
        <div class="form-group mb-3">
            <label for="field" class="sr-only">Field</label>
            <input value="{{$user->field}}" type="text" class="form-control" id="field" placeholder="field" name="Field"
                required>
        </div>
        <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-check"></i></button>
    </form>
</div>

@endsection
