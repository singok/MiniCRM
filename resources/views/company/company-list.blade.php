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
                                    <form method="POST" id="companyForm" enctype="multipart/form-data" autocomplete="off">
                                        @csrf
                                        <input type="hidden" class="form-control hiddenid" name="comid">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" placeholder="Name" name="name">
                                        </div>
                                        @error('name')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="input-group mb-2">
                                            <input type="email" class="form-control" placeholder="Email" name="email">

                                        </div>
                                        @error('email')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" placeholder="Website" name="website">

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
                                                <button type="submit" class="btn btn-primary btn-block saveButton"><i
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Website</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data goes here -->
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
@endsection

@section('script')
    <script>
        $(document).ready(function() {

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

            // load tables
            function loadTable() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('companies.loadtable') }}',
                    type: 'POST',
                    success: function(data) {
                        $('tbody').html(data);
                    }
                });
            }
            loadTable();

            // insert form values
            $('#companyForm').submit(function(e) {
                e.preventDefault();
                var url = '{{ route('companies.add') }}';
                $(this).validate({
                    rules: {
                        name: "required",
                        email: {
                            email: true,
                            required: true
                        },
                        website: "required",
                        province: "required",
                        district: "required",
                        vdcormunicipality: "required",
                        logo: "required",
                    },
                    messages: {
                        name: {
                            required: "Please enter company name",
                        },
                        email: {
                            required: "Please enter company email address",
                            email: "Please enter valid email address",
                        },
                        website: {
                            required: "Please enter website url",
                        },
                        province: {
                            required: "Please select province name",
                        },
                        district: {
                            required: "Please select district name",
                        },
                        vdcormunicipality: {
                            required: "Please select municipality name",
                        },
                        logo: {
                            required: "Please choose image logo",
                        }
                    }
                });
                if ($('#companyForm').valid()) {
                    var formdata = new FormData($('#companyForm')[0]);
                    var url = '{{ route('companies.add') }}';
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            $('#companyForm').find('input').val('');
                            alert(data.success);
                            loadTable();
                        }
                    });
                }
            });

            // edit company detail
            $(document).on('click', '.editCompany', function() {
                var companyId = $(this).data('id');
                var url = '{{ route('companies.edit') }}'
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: 'POST',
                    data: {
                        id: companyId
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('input[type="hidden"]').val(data.companyid);
                        $('input[name="name"]').val(data.companyname);
                        $('input[name="email"]').val(data.companyemail);
                        $('input[name="website"]').val(data.companywebsite);
                        $('.selectedProvince').val(data.companyprovince);
                        $('.selectDistrict').val(data.companydistrict);
                        $('input[name="logo"]').val(data.companylogo);
                    }
                });
            });



            // delete company detail
            $(document).on('click', '.removeCompany', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var companyid = $(this).data('id');
                        var url = '{{ route('companies.delete') }}'
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            type: 'POST',
                            data: {
                                id: companyid
                            },
                            dataType: 'json',
                            success: function(data) {
                                loadTable();
                            }
                        });
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            });
        });
    </script>
@endsection
