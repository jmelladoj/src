<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SRCENTER ADMIN - INICIO</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

</head>
<body class="fixed-layout skin-blue">
    <div id="app">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <center>
                            <a class="navbar-brand" href="{{ url('/') }}">
                                <b>
                                    <!--<img src="" alt="homepage" class="dark-logo" />-->
                                </b> 
                            </a>
                    </center>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></a></li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">--- MENÚ</li>
                        <li @click="menu=0"> <a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu"> SERVICIOS</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i><span class="hide-menu">CERRAR SESIÓN</span> </a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></li>
                    </ul>
                </nav>
            </div>
        </aside>
        
        <template v-if="menu==0">
            <servicios></servicios>
        </template>

        
                
    </div>
</body>
</html>
