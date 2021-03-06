<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:title"              content="GeekRunners" />
    <meta property="og:description"        content="IMD's very own training platform" />
    <meta property="og:image"              content="https://geekrunners.weareimd.be/img/og-image.jpg" />
    <title>GeekRunners</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="  crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="/img/favicon-01.png"/>

    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/screen.css">
    <link rel="stylesheet" href="/css/leaderboards.css">
    <link rel="stylesheet" href="/css/user.css">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="/css/splash.css">
    <link rel="stylesheet" href="/css/tooltipster.bundle.min.css">
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
                <a href="/admin">add event</a>
            </div>
        @endif
    @endisset
</body>
@yield('scripts')
</html>
