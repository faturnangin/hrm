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
                <div class="row page-titles mx-0">
					<div class="col-sm-6 p-md-0">
						<div class="welcome-text">
							<h4>Edit Employee</h4>
						</div>
					</div>
					<div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('users') }}">Employee</a></li>
							<li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Employee</a></li>
						</ol>
					</div>
				</div>
                <!-- row -->
                <div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{route('edituser', ['id' => $user->user_id])}}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Username</strong></label>
                                        <input type="text" name="username" class="form-control" placeholder="Username" value="{{$user->user_id}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Full Name</strong></label>
                                        <input type="text" name="fullname" class="form-control" placeholder="Full Name" value="{{$user->name}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Join Date</strong></label>
                                        <input name="joindate" class="datepicker-default form-control" id="datepicker" value="{{$user->join_date}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Unit</strong></label>
                                        <select name="unit" class="single-select" required>
                                            <option value="">Pilih Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->name }}" 
                                                    {{ $unit->name == $user->unit ? 'selected' : '' }}>
                                                    {{ $unit->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Job Title</strong></label>
                                        <select name="jobtitles[]" class="multi-select2" multiple="multiple" required>
                                            <option value="">Pilih Job Title</option>
                                            @foreach ($jobtitles as $jobtitle)
                                                <option value="{{ $jobtitle->name }}" 
                                                    {{ in_array($jobtitle->name, explode(',', $user->role)) ? 'selected' : '' }}>
                                                    {{ $jobtitle->name }}
                                                </option>
                                            @endforeach

                                            @foreach (explode(',', $user->role) as $role)
                                                @if (!in_array($role, $jobtitles->pluck('name')->toArray()))
                                                    <option value="{{ $role }}" selected>{{ $role }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary btn-block">Edit User</button>
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