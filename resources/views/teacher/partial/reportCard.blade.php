<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
    <title>Document</title>
    <style>
        /* style sheet for "letter" printing */
        @media print {  
            @page {
                 size: 130mm 297mm; /* landscape */
                /* you can also specify margins here: */
                margin: 10mm;
            /* margin-right: 45mm;  for compatibility with both A4 and Letter */
            }
        }
    </style>
</head>
<body onload="window.print()">
    <table style="width:100%;margin-top:20px;text-align:center">
        <tr>
            <td style="text-align:left"><small><em>DepEd SF 9</em></small></td>
            <td></td>
            <td style="text-align: right;font-size:14px"><small></small></td>
        </tr>
    </table>
    <table>
        {{-- <tr>
            <td>sas</td>
            <td>dasd</td>
            <td>dasdaddsdad</td>
        </tr> --}}
        <tr>
            <td colspan="3" style="text-align:left"><img src="{{ asset('image/logo/dep.png') }}" width="70%"></td>
            <td class="" style="text-align:center" width="50%">
                <img src="{{ asset('image/logo/deped.png') }}" width="30%"><br>
                <small>Republic of the Philippine</small><br>
                <small>Region V - Bicol</small><br>
                <small>Division  of Camarines Sur</small><br>
                <small style="font-size: 12px"><b>PILI NATIONAL HIGH SCHOOL</b></small><br>
                <small>Pawili, Camarines Sur</small>
            </td>
            <td colspan="3" style="text-align:right"><img src="{{ asset('image/logo/logo.png') }}" width="70%"></td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center"><small>ENHANCED BASIC EDUCATION CURRICULUM (K to 12)</small></td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center; font-size:10px"><small >REPORT CARD</small></td>
        </tr>
        
        {{-- <tr>
            <td colspan="7">&nbsp;</td>
        </tr> --}}
      
    </table>
    <table style="width: 100%;">
        <tr>
            <td width="30px"><small>Name:</small></td>
            <td colspan="3" style="text-align: left; border-bottom:1px solid black;font-size:12px"><small>{{ $data[0]->fullname }}</small></td>
            <td><small>Sex:</small></td>
            <td colspan="" style="border-bottom:1px solid black"><small>{{ $data[0]->gender }}</small></td>
        </tr>
        <tr>
            <td><small>Grade/Sec:</small></td>
            <td colspan="3" style="border-bottom:1px solid black"><small>Grade {{ $data[0]->grade_level }} &amp; {{ $data[0]->section_name }}</small></td>
            <td><small>S/Y:</small></td>
            <td style="border-bottom:1px solid black"><small>{{ $sy->from }} - {{ $sy->to }} </small></td>
        </tr>
        <tr>
            <td><small>LRN:</small></td>
            <td colspan="6" style="border-bottom:1px solid black"><small>{{ $data[0]->roll_no }}</small></td>
          
        </tr>
    </table>
    <table style="width: 100%;border: .1px solid black;border-collapse: collapse;margin-top:9px">
        <tr>
            <td rowspan="2" style="border: .1px solid">Learning Areas</td>
            <td width="70px" style="text-align: center ;border: .1px solid" colspan="4">Quarter</td>
            <td width="20px" style="border: .1px solid" rowspan="2">Final Rating</td>
            <td width="20px" rowspan="2">Remarks</td>
        </tr>
        <tr>
            <td style="border: .1px solid;text-align:center">1</td>
            <td style="border: .1px solid;text-align:center">2</td>
            <td style="border: .1px solid;text-align:center">3</td>
            <td style="border: .1px solid;text-align:center">4</td>
        </tr>
        @php
            $sum=0;
        @endphp
        @foreach ($data as $item)
        <tr>
            <td style="border: .1px solid;text-align:left">{{ $item->descriptive_title }}</td>
            <td style="border: .1px solid;text-align:center;padding:5px">{{ $item->first }}</td>
            <td style="border: .1px solid;text-align:center;padding:5px">{{ $item->second }}</td>
            <td style="border: .1px solid;text-align:center;padding:5px">{{ $item->third }}</td>
            <td style="border: .1px solid;text-align:center;padding:5px">{{ $item->fourth }}</td>
            <td style="border: .1px solid;text-align:center">{{ $item->avg }}</td>
            <td style="border: .1px solid;text-align:center">
                @if ($item->avg<75)
                    Failed
                @else
                    Passed
                @endif
            </td>
        </tr>
        @php
            $sum+=$item->avg;
        @endphp
        @endforeach
       
        <tr>
            <td colspan="5" style="border: .1px solid;text-align:right;padding-right:10px">General Average</td>
            <td colspan="1" style="border: .1px solid;text-align:center">{{ round($sum/count($data)) }}</td>
            <td colspan="1s" style="border: .1px solid;text-align:center">{{  round($sum/count($data))<75?'Failed':'Passed' }}</td>
        </tr>
    </table>
    <table style="width:100%;margin-top:20px">
        <tr>
            <td>Descriptors</td>
            <td>Grading Scale</td>
            <td>Remarks</td>
        </tr>
        <tr>
            <td>Very Satisfactory</td>
            <td>85-89</td>
            <td>Passed</td>
        </tr>
        <tr>
            <td>Satisfactory</td>
            <td>80-84</td>
            <td>Passed</td>
        </tr>
        <tr>
            <td>Fairly Satisfactory</td>
            <td>75-79</td>
            <td>Passed</td>
        </tr>
        <tr>
            <td>Did Not Meet Expectations</td>
            <td>Below 75</td>
            <td>Failed</td>
        </tr>
    </table>
    <table style="width:100%;margin-top:40px;text-align:center">
        <tr>
            <td style="border-bottom: 1px solid">Erma Escuro PhD.</td>
            <td></td>
            <td></td>
            <td style="border-bottom: 1px solid">{{ auth()->user()->fullname }}</td>
        </tr>
        <tr>
            <td>Principal</td>
            <td></td>
            <td></td>
            <td>Teacher</td>
        </tr>
    </table>
</body>
</html>