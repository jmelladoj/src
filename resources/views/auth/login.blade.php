<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> SRCENTER - Login </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/login.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

</head>
<body class="skin-default card-no-border">
    <div id="app">
        <div id="app">
            <main class="py-4">
                <section id="wrapper">
                    <div class="login-register">
                        <div class="login-box card">
                            @if($errors->any())
                                <div class="form-group alert alert-danger">
                                    <center>
                                        @foreach($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                    </center>
                                </div>
                            @endif
            
                            <div class="card-body">
                                <form class="form-horizontal form-material" id="loginform" action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <h3 class="box-title m-b-40 text-center">SRCENTER ONLINE - INICIO</h3>
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <input class="form-control" id="email" name="email" type="text" required="" placeholder="Usuario"> </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <input class="form-control" id="password" name="password" type="password" required="" placeholder="Password"> </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <div class="col-xs-12 p-b-20">
                                            <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit">{{ __('Ingresar') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</body>
</html>
