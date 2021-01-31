<html>
    <head>
        <title>@yield('title') | TheWorld</title>
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
            .theWorld{
                width:  30px;       /* ※縦横を同値に */
                height: 30px;       /* ※縦横を同値に */
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
        <div>
        <!-- ステータスバー(大画面) -->

        <div class="d-none d-sm-block">

            <nav class="navbar navbar-expand-lg fixed-top" style="background-color:#BFDFFF;">
                <!-- navbar-dark -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    <a class="navbar-brand waves-effect" href="{{ url('/user/home') }}">
                    <!-- <img src="/image/theWorldLogo.png" alt="●" class="theWorld"> -->
                    {{ config('app.name', 'Laravel') }}
                </a>
                        
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="">USERNAME : NONE</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    USER : {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest

                        <li class="nav-item active">
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" id="dd2L" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">MENU</a>
                            <div class="dropdown-menu dropdown-info" aria-labelledby="dd2L">
                                <a class="dropdown-item waves-effect waves-light" href="{{ url('/user/lesson/create') }}">レッスン登録</a>
                                <a class="dropdown-item waves-effect waves-light" href="{{ url('/user/lesson/search') }}">レッスン検索</a>
                                <a class="dropdown-item waves-effect waves-light" href="{{ url('/user/profile') }}">プロフィール</a>
                                <a class="dropdown-item waves-effect waves-light" href="{{ url('/user/chat') }}">チャット</a>
                                <a class="dropdown-item waves-effect waves-light" href="{{ url('/user/lesson/list') }}">レッスン一覧</a>
                                <a class="dropdown-item waves-effect waves-light" href="{{ url('/user/lesson/log') }}">レッスン履歴</a>
                            </div>
                        </li>
                    </ul>
                    
                </div>
            </nav>


        </div>
        <!-- // ステータスバー(大画面) -->
        <div class="container-fluid my-5" style="padding-top:15px;">
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
        @yield("script")
        </div>
    </body>
    <footer class=" text-center color-black py-2" style="background-color:#BFDFFF; bottom:0; position:fixed; width:100%; margin:0px;">
        © 2020 Aso College Group Team5.
    </footer>
</html>