@extends('../layout/app')
@section('moreCss')
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/fullcalendar/fullcalendar.min.css') }}">
@endsection
@section('content')
@include('administrator/appointment/partial/holidayForm')
@include('administrator/appointment/partial/viewAppointed')
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
                {{-- <div class="col-lg-2 col-md-2">
                    <button class="btn float-right btn-primary my-4" id="btnModalHoliday">
                        <i class="fas fa-plus-circle"></i>&nbsp;Add Holiday
                    </button>
                </div> --}}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="card">
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
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
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
</section>
@endsection
@section('moreJs')
<script src="{{ asset('js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar/fullcalendar.min.js') }}"></script>
{{-- <script src="{{ asset('administrator/appointment/appointment.js') }}"></script> --}}
<script>
    "use strict";

$("#myEvent").fullCalendar({
  height: 'auto',
  header: {
            right: "prev,next today",
            left: "title",
            // right: "month",
        },
        weekends: false,
  editable: true,
  events: [
    {
      title: 'Conference',
      start: '2018-01-9',
      end: '2018-01-11',
      backgroundColor: "#fff",
      borderColor: "#fff",
      textColor: '#000'
    },
    {
      title: "John's Birthday",
      start: '2018-01-14',
      backgroundColor: "#007bff",
      borderColor: "#007bff",
      textColor: '#fff'
    },
    {
      title: 'Reporting',
      start: '2018-01-10T11:30:00',
      backgroundColor: "#f56954",
      borderColor: "#f56954",
      textColor: '#fff'
    },
    {
      title: 'Starting New Project',
      start: '2018-01-11',
      backgroundColor: "#ffc107",
      borderColor: "#ffc107",
      textColor: '#fff'
    },
    {
      title: 'Social Distortion Concert',
      start: '2018-01-24',
      end: '2018-01-27',
      backgroundColor: "#000",
      borderColor: "#000",
      textColor: '#fff'
    },
    {
      title: 'Lunch',
      start: '2018-01-24T13:15:00',
      backgroundColor: "#fff",
      borderColor: "#fff",
      textColor: '#000',
    },
    {
      title: 'Company Trip',
      start: '2018-01-28',
      end: '2018-01-31',
      backgroundColor: "#fff",
      borderColor: "#fff",
      textColor: '#000',
    },
  ]

});
</script>
@endsection