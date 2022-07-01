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

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-4">

                        <div class="card card-primary" id="addEditForm">
                            <div class="card-header">
                                <h3 class="card-title" id="formTitle">Add Employee</h3>
                            </div>
                            <form id='employeeForm' action="POST">
                                <input type="hidden" class="form-control hiddenid" name="employeeid">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="firstname">First name</label>
                                            <input type="text" class="form-control" name="firstname" id="firstname"
                                                placeholder="Enter first name">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="lastname">Last name</label>
                                            <input type="text" class="form-control" name="lastname" id="lastname"
                                                placeholder="Enter last name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                                            placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <label>Company</label>
                                        <select class="form-control selectCompany" name="company">
                                            <option value="" selected>Select company...</option>
                                            @foreach ($dataInfo as $info)
                                                <option value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone"
                                            placeholder="Enter phone number">
                                    </div>
                                </div>

                                <div class="card-footer">
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
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Employees List</h3>
                            </div>

                            <div class="card-body">
                                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6"></div>
                                        <div class="col-sm-12 col-md-6"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="employeeTable"
                                                class="table table-bordered table-hover dataTable dtr-inline"
                                                aria-describedby="example2_info">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting sorting_asc" tabindex="0"
                                                            aria-controls="example2" rowspan="1" colspan="1"
                                                            aria-sort="ascending"
                                                            aria-label="Rendering engine: activate to sort column descending">
                                                            SI No.</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Browser: activate to sort column ascending">Employee
                                                            Name
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Platform(s): activate to sort column ascending">
                                                            Company</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Engine version: activate to sort column ascending">
                                                            Email</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                                            rowspan="1" colspan="1"
                                                            aria-label="CSS grade: activate to sort column ascending">Phone
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                                            rowspan="1" colspan="1"
                                                            aria-label="CSS grade: activate to sort column ascending">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th rowspan="1" colspan="1">SI No.</th>
                                                        <th rowspan="1" colspan="1">Employee Name</th>
                                                        <th rowspan="1" colspan="1">Company</th>
                                                        <th rowspan="1" colspan="1">Email</th>
                                                        <th rowspan="1" colspan="1">Phone</th>
                                                        <th rowspan="1" colspan="1">Action</th>
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

            </div>
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

            // load employees
            var table = $('#employeeTable').DataTable({
                processing: true,
                serverSide: true,
                scrollY: 400,
                order: [
                    [0, 'ASC']
                ],
                ajax: '{{ route('employees.load') }}',
                columns: [{
                        data: 'count'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'company'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'action'
                    },
                ]
            });

            // reset button
            $('.resetButton').click(function() {
                $('.saveButton').html('<i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Save');
                $('input[name="employeeid"]').val('');
                $('#addEditForm').removeClass('card-warning');
                $('#addEditForm').addClass('card-primary');
                $('#formTitle').html('Add Employee');
                $('.saveButton').removeClass('btn-warning');
                $('.saveButton').addClass('btn-primary');
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
                            table.ajax.reload();
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
                                table.ajax.reload();
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

                        $('.saveButton').html('<i class="fa-solid fa-pen-to-square"></i>&nbsp;Update');
                        $('.saveButton').removeClass('btn-primary');
                        $('.saveButton').addClass('btn-warning');
                        $('#addEditForm').removeClass('card-primary');
                        $('#addEditForm').addClass('card-warning');
                        $('#formTitle').html('Edit Employee');
                    }
                });
            });


        });
    </script>
@endsection
