<html>
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>App Name - @yield('title')</title>

        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"/>
          <link rel="stylesheet" href="{{asset('assets/css/style.css')}}"/>
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>

        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/popper.min.js')}}" ></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}" ></script>
    </body>

</html>
