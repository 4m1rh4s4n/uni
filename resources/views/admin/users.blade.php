@extends('adminlte::page')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalCustom">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="nav-item">

                <a class="nav-link @if (!$trash) active @endif"
                    href="{{ route('admin.users') }}">{{__('dashboard.active')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if ($trash) active @endif"
                    href="{{ route('admin.users') }}/trash">{{__('dashboard.disable')}}</a>
            </li>
        </ul>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Settings</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->email}}</td>
                    <td>{{$user->created_at}}</td>
                    <td>
                        <a href="#" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        @if (!$trash)
                        <a href="{{ route('admin.user.delete.soft', ['id'=>$user->id]) }}" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                        </a>
                        @else
                        <a href="{{ route('admin.user.delete.hard', ['id'=>$user->id]) }}" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <th class="text-danger text-center" colspan="4">No Users Found!</th>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $users->withQueryString()->links() }}
    </div>
</div>

<x-adminlte-modal id="modalCustom" title="Account Policy" size="lg" theme="teal" icon="fas fa-bell" v-centered
    scrollable>
    <form action="{{ route('admin.users.create') }}" method="post">
        {{ csrf_field() }}

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('email'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </div>
            @endif
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password"
                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="{{ __('adminlte::adminlte.password') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('password'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </div>
            @endif
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
            @if($errors->has('password_confirmation'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </div>
            @endif
        </div>

        {{-- Register button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            {{ __('adminlte::adminlte.register') }}
        </button>

    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>

@endsection
