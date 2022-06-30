@extends('layouts.dashboard')
@section('title')
    Employees
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Employees</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employees</li>
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
                            <div class="card card-outline card-primary">
                                <div class="card-header text-center">
                                    <span class="h4"><b>Add/edit employee</b></span>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="employeeForm">
                                        <input type="hidden" name="employeeid">
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" placeholder="First Name"
                                                        name="firstname">

                                                </div>
                                                @error('firstname')
                                                    <div class="text-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" placeholder="Last Name"
                                                        name="lastname">

                                                </div>
                                                @error('lastname')
                                                    <div class="text-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="input-group mb-2">
                                            <select class="form-select selectCompany" aria-label="Default select example"
                                                name="company">
                                                <option value="" selected>Select Company...</option>
                                                @foreach ($dataInfo as $info)
                                                    <option value="{{ $info->id }}">{{ $info->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('company')
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
                                            <input type="text" class="form-control" placeholder="Phone Number"
                                                name="phone">

                                        </div>
                                        @error('phone')
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
                                                        class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Save</button>
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
                    <section class="col-lg-8 connectedSortable border border-warning">
                        <table class="table" id="employeeTable">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Company</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
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

            // load employee data
            function loadEmployee() {

                var url = '{{ route('employees.load') }}'
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    url: url,
                    type: 'POST',
                    success: function(data) {
                        // $('tbody').html(data);
                        // var employeeData = data;
                        // $('#employeeTable').DataTable({
                        //     data: employeeData,
                        //     columns: [{
                        //             data: 'firstname'
                        //         },
                        //         {
                        //             data: 'companies.name'
                        //         },
                        //         {
                        //             data: 'email'
                        //         },
                        //         {
                        //             data: 'phone'
                        //         },
                        //         {
                        //             'data': 'id',
                        //             "render": function(data, type, row, meta) {
                        //                 return "<a href='#' data-id='" + data +
                        //                     "' class='editEmployee'><i class='fa-solid fa-pen fa-lg mr-1' style='color:blue'></i></a><a href='#' data-id='" +
                        //                     data +
                        //                     "' class='removeEmployee'><i class='fa-solid fa-delete-left fa-lg ml-1' style = 'color:red'></i></a>";
                        //             }
                        //         }
                        //     ]
                        // });
                    }
                });
            }

            loadEmployee();

            // dataTables
            var librarybookdetailtable = $('#employeeTable').DataTable({
                "sPaginationType": "full_numbers",
                "bSearchable": false,
                "lengthMenu": [
                    [5, 10, 15, 20, 25, -1],
                    [5, 10, 15, 20, 25, "All"]
                ],
                'iDisplayLength': 15,
                "sDom": 'ltipr',
                "bAutoWidth": false,
                "aaSorting": [
                    [0, 'desc']
                ],
                "bSort": false,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": baseurl + "/library/book/getbookdetail",
                "oLanguage": {
                    "sEmptyTable": "<p class='no_data_message'>No data available.</p>"
                },
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [1]
                }],
                "aoColumns": [{
                        "data": "sno"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "company"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "phone"
                    },
                    {
                        "data": "action"
                    },
                ],
            }).columnFilter({
                sPlaceHolder: "head:after",
                aoColumns: [null,
                    {
                        type: "text"
                    },
                    {
                        type: "text"
                    },
                    {
                        type: "text"
                    },
                    {
                        type: "text"
                    },
                    {
                        type: "text"
                    },
                ]
            });

            librarybookdetailtable.fnDraw(false);

            // reset button
            $('.resetButton').click(function() {
                $('.saveButton').html('<i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Save');
                $('input[name="employeeid"]').val('');
            });

            // insert employee data
            $('#employeeForm').submit(function(e) {
                e.preventDefault();

                $(this).validate({
                    rules: {
                        firstname: "required",
                        lastname: "required",
                        email: {
                            email: true,
                            required: true
                        },
                        phone: {
                            required: true,
                            number: true,
                            maxlength: 10
                        },
                        company: "required",
                    },
                    messages: {
                        firstname: {
                            required: "Please enter first name",
                        },
                        lastname: {
                            required: "Please enter last name",
                        },
                        email: {
                            required: "Please enter email address",
                            email: "Please enter valid email address",
                        },
                        company: {
                            required: "Please select company name",
                        },
                        phone: {
                            required: "Please provide phone number",
                            number: "Only digits are allowed",
                            maxlength: "Only 10 digits number allowed"
                        }
                    }
                });

                if ($(this).valid()) {
                    var dataform = new FormData($('#employeeForm')[0]);
                    var url = '{{ route('employees.store') }}';

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        type: 'POST',
                        data: dataform,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 2000
                            })
                            $('.resetButton').trigger('click');
                            loadEmployee();
                        }
                    });
                }

            });

            // remove employee
            $(document).on('click', '.removeEmployee', function(e) {
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

                        var employeeid = $(this).data('id');
                        var url = '{{ route('employee.remove') }}';

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            data: {
                                id: employeeid
                            },
                            type: 'POST',
                            success: function(data) {
                                loadEmployee();
                            }
                        });

                        Swal.fire(
                            'Deleted!',
                            'Employee detail has been deleted.',
                            'success'
                        )
                    }
                })



            });

            // edit employee
            $(document).on('click', '.editEmployee', function(e) {
                e.preventDefault();
                var empid = $(this).data('id');
                var url = '{{ route('employee.edit') }}';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    data: {
                        id: empid
                    },
                    dataType: 'json',
                    type: 'POST',
                    success: function(data) {
                        $('input[name="firstname"]').val(data.employeefname);
                        $('input[name="lastname"]').val(data.employeelname);
                        $('input[name="email"]').val(data.employeeemail);
                        $('input[name="phone"]').val(data.employeephone);
                        $('.selectCompany').val(data.employeecompany);
                        $('input[type="hidden"]').val(data.employeeid);

                        $('.saveButton').html(
                            '<i class="fa-solid fa-pen-to-square"></i>&nbsp;Update');
                    }
                });
            });


        });
    </script>
@endsection
