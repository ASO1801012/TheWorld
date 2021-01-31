<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>The World</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                color: #FFF;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                text-shadow:5px 0 5px black;
                background-image: url({{ url('/image/back.jpg') }}); /* 背景画像 */
                background-size: cover;               /* 全画面 */
                background-attachment: fixed;         /* 固定 */
                background-position: center center;   /* 縦横中央 */
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
                color: #000;
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

            .btn-border {
            display: inline-block;
            max-width: 180px;
            text-align: left;
            border: 2px solid #FF6633;
            font-size: 16px;
            color: #FF6633;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
            transition: .4s;
            }

            .btn-border:hover {
            background-color: #FF6600;
            border-color: #FF6633;
            color: #FFF;
            }

        </style>
    </head>
    
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    The World
                </div>
                <div class="links">
                世界を一緒に。<br><br><br>
                    <div class="container">
                        <a href="{{ url('/user/login') }}" class="btn-border">今すぐ始める</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>