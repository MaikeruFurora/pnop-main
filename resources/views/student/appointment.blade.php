@extends('../layout/app')
@section('content')
<section class="section">
    <div class="section-body">
        <h2 class="section-title">Appointment Form</h2>
        <div class="col-lg-4">
            <form action="{{ route('appoint.save') }}" method="POST">@csrf
                <div class="card shadow card-info">
                   
                    <div class="card-body pb-0">
                        <div class="form-group">
                            <label>Full name</label>
                            <input type="text" class="form-control" name="fullname" required readonly value="{{auth()->user()->fullname}}">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Contact no.</label>
                                <input type="text" class="form-control" placeholder="Contact no."
                                    name="contact_no" required onkeypress="return numberOnly(event)"
                                    maxlength="11" value="{{auth()->user()->student_contact}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Email" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" required value="{{auth()->user()->pernament_address}}">
                        </div>
                        <div class="form-group">
                            <label>Select Date</label>
                            <input class="form-control datepicker" name="set_date" required>
                        </div>
                        <div class="form-group">
                            <label>Purpose</label>
                            <textarea class="form-control" data-height="80" name="purpose"
                                required></textarea>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary btn-block">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('moreJs')
<script src="{{ asset('student/backsubject.js') }}"></script>
<script src="{{ asset('js/appoint.js') }}"></script>
@endsection