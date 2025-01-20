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
                            <h4>API LOG</h4>
                        </div>
                    </div>
                    {{-- <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <button data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary rounded text-white">+ Create New</button>
                    </div> --}}
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
                                                
                                                <th>Request Body</th>
                                                <th>Response</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($api_logs as $log)
                                            @php
                                            $status = $log->status;
                                            if($status == 4){
                                                $badge = '<span class="badge light badge-success">Success</span>';
                                            }elseif($status == 2){
                                                $badge = '<span class="badge light badge-danger">Failed</span>';
                                            }else{
                                                $badge = '<span class="badge light badge-warning">Need Caution</span>';
                                            }
                                            @endphp
                                            <tr style="color: #5a5a5a">
                                                <td class="text-nowrap">{{$log->date}}</td>
                                                <td>{{$log->body}}</td>
                                                <td>{{$log->response_server}}</td>
                                                <td>{!!$badge!!}</td>
                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Date</th>
                                                <th>Endpoint</th>
                                                <th>Request Body</th>
                                                <th>Response</th>
                                                <th>Status</th>
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
<script>
    $(document).ready(function() {
        $('#editModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var name = button.data('ename');
            var status = button.data('estatus').toString();
            var plan = button.data('eplan');
            var uid = button.data('euid');
            // Set nilai ke form
            $('#estatus').selectpicker('val', status);
            $('#eplan').selectpicker('val', plan);
            $('#ename').val(name);
            $('#euid').val(uid);
        });
    });
    </script>
    <script>
        $(function() {
                $('#deleteModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var name = button.data('dname');
                    var uid = button.data('duid');
                    var modal = $(this);
                    console.log(name);
                    console.log(uid);
                    modal.find('#dname').val(name);
                    modal.find('#duid').val(uid);
                });
            })
    </script>
@endpush