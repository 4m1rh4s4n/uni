<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$user->profile->name}} {{$user->profile->last_name}}</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/style.css') }}">
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
        <section class="d-flex align-items-center">
            <img class="profile-img mx-2" src="{{ asset($user->image) }}">
            <span>
                <div>{{$user->profile->name}} {{$user->profile->last_name}}</div>
                <div>{{$user->profile->field}}</div>
                <div>{{__("public.phone")}} : {{$user->profile->phone}}</div>
                <div>{{__("public.email")}} : {{$user->profile->public_mail}}</div>
            </span>
        </section>
        <div class="my-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true">{{__('adminlte::menu.publications')}}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false">{{__('adminlte::menu.awards')}}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                        aria-controls="contact" aria-selected="false">{{__('adminlte::menu.thesis')}}</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    @foreach ($user->publications as $pub)
                    <div>{{$pub->name}}</div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @foreach ($user->awards as $award)
                    <div>{{$award->name}}</div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    @foreach ($user->thesis as $thes)
                    <div>{{$thes->name}}</div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
