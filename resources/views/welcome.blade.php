<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Miu Online Judge</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        
        
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="btn">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                        <img src="http://miuportal.manarat.ac.bd/Images/miu.png" class="img-fluid" alt="Manarat Internation University Logo" height="200" width="100" /> <br/>
                        <h6 class="mt-2"><span class="typing"></span></h6>
                </div>
                
                <div class="links">
                    <a href="http://manarat.ac.bd">Official Website</a>
                    <a href="http://miuportal.manarat.ac.bd">Student Portal</a>
                </div>
            </div>
        </div>

        <!-- https://www.jqueryscript.net/animation/jQuery-Plugin-For-Terminal-Text-Typing-Effect-typed-js.html -->
        <script src="{{asset('startbootstrap/js/typed.min.js')}}"></script>
        <script>
            var typed = new Typed('.typing', {
                    strings: [
                        'Welcome to Miu Online Judge.',
                        'A center of academic and moral execelence.'],
                    typeSpeed: 50,
                    backDelay: 500,
                    contentType: 'html',

            });
        </script>

    </body>
</html>
