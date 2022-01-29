@extends('../layout/app')
@section('content')
<form id="updateProfile">@csrf
    <div class="modal fade" id="updateProfileModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="update_id">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="update_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" name="update_username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Enter your password</label>
                        <input type="password" name="update_password" class="form-control" required>
                    </div>
                    <small><b>Note</b>: Please enter your password for verification before you preoceed</small>
                </div>
                <div class="modal-footer p-2">
                    <button type="submit" class="btn btn-success btnUpdateProfile" >Save changes</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="changePasswordForm">@csrf
    <div class="modal fade" id="chagepasswordModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="chagepasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chagepasswordModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <input type="hidden" name="change_id">
                        <div class="form-group">
                            <label for="">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">New Password</label>
                            <input type="password" name="change_new_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="change_confirm_password" class="form-control" required>
                        </div>
                        
                    <div class="modal-footer p-1">
                        <button type="submit" class="btn btn-success btnChangePassword" >Change Password</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@include('administrator/management/partial/deleteModal')
<section class="section">
    <div class="section-body">
        <h2 class="section-title">Manage User</h2>
        <div class="row">
            <div class="col-8 col-lg-8 col-md-8">
                <div class="card card-primary">
                    <div class="card-body">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                       <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="userTable">
                                <tr>
                                    <td colspan="4" class="text-center">No available data</td>
                                </tr>
                            </tbody>
                        </table>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-4 col-lg-4 col-md-4">
                <div class="card card-primary">
                    <div class="card-body">
                        <form class="mt-3" id="userForm">@csrf
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Fullname</label>
                                <input type="text" name="name" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirmPassword" required class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary btnSaveUser">Submit</button>
                            <button type="button" class="btn btn-warning cancelUser">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('moreJs')
<script>
     let user_id = $("input[name='user_id']").val();
</script>
<script src="{{ asset('administrator/management/user.js') }}"></script>
@endsection