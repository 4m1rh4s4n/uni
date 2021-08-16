@extends('adminlte::page')

@section('content')
<div class="card mt-3 p-5">
    @include('components.lang' , ['route' => 'user.profile' , 'data' => '' , 'dataEn' => 'en'])
    <form action="{{ route('user.profile.set', ['lang'=>$lang]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="name" class="sr-only">Name</label>
            <input value="{{isset($user->name) ? $user->name : ''}}" type="text" class="form-control" id="name"
                placeholder="Name" name="name" required>
        </div>
        <div class="form-group mb-3">
            <label for="last_name" class="sr-only">Last Name</label>
            <input value="{{isset($user->last_name) ? $user->last_name : ''}}" type="text" class="form-control"
                id="last_name" placeholder="Last Name" name="last_name" required>
        </div>
        <div class="form-group mb-3">
            <label for="phone" class="sr-only">Phone</label>
            <input value="{{isset($user->phone) ? $user->phone : ''}}" type="text" class="form-control" id="phone"
                placeholder="Phone" name="phone" required>
        </div>
        <div class="form-group mb-3">
            <label for="public_mail" class="sr-only">Public Email</label>
            <input value="{{isset($user->public_mail) ? $user->public_mail : ''}}" type="email" class="form-control"
                id="public_mail" placeholder="Public Email" name="public_mail" required>
        </div>
        <div class="form-group mb-3">
            <label for="field" class="sr-only">Field</label>
            <input value="{{isset($user->field) ? $user->field : ''}}" type="text" class="form-control" id="field"
                placeholder="Field" name="field" required>
        </div>
        <div class="form-row">
            <div class="col-11">
                <div class="custom-file mb-3">
                    <input name="image" type="file" accept="image/*" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <div class="col-1">
                @if (!isset($user->image))
                <img src="{{ asset('img/user.png') }}" style="width: 150px;height: 150px;">
                @else
                <img src="{{ asset($user->image) }}" style="width: 150px;height: 150px;">
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-check"></i></button>
    </form>
</div>

@endsection
