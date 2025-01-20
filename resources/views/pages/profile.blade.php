@extends('layouts.app')
@section('title', 'Profile')
@section('main')
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
				<!-- Add Project -->
				
				<div class="row page-titles mx-0">
					<div class="col-sm-6 p-md-0">
						<div class="welcome-text">
							<h4>Your Profile</h4>
							{{-- <p class="mb-0">Your business dashboard template</p> --}}
						</div>
					</div>
				</div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="profile card card-body px-3 pt-3 pb-0">
                            <div class="profile-head">
                                
                                <div class="profile-info">
									<div class="profile-photo">
										<img src="{{ asset('images/profile/user_default.png') }}" class="img-fluid rounded-circle bg-light" alt="">
									</div>
									<div class="profile-details">
										<div class="profile-name px-3 pt-2">
											<h4 class="text-primary mb-0">{{$user->name}}</h4>
											<p>{{$username}}</p>
										</div>
										
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link active show">Account Information</a>
                                            </li>
                                            <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link">Setting</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="about-me" class="tab-pane fade active show">
                                                <div class="profile-personal-info mt-4">
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Name <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>{{$user->name}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">User ID <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>{{$user->user_id}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Email <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>{{$user->email}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Phone <span class="pull-end">:</span></h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>{{$user->phone}}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Plan <span class="pull-end">:</span></h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>{{$user->plan}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="profile-settings" class="tab-pane fade">
                                                <div class="mt-4">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <div class="nav flex-column nav-pills mb-3">
                                                                <a href="#v-pills-password" data-bs-toggle="pill" class="nav-link active show">Change Password</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <div class="tab-content">
                                                                <div id="v-pills-password" class="tab-pane fade active show">
                                                                    <form method="POST" action="{{url('profile')}}">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label class="mb-1"><strong>Old Password</strong></label>
                                                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="mb-1"><strong>New Password</strong></label>
                                                                        <input type="password" name="password2" id="password2" class="form-control" placeholder="Password" required>
                                                                    </div>
                                                                    <button name="change_password" type="submit" class="btn btn-primary btn-block">Change Password</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
@endsection
@push('scripts')
@endpush