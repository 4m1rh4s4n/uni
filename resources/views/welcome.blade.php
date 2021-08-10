<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$user->profile->name}} {{$user->profile->last_name}}</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    @if ($lang)
    <style>
        body {
            direction: rtl;
            text-align: right
        }
    </style>
    @endif
</head>

<body>
    <div class="container">
        <a href="{{ route('public.user', ['slug'=>$user->slug , 'locale' => 'en']) }}">En</a>
        <a href="{{ route('public.user', ['slug'=>$user->slug]) }}">Fa</a>
        <section>
            <div>{{$user->profile->name}} {{$user->profile->last_name}}</div>
            <div>{{$user->profile->field}}</div>
            <div>{{__("public.phone")}} : {{$user->profile->phone}}</div>
            <div>{{__("public.email")}} : {{$user->profile->public_mail}}</div>
        </section>
        <section>
            @foreach ($user->publications as $pub)
            <div>{{$pub->name}}</div>
            @endforeach
        </section>
        <section>
            @foreach ($user->awards as $award)
            <div>{{$award->name}}</div>
            @endforeach
        </section>
        <section>
            @foreach ($user->thesis as $thes)
            <div>{{$thes->name}}</div>
            @endforeach
        </section>
    </div>
</body>

</html>
