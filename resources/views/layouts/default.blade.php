<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- BootstrapのCSS読み込み -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        img{
            height: 80px;
        }
        .price{
            font-size: 20px;
            color: #b12704;
        }
        .item{
            display: inline;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <h1 class="navbar-brand">@yield('nav_title')</h1>
        </div>
        <div id="navbarEexample">
            <ul class="nav  navbar-nav">
                @yield('nav_content')
                <li class="nav-item">
                    <form action="{{ url('/logout') }}" method="post">
                        {{ csrf_field() }}
                        <button class="btn btn-primary" type="submit">ログアウト</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    @yield('content')
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>