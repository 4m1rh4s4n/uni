@extends('adminlte::page')

@section('content')
<div class="card mt-3 p-5">
    @php
    $admin = false;
    if(session("role") == 'admin')
    {
    $admin = true;
    }
    @endphp

    <form action="@if ($admin){{ route('admin.settings') }}@else{{ route('admin.settings') }}@endif" method="POST">
        @csrf
        @if ($admin)
        <div class="form-group mb-3">
            <label for="name" class="sr-only">Name</label>
            <input value="{{$user->name}}" type="text" class="form-control" id="name" placeholder="Name" name="name"
                required>
        </div>
        @endif
        <div class="form-group mb-3">
            <label for="name" class="sr-only">Email</label>
            <input value="{{$user->email}}" type="email" class="form-control" id="email" placeholder="Email"
                name="email" required>
        </div>
        {{-- Password field --}}
        <div class="form-group mb-3">
            <div class="input-group mb-3">
                <input type="password" name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="{{ __('adminlte::adminlte.password') }}">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Confirm password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation"
                class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                placeholder="{{ __('adminlte::adminlte.retype_password') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-check"></i></button>
    </form>
</div>

@endsection
