@extends('../layout/app')
@section('moreCss')
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
@endsection
@section('content')
@include('administrator/management/partial/deleteModal')
@include('administrator/management/partial/confirmation')
<section class="section">
    <div class="section-body">
        <h2 class="section-title">Academic Year</h2>
            <div class="card card-primary">
                <div class="card-body">
                    <form id="schoolYearForm">@csrf
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="mt-1 col-lg-5 col-md-5 col-sm-12">
                                <input type="text" class="form-control" required pattern="^[0-9]{4}$" maxlength="4"
                                    name="from" placeholder="Year from (eg. 2019)">
                            </div>
                            <div class="mt-1 col-lg-5 col-md-5 col-sm-12">
                                <input type="text" readonly class="form-control" required pattern="^[0-9]{4}$"
                                    maxlength="4" name="to" placeholder="Year to (eg. 2020)">
                            </div>
                            <div class="mt-1 col-lg-2 col-md-2 col-sm-12">
                                <button type="submit" class="btn my-1 btn-block btn-info" id="btnSaveAY">Save</button>
                            </div>
                        </div>
                    </form>
                    {{-- <div class="table-responsive mt-1"> --}}
                    <table class="table table-bordered text-center mt-3" id="school_year_Table">
                        <thead>
                            <tr>
                                <th class="text-center" width="65%">Academic Year</th>
                                <th class="text-center" width="5%">Active</th>
                                <th class="text-center" width="30%">Action</th>
                            </tr>
                        </thead>
                    </table>
                    {{-- </div> --}}
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
<script src="{{ asset('js/select2/select2.full.min.js') }}"></script>
<script>
    const yearList = {{ json_encode($year) }}
</script>
<script src="{{ asset('administrator/management/school-year.js') }}"></script>
@endsection