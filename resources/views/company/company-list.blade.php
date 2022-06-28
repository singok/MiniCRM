@extends('layouts.dashboard')
@section('title')
    Companies
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Companies</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Companies</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-4 connectedSortable">
                        <div class="login-box">
                            @if (Session::has('success'))
                                <div class="alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @elseif (Session::has('error'))
                                <div class="alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            <!-- /.login-logo -->
                            <div class="card card-outline card-success">
                                <div class="card-header text-center">
                                    <span class="h4"><b>Add/edit company</b></span>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('companies.add') }}" method="POST" id="companyForm"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" placeholder="Name" name="name">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fa-solid fa-industry"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @error('name')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="input-group mb-2">
                                            <input type="email" class="form-control" placeholder="Email" name="email">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                        </div>
                                        @error('email')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" placeholder="Website" name="website">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fa-solid fa-sitemap"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @error('website')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="input-group mb-2">
                                            <select class="form-select selectedProvince" aria-label="Default select example"
                                                name="province">
                                                <option value="" selected>Select Province...</option>
                                                @foreach ($dataInfo as $info)
                                                    <option value="{{ $info->id }}">{{ $info->provincename }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('province')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="input-group mb-2">
                                            <select class="form-select selectDistrict" aria-label="Default select example"
                                                name="district">
                                                <!-- district data goes here -->
                                            </select>
                                        </div>
                                        @error('district')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="input-group mb-2">
                                            <select class="form-select selectVdcormunicipality"
                                                aria-label="Default select example" name="vdcormunicipality">
                                                <!-- vdcormunicipality data goes here -->
                                            </select>
                                        </div>
                                        @error('vdcormunicipality')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="input-group mb-2">
                                            <input type="file" class="form-control" placeholder="file" name="logo">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fa-solid fa-file-arrow-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @error('logo')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-4">
                                                <button type="reset" class="btn btn-secondary btn-block resetButton"><i
                                                        class="fa-solid fa-rotate-left"></i>&nbsp;&nbsp;Reset</button>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-4"></div>
                                            <!-- /.col -->
                                            <div class="col-4">
                                                <button type="submit" class="btn btn-success btn-block saveButton"><i
                                                        class="fa-solid fa-floppy-disk""></i>&nbsp;&nbsp;Save</button>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </form>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </section>
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-8 connectedSortable border border-primary">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Website</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companyInfo as $comp)
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>{{ $comp->name }}</td>
                                        <td>{{ $comp->email }}</td>
                                        <td>{{ $comp->website }}</td>
                                        <td>{{ $comp->province->provincename }} {{ $comp->district->districtname }}
                                            {{ $comp->vdcormunicipalities->municipalityname }}</td>

                                        <td><img src="{{ asset('storage/companylogo/' . $comp->logo) }}" height="25px"
                                                width="25px" /></td>
                                        <td>
                                            <a href="#"><i class="fa-solid fa-pen fa-lg mr-1"
                                                    style="color:blue"></i></a>
                                            <a href="#" class="removeCompany"><i
                                                    class="fa-solid fa-delete-left fa-lg ml-1" style="color:red"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                    <!-- right col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>

    <!-- delete modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you want to remove company detail ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-secondary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // display delete confirmation box
            $('.removeCompany').on('click', function() {
                $('#deleteModal').modal('show');
            });
            $('.removeCompany').on('click', function() {
                $('#deleteModal').modal('show');
            });
            $('.removeCompany').on('click', function() {
                $('#deleteModal').modal('show');
            });

            // get loaded data
            function getOptions(infoData, url) {
                return $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    data: infoData,
                    type: 'post',
                });
            }

            // get province value
            $('.selectedProvince').change(function() {
                var provinceid = $(this).find('option:selected').val();
                var infoData = {
                    provinceid: provinceid
                };
                var url = '{{ route('companies.districts') }}';
                $.when(getOptions(infoData, url)).then(function(data) {
                    $('.selectDistrict').html(data);
                });
            });

            // get district value
            $('.selectDistrict').change(function() {
                var districtid = $(this).find('option:selected').val();
                var infoData = {
                    districtid: districtid
                };
                var url = '{{ route('companies.vdcormunicipality') }}';
                $.when(getOptions(infoData, url)).then(function(data) {
                    $('.selectVdcormunicipality').html(data);
                });
            });

            // insert form values
            // $(document).on('click', '.saveButton', function(e) {
            //     var url = '{{ route('companies.add') }}';
            //     $('#companyForm').validate({
            //         // initialize the plugin
            //         rules: {
            //             name: {
            //                 required: true
            //             },
            //             email: {
            //                 required: true
            //             },
            //             website: {
            //                 required: true
            //             },
            //             province: {
            //                 required: true
            //             },
            //             district: {
            //                 required: true
            //             },
            //             vdcormunicipality: {
            //                 required: true
            //             },
            //             logo: {
            //                 required: true
            //             }
            //         }
            //     });
            //     if ($('#companyForm').valid()) {
            //         $('#companyForm').ajaxSubmit({
            //             type: 'post',
            //             url: url,
            //             dataType: 'json',
            //             success: function(response) {
            //                 console.log(response);
            //             }
            //         });
            //     }
            // });
        });
    </script>
@endpush
