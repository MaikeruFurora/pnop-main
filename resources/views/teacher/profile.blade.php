@extends('../layout/app')
@section('content')
<section class="section">
    <div class="section-body">
        <h2 class="section-title">My Profile</h2>
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-info">
                    <div class="card-header">
                        <h4>Information</h4>
                    </div>
                    <form action="{{ route('teacher.profile.update') }}" method="POST">@csrf
                        <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Employee ID</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    value="{{ auth()->user()->roll_no }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">First name</label>
                                <input type="text" readonly class="form-control" id="exampleInputEmail1"
                                    value="{{ auth()->user()->teacher_firstname }}" name="teacher_firstname">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Middle name</label>
                                <input type="text" readonly class="form-control" id="exampleInputEmail1"
                                    value="{{ auth()->user()->teacher_middlename }}" name="teacher_middlename">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Last name</label>
                                <input type="text" readonly class="form-control" id="exampleInputEmail1"
                                    value="{{ auth()->user()->teacher_lastname }}" name="teacher_lastname">
                            </div>
                            {{-- <button type="submit" class="btn btn-primary" >Update Profile</button> --}}
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h4>Account</h4>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('teacher.profile.account') }}" method="POST">@csrf
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->username }}" name="username">
                                @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password">
                                @error('confirm_password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-block" >Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
@section('moreJs')
{{-- <script src="{{ asset('student/profile.js') }}"></script> --}}
@endsection