<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="admin, dashboard">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="fasto : sass Admin Dashboard  Bootstrap 5 Template">
	<meta property="og:title" content="fasto : sass Admin Dashboard  Bootstrap 5 Template">
	<meta property="og:description" content="fasto : sass Admin Dashboard  Bootstrap 5 Template">
	<meta property="og:image" content="https://fasto.dexignzone.com/xhtml/social-image.png">
	<meta name="format-detection" content="telephone=no">
    @stack('styles')

    <title>@yield('title')</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}"> 
	<link rel="stylesheet" href="{{ asset('library/chartist/css/chartist.min.css') }}">
    <link href="{{ asset('library/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="vh-100">
    <!--**********************************
            Content body start
    ***********************************-->
    @yield('main')
    <!--**********************************
            Content body end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
	@stack('scripts')
</body>
</html>