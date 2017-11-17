<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NerdRunClub</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="  crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">

    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/screen.css">
    <link rel="stylesheet" href="/css/leaderboards.css">
    <link rel="stylesheet" href="/css/user.css">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="/css/splash.css">
    @yield('stylesheets')

</head>
<body>
    @isset($user)
        @include('layouts.partials._navigation')
    @endisset
    <div class="wrap">
        @yield('content')
    </div>

    @isset($user)
        @if($user->role == "Teacher")
            <div class="go-to-event">
                <a href="/admin/event">add event</a>
            </div>
        @endif
    @endisset
</body>
@yield('scripts')
</html>

