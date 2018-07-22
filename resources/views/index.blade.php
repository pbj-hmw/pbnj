<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Home Cooked</title>
    <meta name="description" content="Home Cooked is the live mobile cooking show that gives amateur cooks an interactive opportunity to become expert chefs, right at home." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ URL::asset('favicon.png') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
        <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ URL::asset('img/logo.svg') }}" /></a>
    </nav>
    <div class="row main">
        <div class="col-12 col-md-6">
            <h1>Become a master chef</h1>
            <p>Home Cooked is the live mobile cooking show that gives amateur cooks an interactive opportunity to become expert chefs, right at home.</p>
        </div>
    </div>
    <div class="row justify-content-md-start buttons text-center text-md-left">
        <div class="col-12 col-md-6">
            <a class="btn btn-app" id="google" href="#">
                <div class="row text-left">
                    <div class="col-3"><i class="fab fa-android fa-2x mt-2"></i></div>
                    <div class="col-9">
                        available on <br />
                        <span class="font-weight-bold">Play Store</span>
                    </div>
                </div>
            </a>
            <a class="btn btn-app active" id="apple" href="#">
                <div class="row text-left">
                    <div class="col-3"><i class="fab fa-apple fa-2x mt-2"></i></div>
                    <div class="col-9">
                        available on <br />
                        <span class="font-weight-bold">App Store</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/app.js') }}"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','https://www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-57323620-39', 'auto'); ga('send', 'pageview');
</script>
</body>
</html>