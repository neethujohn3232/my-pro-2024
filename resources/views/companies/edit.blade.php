@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Edit Company</h1>
        <form id="updateCompanyForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Tells Laravel to treat this as a PUT request -->
            <div class="mb-3">
                <label for="name" class="form-label">Company Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $company->name }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $company->email }}">
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control">
                @if ($company->logo)
                    <img src="{{ asset('storage/logos/' . $company->logo) }}" alt="Logo" width="100" class="mt-2">
                @endif
            </div>
            <div class="mb-3">
                <label for="website" class="form-label">Website</label>
                <input type="url" name="website" id="website" class="form-control" value="{{ $company->website }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>

   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true, // Add a close button to the notification
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right", // Position of the toast
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300", // Duration for showing the toast
            "hideDuration": "1000", // Duration for hiding the toast
            "timeOut": "5000", // Duration the toast stays visible
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn", // Show animation
            "hideMethod": "fadeOut" // Hide animation
        };
        
    </script>
    
    <script>
        $('#updateCompanyForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Create a FormData object
            var formData = new FormData(this);

            $.ajax({
                url: '{{ route('companies.update', $company->id) }}',
                type: 'POST', // Use POST method with the PUT method spoofed
                data: formData, // Send the form data (including files)
                processData: false, // Don't process the data
                contentType: false, // Don't set content type (FormData does this automatically)
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success); // Show success message

                        setTimeout(function() {
                            window.location.href = '{{ route('companies.index') }}'; // Redirect to company index page
                        }, 1000); // Adjust delay time as needed
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
