@extends('layouts.app')
@section('title', 'Users')
@push('styles')
    <link href="library/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="library/pickadate/themes/default.css">
    <link rel="stylesheet" href="library/pickadate/themes/default.date.css">
    <link rel="stylesheet" href="library/select2/css/select2.min.css">
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
                            <h4>MANAGE EMPLOYEE</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <a href="{{ route('adduser') }}" class="btn btn-primary rounded text-white">+ Create New</a>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Employees</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Job Title</th>
                                                <th>Unit</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($users as $user)
                                            @php
                                             $status = $user->status;
                                             if($status == 1){
                                                $badge = '<span class="badge light badge-success">Active</span>';
                                             }else{
                                                $badge = '<span class="badge light badge-danger">Deactive</span>';
                                             }
                                            @endphp
                                            <tr>
                                                <td>{{$user->user_id}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->role}}</td>
                                                <td>{{$user->unit}}</td>
                                                <td>{!!$badge!!}</td>
                                                <td> 
                                                    <div class="d-flex">
                                                        <button data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary shadow btn-xs sharp me-1" data-ename="{{$user->name}}" data-estatus="{{$status}}" data-euid="{{$user->user_id}}"><i class="fas fa-pencil-alt"></i></button>
														<button data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger shadow btn-xs sharp" data-dname="{{$user->name}}" data-duid="{{$user->user_id}}"><i class="fa fa-trash"></i></button>
													</div>
                                                </td>	
                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Job Title</th>
                                                <th>Unit</th>
                                                <th>Status</th>
                                                <th>Action</th>
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
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="myModalLabel">Add New Employee</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{url('/units')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <div class="input-group">
                            <input type="text" name="ausername" class="form-control" placeholder="User Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <div class="input-group">
                            <input type="text" name="aname" class="form-control" placeholder="Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Re-type Password</label>
                        <div class="input-group">
                            <input type="password2" name="password2" class="form-control" placeholder="Password Confirmation" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Join Date</label>
                        <div class="input-group">
                            <input name="datepicker" class="datepicker-default form-control" id="datepicker">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Unit</label>
                        <div class="input-group">
                            <select id="single-select">
                                <option value="AL">Alabama</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button name="addunit" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            </div>
            </div>
        </div>
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="myModalLabel">Manage User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{url('/users')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <div class="input-group">
                            <input type="text" id="ename" name="ename" class="form-control" placeholder="Name" readonly>
                            <input type="hidden" id="euid" name="euid" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="estatus" name="estatus" class="default-select form-control wide">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Plan</label>
                        <select id="eplan" name="eplan" class="default-select form-control wide">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button name="edituser" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="myModalLabel">Delete User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{url('/users')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <div class="input-group">
                            <input type="text" id="dname" name="dname" class="form-control" placeholder="Name" readonly>
                            <input type="hidden" id="duid" name="duid" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button name="deleteuser" type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
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