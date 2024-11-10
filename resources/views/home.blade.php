@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-12">

                        <h3 class="page-title">Welcome Admin!</h3>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>

                </div>
            </div>
            <!-- /Page Header -->


        </div>
    </div>
    </div>
    <div class="container">
       
    </div>
@endsection
