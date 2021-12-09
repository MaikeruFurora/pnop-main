@extends('../layout/app')
@section('moreCss')
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
@include('teacher/partial/confirmation')
<section class="section">
    <div class="section-body">
        <h2 class="section-title">My Class [ {{ Auth::user()->section->section_name }} ]</h2>
        
        <div class="card card-info">
            <div class="card-body pb-1">

                <div class="table-responsive">
                    {{-- table-responsive--}}
                    <table class="table table-striped" id="myClassTable" style="font-size: 11px">
                        <thead>
                            <tr>
                                <th>LRN</th>
                                <th>Student name</th>
                                <th>Gender</th>
                                <th>Contact No.</th>
                                <th>Status</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
<script src="{{ asset('teacher/classMonitor.js') }}"></script>
@endsection