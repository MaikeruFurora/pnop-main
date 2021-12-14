<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>PRINT REPORT</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body style="background: white" onload="window.print()">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center mt-3">
              <div class="row">
                <div class="col-md-3">
                    <img src="{{ asset('image/logo/'.$sprofile->school_logo) }}" class="mt-3" width="70%">
                </div>
                <div class="col-md-6">
                    <small>Republic of the Philippine</small><br>
                    <small style="font-size: 14px">Region V - Bicol</small><br>
                    <small style="font-size: 14px">Division  of Camarines Sur</small><br>
                    <small style="font-size: 15px"><b>{{ $sprofile->school_name }}</b></small><br>
                    <small style="font-size: 14px;text-transform:capitalize">{{ ucwords(strtolower($sprofile->school_address)) }}</small>
                </div>
                <div class="col-md-3">
                    <img src="{{ asset('image/logo/deped.png') }}" class="mt-4" width="90%">
                </div>
              </div>
            </div>
        </div><br>
        <h6 class="text-center">Class List</h6>
        <hr>
        @if (count($dataNow)>0)
        <p class="mb-0">Section: <b>{{ $section }}</b></p>
        <p class="mb-0">Adviser: <b>{{ $dataNow[0]->tfullname }}</b></p>
        {{-- <p class="mb-0"><b>Total Student:</b> {{ $total->mtotal+$total->ftotal }}</p>
        <p class="mb-0"><b>Male:</b> {{ $total->mtotal }}</p>
        <p class="mb-0"><b>Female:</b> {{ $total->ftotal }}</p> --}}
        <table class="table table-bordered table-sm mt-2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>LRN</th>
                    <th>Fullname</th>
                    <th>Sex</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataNow as $key =>$student)
                <tr>
                    <td>{{  ++$key }}</td>
                    <td>{{  $student->roll_no }}</td>
                    <td>{{  Str::upper($student->fullname) }}</td>
                    <td>{{  $student->gender }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            
        @endif
        
    </div>
</body>

</html>