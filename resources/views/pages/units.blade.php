@extends('layouts.app')
@section('title', 'Manage Units')
@push('styles')
    <link href="library/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
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
                            <h4>MANAGE UNIT</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <button data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary rounded text-white">+ Create New</button>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Units</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($units as $unit)
                                            <tr>
                                                <td>{{$unit->name}}</td>
                                                <td>{{$unit->description}}</td>
                                                <td> 
                                                    <div class="d-flex">
														<button data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary shadow btn-xs sharp me-1" data-ename="{{$unit->name}}" data-edescription="{{$unit->description}}" data-eid="{{$unit->id}}"><i class="fas fa-pencil-alt"></i></a>
														<button data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger shadow btn-xs sharp" data-dname="{{$unit->name}}" data-did="{{$unit->id}}"><i class="fa fa-trash"></i></button>
													</div>
                                                </td>	
                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
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
                  <h5 class="modal-title" id="myModalLabel">Add New Unit</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{url('/units')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <div class="input-group">
                            <input type="text" name="aname" class="form-control" placeholder="Unit Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <div class="basic-form">
                            <textarea name="adescription" class="form-control" rows="4"></textarea>
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
                  <h5 class="modal-title" id="myModalLabel">Edit Unit</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{url('/units')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <div class="input-group">
                            <input type="text" id="ename" name="ename" class="form-control" placeholder="Plan Name" required>
                            <input type="hidden" id="eid" name="eid" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <div class="basic-form">
                            <textarea id="edescription" name="edescription" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button name="editunit" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="myModalLabel">Delete Unit</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{url('/units')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <div class="input-group">
                            <input type="text" id="dname" name="dplanname" class="form-control" placeholder="Plan Name" readonly>
                            <input type="hidden" id="did" name="did" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button name="deleteunit" type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
            </div>
            </div>
        </div>
@endsection
@push('scripts')
    <script src="{{ asset('library/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
    <script>
        $(function() {
                $('#editModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var ename = button.data('ename');
                    var edescription = button.data('edescription');
                    var eid = button.data('eid');
                    var modal = $(this);
                    modal.find('#ename').val(ename);
                    modal.find('#edescription').val(edescription);
                    modal.find('#eid').val(eid);
                });
            })
    </script>
    <script>
        $(function() {
                $('#deleteModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var dname = button.data('dname');
                    var did = button.data('did');
                    var modal = $(this);
                    modal.find('#dname').val(dname);
                    modal.find('#did').val(did);
                });
            })
    </script>
@endpush