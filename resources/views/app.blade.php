<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Builder</title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="/assets/css/builder.css" rel="stylesheet" />

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/remodal.css">
    <link rel="stylesheet" href="/assets/css/remodal-default-theme.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.9.2/themes/smoothness/jquery-ui.css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

@include('includes.header')
@include('layouts.sidebar')
<div class="main">

    @yield('content')

</div>
<!-- Scripts -->
<script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="/assets/js/ckeditor/ckeditor.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="/assets/js/codeeditor/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="/assets/js/builder.js" type="text/javascript" charset="utf-8"></script>
<script src="/assets/js/remodal.js"></script>
</body>
</html>
