<html>
    <head>
        <title>@yield('title')HikalLibrary</title>
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

            <nav class="navbar navbar-expand-lg fixed-top" style="background-color:#40e0d0;">
                <!-- navbar-dark -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    <a class="navbar-brand" href="{{ url('/user/home') }}">
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
                            <a class="nav-link dropdown-toggle waves-effect waves-light" id="dd2L" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">SUDO</a>
                            <div class="dropdown-menu dropdown-info" aria-labelledby="dd2L">
                                <a class="dropdown-item waves-effect waves-light" href="/user/lesson/list">LESSON_LIST</a>
                                <a class="dropdown-item waves-effect waves-light" href="/user/lesson/create">LESSON_CREATE</a>
                                <a class="dropdown-item waves-effect waves-light" href="/user/lesson/search">LESSON_SEARCH</a>
                                <a class="dropdown-item waves-effect waves-light" href="/user/profile">LESSON_PROFILE</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light" href="/user/login">LOGINPAGE(USER)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light" href="/admin/login">LOGINPAGE(ADMIN)</a>
                        </li>
                    </ul>
                    
                    <a href="https://www.facebook.com" target=”_blank”><i class="fa fa-2x fa-facebook-official white-text mx-2" aria-hidden="true"></i></a>
                    <a href="https://www.twitter.com" target=”_blank”><i class="fa fa-2x fa-twitter white-text mx-2" aria-hidden="true"></i></a>
                    <a href="https://www.instagram.com" target=”_blank”><i class="fa fa-2x fa-instagram white-text mx-2" aria-hidden="true"></i></a>

                    <form class="form-inline" method=get target=”_blank” action="http://www.google.co.jp/search">
                        <div class="md-form my-0">
                            <input class="form-control mr-sm-2" name=q type="text" placeholder="Google Search" aria-label="Search" maxlength=255>
                            <input type=hidden name=ie value=utf-8>
                            <input type=hidden name=oe value=utf-8>
                            <input type=hidden name=hl value="ja">
                        </div>
                    </form>
                </div>
            </nav>


        </div>
        <!-- // ステータスバー(大画面) -->
        <div class="container-fluid my-5" style="padding-top:45px;">
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
    <footer class="text-muted text-center color-black">
    	copyright 2020(R3) 1801007 江崎光
    </footer>
</html>