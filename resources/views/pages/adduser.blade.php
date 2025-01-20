@extends('layouts.app')
@section('title', 'Users')
@push('styles')
    <link rel="stylesheet" href="{{ asset('library/pickadate/themes/default.css')}}">
    <link rel="stylesheet" href="{{ asset('library/pickadate/themes/default.date.css')}}">
    <link rel="stylesheet" href="{{ asset('library/select2/css/select2.min.css')}}">
@endpush
@section('main')
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
                
                <!-- row -->
                <div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Employee</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{url('register')}}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Full Name</strong></label>
                                        <input type="text" name="fullname" class="form-control" placeholder="Full Name">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Join Date</strong></label>
                                        <input name="datepicker" class="datepicker-default form-control" id="datepicker">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Unit</strong></label>
                                        <select class="single-select">
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Job Title</strong></label>
                                        <select class="single-select">
                                            @foreach ($jobtitles as $jobtitle)
                                                <option value="{{ $jobtitle->name }}">{{ $jobtitle->name }}</option>
                                            @endforeach
                                        </select>
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
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>
@endsection
@push('scripts')
    <script src="{{ asset('library/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
    <script src="{{ asset('library/pickadate/picker.js') }}"></script> 
    <script src="{{ asset('library/pickadate/picker.time.js') }}"></script> 
    <script src="{{ asset('library/pickadate/picker.date.js') }}"></script> 
    <script src="{{ asset('js/plugins-init/pickadate-init.js') }}"></script>
    <script src="{{ asset('library/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/select2-init.js') }}"></script>
@endpush