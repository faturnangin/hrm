@extends('layouts.auth')
@section('title', 'Login')
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
                                <h4 class="text-center mb-4">Sign in your account</h4>
                                <form id="loginForm" method="POST" action="{{ route('auth') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Username</strong></label>
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Your Username">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Password</strong></label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                        <div class="form-group">
                                           <div class="form-check custom-checkbox ms-1">
                                                <input type="checkbox" name="remember" id="remember" class="form-check-input" id="basic_checkbox_1">
                                                <label class="form-check-label" for="basic_checkbox_1">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <a href="{{url('forgot-password')}}">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                    </div>
                                </form>
                                <div class="new-account mt-3 mb-0">
                                    <p>Don't have an account? <a class="text-primary" href="{{url('register')}}">Sign up</a></p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check localStorage saat halaman dimuat
            const savedCredentials = localStorage.getItem('userCredentials');
            if (savedCredentials) {
                const credentials = JSON.parse(savedCredentials);
                document.getElementById('email').value = credentials.email;
                document.getElementById('password').value = credentials.password;
                document.getElementById('remember').checked = true;
            }
        
            // Handle form submission
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const remember = document.getElementById('remember').checked;
        
                if (remember) {
                    const credentials = {
                        email: email,
                        password: password
                    };
                    localStorage.setItem('userCredentials', JSON.stringify(credentials));
                } else {
                    localStorage.removeItem('userCredentials');
                }
            });
        });
        
        // Tambahkan fungsi untuk menampilkan error
        function showError(message) {
            const alert = document.getElementById('error-alert');
            alert.textContent = message;
            alert.classList.remove('d-none');
        }
    </script>
@endpush


