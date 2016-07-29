<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content='width=device-width, initial-scale=1, user-scalable=no'>
    <link rel='stylesheet' href="https://fonts.googleapis.com/css?family=Montserrat"/>
    <title>Notifier for Laravel</title>
    <link rel="stylesheet" href="css/notifier.css">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.6/cyborg/bootstrap.min.css" rel="stylesheet"/>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="../" class="navbar-brand">
                <i class="fa fa-paper-plane">
                    | &nbsp; N O T I F Y
                </i>
            </a>
            <button class="navbar-toggle" type='button' data-toggle='collapse' data-target='#navbar-main'>
                <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
        </div>
    </div>
</div>
<div class="container">
    @if(Session::has('message'))
        <div class="alert alert-dismissible alert-success">
            <button class="close" type='button' data-dismiss='alert'>x</button>
            <span>{{ Session::get('message') }}</span>
        </div>
    @endif

    @yield('content')

</div>
<footer class="footer">
    <div class="container">
        <p class="text-muted">
            Made with <i class="fa fa-heart"></i> by your pals
            <a href="http://www.twilio.com">@twilio</a>
        </p>
    </div>
</footer>
<script src="//code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="js/notify.js"></script>
</body>
</html>