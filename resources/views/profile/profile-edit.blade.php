@extends('layouts.dashboard')

@section('title')
    profile
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profile</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
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
                    </div>
                    <div class="col-md-4">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Update Password</h3>
                            </div>
                            <form autocomplete="off" id="profileForm">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="oldPassword">Current Password</label>
                                        <input autocomplete="off" type="password" class="form-control current-pass" id="oldPassword"
                                            placeholder="Enter current password..." name="oldpassword">
                                        <label id="oldPasswordMessage"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="newPassword">New Password</label>
                                        <input type="password" class="form-control new-pass" id="newPassword"
                                            placeholder="Enter new password..." name="newpassword">
                                            <label id="newPasswordMessage" class="text-danger"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password</label>
                                        <input type="password" class="form-control confirm-pass" id="confirmPassword"
                                            placeholder="Re-enter your password" name="confirm">
                                        <label id="confirmPasswordMessage"></label>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-secondary updateButton">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {

            // disable fields initially
            $('.updateButton').attr('disabled', 'disabled');
            $('.new-pass').attr('disabled', 'disabled');
            $('.confirm-pass').attr('disabled', 'disabled');

            // check old password
            $('.current-pass').on('keyup', function () {
                var old = $(this).val();
                var url = '{{ route('profile-password.check') }}';
                var email = '{{ Auth::user()->email }}';
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    type : 'POST',
                    url : url,
                    data : {oldpassword:old, email:email},
                    success : function (data) {
                        if (data.status == "Y") {
                            $('#oldPasswordMessage').removeClass('text-danger');
                            $('#oldPasswordMessage').addClass('text-success');
                            $('#oldPasswordMessage').html(data.message);

                            // enable fields
                            $('.new-pass').removeAttr('disabled');
                        } else if (data.status == "N") {
                            $('#oldPasswordMessage').removeClass('text-success');
                            $('#oldPasswordMessage').addClass('text-danger');
                            $('#oldPasswordMessage').html(data.message);

                            // disable fields
                            $('.new-pass').attr('disabled', 'disabled');
                            $('.confirm-pass').attr('disabled', 'disabled');
                            $('.updateButton').attr('disabled', 'disabled');
                        }
                    }
                });
            });

            // new password field
            $('.new-pass').on('keyup', function () {
                $('#oldPasswordMessage').html("");
                var newPassword = $(this).val();
                var regularExpression = /^(?=.*\d)(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,}$/;
                var result = regularExpression.test(newPassword);
                if (result == true) {
                    $('#newPasswordMessage').html('');
                    $('.confirm-pass').removeAttr('disabled');
                } else {
                    $('#newPasswordMessage').html('Password must be atleast 6 character long including 1 Uppercase, symbol and number.');
                }
            });

            // confirm password field
            $('.confirm-pass').on('keyup', function () {
                $('#newPasswordMessage').html('');
                var confirmPassword = $(this).val();
                var newPassword = $('.new-pass').val();
                if (confirmPassword == newPassword) {
                    $('#confirmPasswordMessage').removeClass('text-danger');
                    $('#confirmPasswordMessage').addClass('text-success');
                    $('#confirmPasswordMessage').html("Confirmation password matched.");
                    $('.updateButton').removeAttr('disabled');
                } else {
                    $('.updateButton').attr('disabled', 'disabled');
                    $('#confirmPasswordMessage').removeClass('text-success');
                    $('#confirmPasswordMessage').addClass('text-danger');
                    $('#confirmPasswordMessage').html("Password doesn't match.");
                }
            });

            // update button
            $('.updateButton').on('click', function () {

                var email = '{{ Auth::user()->email }}';
                var password = $('.confirm-pass').val();
                var url = '{{ route("profile.update") }}';

                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    type : 'POST',
                    url : url,
                    data : {currentemail:email, newpassword:password},
                    dataType : 'json',
                    success : function (data) {
                        if (data.status == 'Y') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 3000
                            })
                            $('#profileForm')[0].reset();
                            $('#confirmPasswordMessage').html("");
                        } else if (data.status == 'N') {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 3000
                            })
                        }
                    }
                });
            });
        });
    </script>
@endsection
