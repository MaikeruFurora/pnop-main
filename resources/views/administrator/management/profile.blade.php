@extends('../layout/app')
@section('content')
{{-- <div class="section-header">
    <h1>sas</h1>
</div> --}}
<style>
    .checkQuarter{
        padding: 40px;
        background-color: rgb(0, 0, 0);
        width: 17px;
        height: 17px;
    }
    input:checked ~ .checkQuarter{
        background-color: rgb(255, 0, 0)
    }
</style>
<div class="modal fade" id="endModalOnlineENrollment" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="fillGradeInPreviousLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <p class="mt-3 showText"></p>
                <button type="button" class="btn btn-warning btn-sm pl-3 pr-3 btnYes">Yes</button>&nbsp;&nbsp;
                <button type="button" class="btn btn-secondary btn-sm btnClose">Close</button>
            </div>
        </div>
    </div>
</div>
<section class="section">
    <div class="section-body">
        <h2 class="section-title">School Profile</h2>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card card-primary">
                    <div class="card-body m-3">
                        <form enctype="multipart/form-data" id="schooProfileForm">@csrf
                            <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <label for="inputSchoolName">School Name</label>
                                        <input type="text" class="form-control" name="school_name"
                                            value="{{ $data->school_name ?? '' }}" id="inputSchoolName" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputSchoolAddress">School Address</label>
                                        <input type="text" class="form-control" name="school_address"
                                            value="{{ $data->school_address ?? '' }}" id="inputSchoolAddress" required>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="inputSchoolIdNo">School Division</label>
                                            <input type="text" class="form-control" name="school_division"
                                                value="{{ $data->school_division ?? '' }}" id="inputSchoolIdNo"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="inputSchoolIdNo">School Region</label>
                                            <input type="text" class="form-control" name="school_region"
                                                value="{{ $data->school_region ?? '' }}" id="inputSchoolIdNo" required>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label for="inputSchoolIdNo">School ID No.</label>
                                            <input type="number" class="form-control" name="school_id_no"
                                                value="{{ $data->school_id_no ?? '' }}" id="inputSchoolIdNo" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"><small>Place your logo here</small></label>
                                            <div id="image-preview" class="image-preview">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="school_logo" id="image-upload" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 p-0">
                                    <label class="col-form-label "><small>Current Logo</small></label>
                                    <img class="img-thumbnail" width="500%" src="{{ !empty($data->school_logo)? asset("image/logo/".$data->school_logo) :'' }}" alt="">
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary" id="btnSaveSP">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
            {{--  --}}
            <div class="col-lg-12">
                <div class="row">
                    @if (isset($data))
                    <div class="col-lg-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                Enrollment Status
                            </div>
                            <div class="card-body">
                                <form id="enrollStatusForm">@csrf
                                  
                                    After the enrollment deadline has passed, online enrollment is disabled so that other users cannot access it.
                                    
                                      
                                            <select name="statusEnrollment" id="selectEnrollmentStatus"
                                                class="form-control mt-2" required>
                                                <option {{ empty($data->school_enrollment_url)?'selected':'' }}
                                                    value="">
                                                </option>
                                                <option {{  ($data->school_enrollment_url==true)?'selected':'' }}
                                                    value="yes">
                                                    Ongoing
                                                </option>
                                                <option {{ ($data->school_enrollment_url==false)?'selected':'' }}
                                                    value="no">
                                                    Disabled
                                                </option>
                                            </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                BACK-UP DATABASE
                            </div>
                            <div class="card-body">
                                A backup is a copy of data from your database that can be used to reconstruct that data. Backups can be divided into physical backups
                                <a href="{{ route('admin.backup.run') }}" class="btn btn-block btn-warning mt-3">BACK-UP DATABASE</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-primary">
                            <div class="card-header">
                               <h4> Grade Input Status</h4>
                                <div class="card-header-action">
                                  
                                    @if ($data->grade_status)
                                    <span class="badge badge-warning badgeText">
                                       Disabled
                                    </span>      
                                    @else
                                    <span class="badge badge-success badgeText">
                                        Enabled
                                    </span>
                                    @endif
                                  </div>
                            </div>
                            <div class="card-body">
                                <div class="form-row mb-0">
                                    <div class="form-group col-lg-9 col-md-9 col-sm-12">
                                        To protect the data from new changes, disable the teacher's grading sheet.
                                    </div>
                                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                        <label class="custom-switch my-3 mx-0">
                                            <input type="checkbox" name="grade_status" class="custom-switch-input switchMe" {{ $data->grade_status?'checked':'' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="d-block">Quartery Grade status (checked mean disabled)</label>
                                    <div class="showMyBoxes"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                 <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            BACK-UP HISTORY
                        </div>
                        <div class="card-body">
                         <table class="table">
                             <thead>
                                 <tr>
                                     <td>#</td>
                                     <td>File name</td>
                                     <td>Action</td>
                                 </tr>
                             </thead>
                             <tbody>
                                 @php
                                     $key=1;
                                 @endphp
                                @forelse ($fileRetrive as $item)
                                    <tr>
                                        <td>{{ $key++ }}</td>
                                        <td>{{ $item }}</td>
                                        <td>
                                            <a href="{{ url('admin/my/backup/donwload/'.$item) }}" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
                                            <button type="submit" class="btn btn-warning btn-sm" onclick="event.preventDefault(); document.getElementById('remove-form').submit();"><i class="fa fa-times"></i> Remove</button>
                                           <form id="remove-form" action="{{ url('admin/my/backup/remove/'.$item) }}" method="POST" >@csrf</form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr>
                                @endforelse
                             </tbody>
                         </table>
                        </div>
                    </div>
                 </div>
                </div> --}}
            </div>

        </div>
    </div>
</section>
@endsection
@section('moreJs')
<script src="{{ asset('js/uploadPreview/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('administrator/management/profile.js') }}"></script>
@endsection