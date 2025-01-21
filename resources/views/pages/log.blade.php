@extends('layouts.app')
@section('title', 'Log')
@push('styles')
    <link href="library/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="library/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
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
                            <h4>Activity Log</h4>
                        </div>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Transaction History {{$date}}</h4>
                            </div>
                            
                            <div class="card-body">
                                <p class="mb-1">Date Range</p>
                                <form method="POST" action="{{url('/log')}}" class="w-100 d-flex gap-2 align-items-center">
                                    @csrf
                                    <div class="example w-100">
                                        <input class="form-control input-daterange-datepicker" type="text" name="daterange" value="{{$date}}">
                                    </div>
                                    <button name="filter" type="submit" class="btn btn-primary">Filter</button>
                                </form>
                                <div class="table-responsive mt-4">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>User</th>
                                                <th>Activity</th>
                                                <th>IP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($user_activities as $log)
                                            <tr style="color: #5a5a5a">
                                                <td class="text-nowrap">{{$log->date_created}}</td>
                                                <td>{{$log->user}}</td>
                                                <td>{{$log->activity}}</td>
                                                <td>{{$log->ip}}</td>
                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Date</th>
                                                <th>User</th>
                                                <th>Activity</th>
                                                <th>IP</th>
                                            </tr>
                                        </tfoot>
                                    </table>
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
<script src="{{ asset('library/moment/moment.min.js') }}"></script>
<script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{ asset('library/pickadate/picker.js') }}"></script>
<script src="{{ asset('library/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('library/pickadate/picker.date.js') }}"></script>

<script src="{{ asset('js/plugins-init/bs-daterange-picker-init.js') }}"></script>
<script src="{{ asset('js/plugins-init/pickadate-init.js') }}"></script>

<script src="{{ asset('library/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
@endpush