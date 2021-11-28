@extends('../layout/app')
@section('moreCss')
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
@endsection
@section('content')
<section class="section">
    <input type="hidden" name="current_curriculum" value="BEC">
    <div class="section-body">
        <h2 class="section-title">Assign Subject</h2>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="row sectionListAvailable "></div>
                <div class="card card-info">
                    <div class="card-body">
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Subject Name</th>
                                    <th>Subject Teacher</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableAssign">
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-info">
                    <div class="card-body">
                            <form id="assignForm">@csrf
                                <input type="hidden" name="id">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Subject</label>
                                      <select name="subject_id" class="custom-select">
                                        <option value=""></option>
                                        @foreach ($subjects as $item)
                                        <option value="{{ $item->id }}">[ {{ $item->subject_code }} ] -
                                            {{ $item->descriptive_title }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInputPassword1">Subject Teacher</label>
                                      <select name="teacher_id" class="select2 custom-select">
                                        <option value=""></option>
                                        @foreach ($teachers as $item)
                                        <option value="{{ $item->id }}">{{ $item->teacher_name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <button class="btn btn-primary pl-4 pr-4 btn-lg assignBtn" type="submit">Save</button>
                                    <button class="btn btn-warning pl-4 pr-4 btn-lg cancelNow" type="submit">Cancel</button>
                            
                                <input type="hidden" name="section_id" value="{{  Auth::user()->section->id }}">
                                <input type="hidden" name="grade_level" value="{{  Auth::user()->section->grade_level }}">
                            </form>
                    </div>
                </div>
            </div>

        </div><!-- row -->
    </div><!-- section-body -->
</section>
@endsection

@section('moreJs')
<script src="{{ asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('teacher/assign.js') }}"></script>
@endsection