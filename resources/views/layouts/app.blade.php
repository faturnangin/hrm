<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="admin, dashboard">
	<meta name="author" content="Nusa Solutions">
	<meta name="robots" content="index, follow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Nusa POS : Scan Passport SaaS">
	<meta property="og:title" content="Nusa POS : Scan Passport SaaS">
	<meta property="og:description" content="Nusa POS : Scan Passport SaaS">
	<!-- <meta property="og:image" content="https://fasto.dexignzone.com/xhtml/social-image.png"> -->
	<meta name="format-detection" content="telephone=no">
    <title>@yield('title')</title>
    <!-- Favicon icon -->
    @stack('styles')
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}"> 
	<link rel="stylesheet" href="{{ asset('library/chartist/css/chartist.min.css') }}">
    <link href="{{ asset('library/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        @include('components.nav-header')
        @include('components.header')
        @include('components.sidebar')
		<!--**********************************
            Content body start
        ***********************************-->
        @yield('main')
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                 <p>Developed by <a href="#" target="_blank">Fatur Nangin</a> 2025</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('library/global/global.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/Chart.bundle.min.js') }}"></script>
	
	<!-- Chart piety plugin files -->
    <script src="{{ asset('library/peity/jquery.peity.min.js') }}"></script>
	
	<!-- Apex Chart -->
    <script src="{{ asset('library/apexchart/apexchart.js') }}"></script>
	
	<!-- Dashboard 1 -->
    {{-- <script src="{{ asset('js/dashboard/dashboard-1.js') }}"></script> --}}
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/deznav-init.js') }}"></script>
    <script src="{{ asset('js/demo.js') }}"></script>
    <script src="{{ asset('js/styleSwitcher.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    @if (session('success'))
    <script>
        var notyf = new Notyf();
        notyf.success('{{ session('success') }}');
    </script>
    @endif
    @if (session('error'))
    <script>
        var notyf = new Notyf();
        notyf.error('{{session('error')}}');
    </script>
    @endif
	@stack('scripts')
</body>
</html>
