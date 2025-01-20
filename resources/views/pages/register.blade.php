@extends('layouts.auth')
@section('title', 'Register')
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
@endpush
@section('main')
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<img alt="logo" width="60" src="images/logo-small.png">
									</div>
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <form method="POST" action="{{url('register')}}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Full Name</strong></label>
                                            <input type="text" name="fullname" class="form-control" placeholder="Full Name">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" placeholder="hello@example.com">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password Confirmation</strong></label>
                                            <input type="password" name="password2" class="form-control" placeholder="Re-type Password">
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="{{url('login')}}">Sign in</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!-- Page Specific JS File -->
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
    <script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush