<html>
    <head>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="librarybase.blade.php?<?php echo date('Ymd-Hi'); ?>" rel="stylesheet" type="text/css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.10/css/mdb.min.css" rel="stylesheet">
        <!-- icon -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
        <style>
            body {
                background-image: url({{ url('/image/backer.png') }}); 
            }
            .sample-color{color:#FFFFFF}
            .logo-Lsize{height:50px}
            .logo-Ssize{height:40px}
            .grayer{back-ground-color: #555555; opacity: 0.5;}

            .square-frame {
                border: 1px dotted #999;
            }
            .square-content {
                display: block;
                height: 0;
                width: 100%;
                padding-bottom: 100%;
            }
            .bo-ra{
                border-radius:10px;
            }
            a {
            color: black;
            }
                        .errorAlert{color:#FF0000; margin:4px; padding:1px 5px; font-family:serif; background-color:#DDBBBB; border-radius:6px;}
            hr { background-color:#DDDDFF; margin:25px 100px; border-top:1px dashed #AAAAAA;}
            footer { text-align:right; font-size:10pt; margin:10px; border-bottom:solid 1px #AAAAAA; color:#AAAAAA;}
        </style>
        @yield('heading')
    </head>

    <body>
        <!-- ステータスバー(大画面) -->

        <div class="d-none d-sm-block">

            <nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color:black;">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    <a class="navbar-brand" href="{{ url('/admin/home') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                        
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="">USER : NONE</a>
                        </li>
                    @else
                        <li class="nav-item dropdown ml-5">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                USER : {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="post" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest

                    <li class="nav-item dropdown ml-2">
                        <a class="nav-link dropdown-toggle waves-effect waves-light" id="dd2L" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">OTHER PAGE</a>
                        <div class="dropdown-menu dropdown-info" aria-labelledby="dd2L">
                            <a class="dropdown-item waves-effect waves-light" href="{{ url('/student/list') }}">STUDENT_LIST</a>
                            <a class="dropdown-item waves-effect waves-light" href="{{ url('/admin/list') }}">ADMIN_LIST</a>
                        </div>
                    </li>

                    </ul>
                </div>
            </nav>
        </div>
        <!-- // ステータスバー(大画面) -->
        <div class="container-fluid mt-5" style="padding-top:45px;">
        @yield('content')
        </div>
        



        <!-- JQuery -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.10/js/mdb.min.js"></script>
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
        @yield("script")
    </body>
</html>