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
                    <a href="add-company" class="btn btn-primary add-button ml-3">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        
    
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Company Name</th>
                                        <th>Category</th>
                                        <th>Logo</th>
                                        <th>Updated At</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $index = 1;
                                    @endphp
                                    @foreach($companies as $company)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->category }}</td>
                                        <td>
                                            <img class="rounded service-img mr-1" src="{{ Storage::url($company->logo) }}" alt="Logo" style="width:200px;height:200px;">
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($company->updated_at)->setTimezone('Asia/Kolkata')->format('F d, Y, h:i A') }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('companies.edit', ['company' => $company->id]) }}" class="btn btn-sm bg-success-light mr-2">
                                                <i class="far fa-edit mr-1"></i> Edit
                                            </a>
                                            <a href="#" onclick="deleteCompany({{ $company->id }})" class="btn btn-sm bg-danger-light mr-2">
                                                <i class="far fa-trash-alt mr-1"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function deleteCompany(companyId) {
    if (confirm('Are you sure you want to delete this company?')) {
        $.ajax({
            url: '{{ url("api/delete-company") }}', // API endpoint
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: companyId
            },
            success: function(data) {
                if (data.status === 'success') {
                    alert('Company deleted successfully.');
                    location.reload();
                } else {
                    alert('Failed to delete the company.');
                }
            },
            error: function(xhr) {
                alert('An error occurred while deleting the company.');
            }
        });
    }
}
</script>

@endsection