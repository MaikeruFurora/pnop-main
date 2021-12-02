@extends('../layout/app')
@section('moreCss')
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
<style>
    .failGrade {
        color: red;
    }

    .noborder {
        width: 95%;
        border: none;
        border-color: transparent;
        background: transparent;
        outline: none;
    }
</style>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <h2 class="section-title">Grading</h2>
       <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                   <h4> Grading Sheet</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-stripped table-bordered">
                            <tr class="">
                                <th class="  bg-dark text-white">SUBJECT</th>
                                <th colspan="5" class=" bg-dark text-white"><h6 class="show_subject"></h6></th>
                            </tr>
                            <tr>
                                <th width="50px" class=" bg-info text-white">STUDENT</th>
                                <th width="25px"colspan="4" class="text-center bg-info text-white">QUARTER</th>
                                <th rowspan="2" width="25px" class="text-center bg-success text-white">Final Rating</th>
                            </tr>
                            <tr>
                                <th class=" bg-info text-white">Fullname</th>
                                <th width="10px" class="text-center bg-info text-white">1st</th>
                                <th width="10px" class="text-center bg-info text-white">2nd</th>
                                <th width="10px" class="text-center bg-info text-white">3rd</th>
                                <th width="10px" class="text-center bg-info text-white">4th</th>
                            </tr>
                            <tbody id="loadstudent">
                                <tr class="text-center">
                                    <td colspan="6">No data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h4>Filter data</h4>
                </div>
                <div class="card-body">
                    <div class="form-group"> @csrf
                        <label >Grade Level</label>
                        <select class="form-control" name="grade_level">
                          <option >Choose Grade Level</option>
                          <option value="7">Grade 7</option>
                          <option value="8">Grade 8</option>
                          <option value="9">Grade 9</option>
                          <option value="10">Grade 10</option>
                        </select>
                    </div>
                    <div class="form-group" id="show_section">
                        
                    </div>
                    <div class="form-group" id="show_subject">
                       
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
<script src="{{ asset('js/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/datatable/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('administrator/management/grading.js') }}"></script>
@endsection