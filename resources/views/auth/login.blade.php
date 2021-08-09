@extends('adminlte::auth.login')

@if ($admin)

@section('login_url' , 'login?admin=true')
@section('register_url' , 'register?admin=true')

@else

@section('login_url' , 'login')
@section('register_url' , 'register')

@endif
