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
        <h2 class="section-title">System Log</h2>
        <div class="row">
            <div class="col-lg-12 col-ms-12 col-sm-12">
                <div class="card card-primary">
                   
                    <div class="card-body">
                      <form action="" id="dateForm">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-secondary"><b>Date from</b></span>
                            </div>
                            <input type="text" id="datepicker1" name="from" required class="form-control">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-secondary"><b>Date to</b></span>
                              </div>
                            <input type="text" id="datepicker2" name="to" required class="form-control">
                            <button type="submit" class="btn btn-primary">Search&nbsp;&nbsp;<em>(filter)</em></button>
                          </div>
                      </form>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered" id="logTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Log</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3" class="text-center">No data</td>
                                    </tr>
                                </tbody>
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
<script src="{{ asset('js/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/datatable/responsive.bootstrap4.min.js') }}"></script>
<script>
    $("#datepicker1").datepicker({
         dateFormat: "yy-mm-dd",
        //  minDate: +1, 
    })
    $("#datepicker2").datepicker({
        dateFormat: "yy-mm-dd",
        // minDate: +1,
    })

    setTimeout(() => {
        let logTable = $("#logTable").DataTable({
        pageLenth: 10,
        processing: true,
        language: {
            processing: `
                <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
              </div>`,
        },

        ajax: `activity/log/${null}/${null}`,
        columns: [
            { data: "id" },
            { data: "log" },
            { data: "date" },
        ],
    });

    $("#dateForm").submit(function(e){
        e.preventDefault();
        let from = $("input[name='from']").val();
        let to = $("input[name='to']").val();
        if (to!="") {
            logTable.ajax.url(`activity/log/${from}/${to}`).load()
        }
    })
    
    $("input[name='to']").on('blur',function(){
        let from = $("input[name='from']").val();
        let to = $(this).val();
        if (from>to) {
            getToast("warning", "Waring", "Wrong combination");
        }
    })
    }, 5000);

   
</script>
@endsection