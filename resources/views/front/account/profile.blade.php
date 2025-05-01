@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">

                    {{-- for sidebar --}}
                    @include('front.account.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.message')
                    {{-- for message --}}
                    <div class="card border-0 shadow mb-4">
                        <form action="" method="post" id="userform" name="userform">
                            @csrf
                            @method('put')
                            <div class="card-body  p-4">
                                <h3 class="fs-4 mb-1">My Profile</h3>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Name*</label>
                                    <input type="text" name="name"id="name" placeholder="Enter Name"
                                        class="form-control" value="{{ $user->name }}">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Email*</label>
                                    <input type="text" name="email" id="name" placeholder="Enter Email"
                                        class="form-control" value="{{ $user->email }}">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Designation*</label>
                                    <input type="text" name="designation" id="designation" placeholder="Designation"
                                        class="form-control" value="{{ $user->designation }}">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Mobile*</label>
                                    <input type="text" name="mobile" id="mobile" placeholder="Mobile"
                                        class="form-control" value="{{ $user->mobile }}">
                                </div>
                            </div>

                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>


                    <div class="card border-0 shadow mb-4">
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">Change Password</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Old Password*</label>
                                <input type="password" placeholder="Old Password" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">New Password*</label>
                                <input type="password" placeholder="New Password" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" placeholder="Confirm Password" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer  p-4">
                            <button type="button" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        $('#userform').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('account.updateProfile') }}',
                type: 'POST',
                dataType: 'json',
                data: $('#userform').serialize() + '&_method=PUT', // simulate PUT request
                success: function(response) {
                    if (response.status === false) {
                        let errors = response.errors;

                        // Name error
                        if (errors.name) {
                            $("#name").addClass('is-invalid').siblings('p.invalid-feedback').text(errors
                                .name);
                        } else {
                            $("#name").removeClass('is-invalid').siblings('p.invalid-feedback').text(
                            '');
                        }

                        // Email error
                        if (errors.email) {
                            $("#email").addClass('is-invalid').siblings('p.invalid-feedback').text(
                                errors.email);
                        } else {
                            $("#email").removeClass('is-invalid').siblings('p.invalid-feedback').text(
                                '');
                        }

                        // Other errors (if fields exist)
                        if (errors.password) {
                            $("#password").addClass('is-invalid').siblings('p.invalid-feedback').text(
                                errors.password);
                        } else {
                            $("#password").removeClass('is-invalid').siblings('p.invalid-feedback')
                                .text('');
                        }

                        if (errors.confirm_password) {
                            $("#confirm_password").addClass('is-invalid').siblings('p.invalid-feedback')
                                .text(errors.confirm_password);
                        } else {
                            $("#confirm_password").removeClass('is-invalid').siblings(
                                'p.invalid-feedback').text('');
                        }
                    } else {
                        alert('Profile updated successfully!');
                        location.reload();
                    }
                },
                error: function(xhr) {
                    alert('Something went wrong. Please try again.');
                }
            });
        });
    </script>
@endsection
