@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">List of All Employees</h3>
                    </div>
                    <div class="col-auto text-right">
                        <a class="btn btn-white filter-btn" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i>
                        </a>
                        <a href="{{ route('employees.create') }}" class="btn btn-primary add-button ml-3">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <meta name="csrf-token" content="{{ csrf_token() }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable" id="employees-table">
                                    <thead>
                                        <tr>
                                            <th>Sl no</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Company Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this employee?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#employees-table')) {
                $('#employees-table').DataTable().destroy();
            }
            $('#employees-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employees.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name' 
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                    <a href="{{ url('employees') }}/${data}/edit" class="btn btn-sm bg-success-light mr-2">
                        <i class="far fa-edit mr-1"></i> Edit
                    </a>
                    <a href="#" onclick="deleteEmployee(${data})" class="btn btn-sm bg-danger-light mr-2">
                        <i class="far fa-trash-alt mr-1"></i> Delete
                    </a>
                `;
                        }
                    }


                ]
            });
        });

        let selectedEmployeeId;

        function deleteEmployee(id) {
            selectedEmployeeId = id; 
            $('#deleteConfirmModal').modal('show'); 
        }

        
        $('#confirmDeleteBtn').click(function() {
            $.ajax({
                url: '/employees/' + selectedEmployeeId, 
                type: 'POST', 
                data: {
                    _method: 'DELETE', 
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                    $('#deleteConfirmModal').modal('hide'); 
                    toastr.success('Employee deleted successfully'); 

                    
                    $('#employees-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    $('#deleteConfirmModal').modal('hide'); 
                    toastr.error('Error deleting employee'); 
                }
            });

        });
    </script>
  
@endsection
