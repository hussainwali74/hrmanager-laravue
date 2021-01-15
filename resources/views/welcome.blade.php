<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>
            (function () {
                window.laravel={
                    csrfToken:'{{csrf_token()}}'
                };

            })();

        </script>

        <title>HR | iOptime</title>

        <link rel="stylesheet" href="/css/all.css">

    </head>
    <body>

    <div id="app">
        @if(Auth::check())
          <mainapp :user="{{Auth::user()}}"></mainapp>

        @else
            <mainapp :user="false"></mainapp>

        @endif
    </div>

    </body>

<script src="{{mix('/js/app.js')}}"></script>
</html>
