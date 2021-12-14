@extends('../layout/app')
@section('moreCss')
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset('css/fullcalendar/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/summernote-bs4.css') }}">
@endsection
@section('content')
@include('administrator/appointment/partial/holidayForm')
@include('administrator/appointment/partial/viewAppointed')
@include('administrator/appointment/partial/deleteModal')
<style>
    .full {
        color: red;
        border: 1px solid red;
        background: black;
    }
</style>
<section class="section">
    <div class="section-body">
        <div class="col-12">
            <div class="row justify-content-between">
                <div class="col-lg-5 col-md-8">
                    <h2 class="section-title">Appointment List</h2>

                </div>
                <div class="col-lg-2 col-md-2">
                    <button class="btn btn-icon icon-left btn-primary my-4 float-right" id="btnModalHoliday"><i class="fas fa-plus-circle"></i> Event &amp; Holiday</button>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="fc-overflow">
                                    <div id="myEvent"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="card card-primary mb-2">
                    <div class="card-header"><h4>Monitoring Legend Colors</h4>
                        <div class="card-header-action">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <span class="btn btn-sm btn-success">&nbsp;&nbsp;&nbsp;Not Full&nbsp;&nbsp;&nbsp;</span>
                                <span class="btn btn-sm btn-primary">Holiday or Event</span>
                                <span class="btn btn-sm" style="background: #ffa366;color:white">Full Client</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tableHoliday">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
@section('moreJs')
<script src="{{ asset('js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.checkboxes.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('js/summernote-bs4.js') }}"></script>
<script src="{{ asset('administrator/appointment/appointment.js') }}"></script>
@endsection