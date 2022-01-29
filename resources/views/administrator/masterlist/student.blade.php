@extends('../layout/app')
@section('moreCss')
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/responsive.bootstrap4.min.css') }}">
@endsection
@section('content')

<!-- Modal -->
@include('administrator/masterlist/partial/modal')
@include('administrator/masterlist/partial/deleteModal')
@include('administrator/masterlist/partial/resetModal')
<form id="importForm" method="POST">@csrf
    <div class="modal fade" id="importModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-1">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-secondary" type="button" id="button-addon1">Excel Format</button>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="inputGroupFile02" required>
                            <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                        </div>
                    </div>
                    <p>
                        Download excel file format <a target="_blank" href="{{ route('admin.download.template.student') }}">here</a>
                    </p>
                </div>
                <div class="modal-footer p-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnImportNow">Import</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- Modal end --}}

<section class="section">
    <div class="section-body">
        <div class="col-12">
            <div class="row justify-content-between">
                <div class="col-lg-5 col-md-8">
                    <h2 class="section-title">Student Masterlist</h2>
                </div>
                <div class="col-lg-2 col-md-2 my-4">
                    <div class="btn-group float-right" role="group" aria-label="Basic example">
                        <button class="btn float-right btn-warning" id="btnModalExport">
                            <i class="fas fa-file-export"></i>&nbsp;Import Excel
                        </button>
                    <button class="btn float-right btn-primary" id="btnStudentModal">
                        <i class="fas fa-plus-circle"></i>&nbsp;Student
                    </button>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-primary">

                <div class="card-body mt-2">
                    <div class="table-responsive">
                    {{-- dt-responsive nowrap --}}
                    <table class="table table-striped" id="studentTable">
                        <thead>
                            <tr>
                                <th>LRN</th>
                                <th>Fullname</th>
                                <th>Gender</th>
                                <th>Contact No.</th>
                                <th>Completer</th>
                                <th>Username</th>
                                {{-- <th>Password</th> --}}
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('moreJs')
<script src="{{ asset('js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/datatable/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('administrator/masterlist/student.js') }}"></script>
@endsection