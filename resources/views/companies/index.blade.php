@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">List of All Companies</h3>
                    </div>
                    <div class="col-auto text-right">
                        <a class="btn btn-white filter-btn" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i>
                        </a>
                        <a href="{{ route('companies.create') }}" class="btn btn-primary add-button ml-3">
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
                                <table class="table table-hover table-center mb-0 datatable" id="companies-table">
                                    <thead>
                                        <tr>
                                            <th>Sl.No</th>
                                            <th>Company Name</th>
                                            <th>Email</th>
                                            <th>Logo</th>
                                            <th>Website</th>
                                            {{-- <th>Updated At</th> --}}
                                            <th class="text-right">Action</th>
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
                    Are you sure you want to delete this company?
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
            if ($.fn.DataTable.isDataTable('#companies-table')) {
                $('#companies-table').DataTable().destroy();
            }
            $('#companies-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('companies.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'logo',
                        name: 'logo',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            let imageUrl = data ? "{{ asset('') }}" + data :
                                "{{ asset('assets/logo.jpg') }}";
                            return `<img class="rounded service-img mr-1" src="${imageUrl}" alt="Logo" style="width:100px;height:100px;border-radius:50px;" onerror="this.onerror=null; this.src='{{ asset('assets/logo.jpg') }}';">`;
                        }
                    },
                    {
                        data: 'website',
                        name: 'website'
                    },
                    // {
                    //     data: 'updated_at',
                    //     name: 'updated_at',
                    //     render: function(data) {
                    //         return new Date(data).toLocaleString('en-IN', {
                    //             timeZone: 'Asia/Kolkata',
                    //             dateStyle: 'long',
                    //             timeStyle: 'short'
                    //         });
                    //     }
                    // },
                  
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-right',
                        render: function(data) {
                            return `
           <a href="#"  onclick="window.location.href='companies/${data}/edit'" class="btn btn-sm bg-success-light mr-2">
                <i class="far fa-edit mr-1"></i> Edit
            </a>
            <a href="#" onclick="deleteCompany(${data})" class="btn btn-sm bg-danger-light mr-2">
                <i class="far fa-trash-alt mr-1"></i> Delete
            </a>
        `;
                        }
                    }
                ]
            });
        });
    </script>
    <script>
        
        let selectedCompanyId;

        function deleteCompany(companyId) {
           
            selectedCompanyId = companyId;
            
            $('#deleteConfirmModal').modal('show');
        }

        
        $('#confirmDeleteBtn').click(function() {
            $.ajax({
                url: `/companies/${selectedCompanyId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                       
                        $('#deleteConfirmModal').modal('hide');
                        toastr.success(response.success);


                        setTimeout(function() {
                            location.reload();
                        }, 1000); 
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert("An error occurred. Please try again.");
                }
            });
        });
    </script>
@endsection
