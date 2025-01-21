@extends('layouts.app')
@section('title', 'Dashboard')
@section('main')
<div class="content-body">
    <div class="container-fluid">
        <!-- Add Project -->
        <div class="row">
            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
                <div class="card card-bd">
                    <div class="bg-secondary card-border"></div>
                    <div class="card-body box-style">
                        <div class="media align-items-center">
                            <div class="media-body me-3">
                                <h2 class="text-black font-w700">{{$count_user}}</h2>
                                <span class="fs-14">Employee</span>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
                <div class="card card-bd">
                <div class="bg-warning card-border"></div>
                    <div class="card-body box-style">
                        <div class="media align-items-center">
                            <div class="media-body me-3">
                                <h2 class="text-black font-w700">{{$count_login}}</h2>
                                <span class="fs-14">Login Count</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
                <div class="card card-bd">
                <div class="bg-primary card-border"></div>
                    <div class="card-body box-style">
                        <div class="media align-items-center">
                            <div class="media-body me-3">
                                <h2 class="text-black font-w700">{{$count_unit}}</h2>
                                <span class="fs-14">Unit</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
                <div class="card card-bd">
                    <div class="bg-info card-border"></div>
                    <div class="card-body box-style">
                        <div class="media align-items-center">
                            <div class="media-body me-3">
                                <h2 class="text-black font-w700">{{$count_role}}</h2>
                                <span class="fs-14">Positions</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-xxl-12">
                <div class="card">
                    <div class="card-header d-block border-0 pb-0">
                        <div class="d-flex justify-content-between pb-3">
                            <h4 class="mb-0 text-black fs-20">Most Frequent Login</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Login Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr>
                                        <td>{{$topUser->user}}</td>
                                        <td>{{$topUser->login_count}}</td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>		
            </div>
        </div>	
    </div>
</div>
@endsection
@push('scripts')
<script>

</script>
@endpush