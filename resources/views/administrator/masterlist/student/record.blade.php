@extends('../layout/app')
@section('content')
<section class="section">
    @php
    function computedGrade($first,$second,$third,$fourth, $need){
    switch ($need) {
    case 'final':
    if (!empty($first) && !empty($second) && !empty($third) && !empty($fourth)) {
    $final = intval($first) + intval($second) + intval($third) + intval($fourth);
    return round($final / 4);
    }
    break;
    case 'remark':
    if (!empty($first) && !empty($second) && !empty($third) && !empty($fourth)) {
    $final = intval($first) + intval($second) + intval($third) + intval($fourth);
    return round($final / 4)<75?'Failed':'Passed'; } default: return false; break; } } @endphp <div
        class="section-body">
        <h2 class="section-title">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ url()->previous() }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back</a>
                <button type="button" class="btn btn-default">{{ $student->student_lastname.', '.$student->student_firstname.' '.$student->student_middlename }}</button>
            </div>
        </h2>
        <div class="col-12">
            <div class="row">
                <div class="col-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <td>

                                            Section:
                                            <span class="badge badge-info">{{  $recordSeven[0]->section_name ?? 'N/A' }}</span>
                                        </td>
                                        <td colspan="6" class="text-center">
                                            Class Adviser:
                                            <span class="badge badge-info pt-1 pb-1">
                                                {{  $recordSeven[0]->fullname ?? 'N/A'}}
                                            </span> &nbsp;&nbsp;
                                            Grade Level: <b>7</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">LEARNING AREAS</td>
                                        <td colspan="4" class="text-center">Quarterly Rating</td>
                                        <td rowspan="2" class="text-center">Final Rating</td>
                                        <td rowspan="2">Remarks</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recordSeven as $item)
                                    <tr>
                                        <th>{{ $item->descriptive_title }}</th>
                                        <th>{{ $item->first }}</th>
                                        <th>{{ $item->second }}</th>
                                        <th>{{ $item->third }}</th>
                                        <th>{{ $item->fourth }}</th>
                                        <th>
                                            {{ computedGrade($item->first,$item->second,$item->third,$item->fourth,'final') }}
                                        </th>
                                        <th>
                                            {{ computedGrade($item->first,$item->second,$item->third,$item->fourth,'remark') }}
                                        </th>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th></th>
                                        <th colspan="4" class="text-center">General Average</th>
                                        <th></th>
                                        <th colspan="1"></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- eight --}}
                <div class="col-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <td>

                                            Section:
                                            <span class="badge badge-info">{{  $recordEight[0]->section_name ?? 'N/A' }}</span>
                                        </td>
                                        <td colspan="6" class="text-center">
                                            Class Adviser:
                                            <span class="badge badge-info pt-1 pb-1">
                                                {{  $recordEight[0]->fullname ?? 'N/A'}}
                                            </span> &nbsp;&nbsp;
                                            Grade Level: <b>8</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">LEARNING AREAS</td>
                                        <td colspan="4" class="text-center">Quarterly Rating</td>
                                        <td rowspan="2" class="text-center">Final Rating</td>
                                        <td rowspan="2">Remarks</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($recordEight))
                                    @foreach ($recordEight as $item)
                                    <tr>
                                        <th>{{ $item->descriptive_title }}</th>
                                        <th>{{ $item->first }}</th>
                                        <th>{{ $item->second }}</th>
                                        <th>{{ $item->third }}</th>
                                        <th>{{ $item->fourth }}</th>
                                        <th>
                                            {{ computedGrade($item->first,$item->second,$item->third,$item->fourth,'final') }}
                                        </th>
                                        <th>
                                            {{ computedGrade($item->first,$item->second,$item->third,$item->fourth,'remark') }}
                                        </th>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th></th>
                                        <th colspan="4" class="text-center">General Average</th>
                                        <th></th>
                                        <th colspan="1"></th>
                                    </tr>
                                    @else

                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- nine --}}
                <div class="col-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <td>

                                            Section:
                                            <span class="badge badge-info">{{  $recordNine[0]->section_name ?? 'N/A' }}</span>
                                        </td>
                                        <td colspan="6" class="text-center">
                                            Class Adviser:
                                            <span class="badge badge-info pt-1 pb-1">
                                                {{  $recordNine[0]->fullname ?? 'N/A'}}
                                            </span> &nbsp;&nbsp;
                                            Grade Level: <b>9</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">LEARNING AREAS</td>
                                        <td colspan="4" class="text-center">Quarterly Rating</td>
                                        <td rowspan="2" class="text-center">Final Rating</td>
                                        <td rowspan="2">Remarks</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($recordNine))
                                    @foreach ($recordNine as $item)
                                    <tr>
                                        <th>{{ $item->descriptive_title }}</th>
                                        <th>{{ $item->first }}</th>
                                        <th>{{ $item->second }}</th>
                                        <th>{{ $item->third }}</th>
                                        <th>{{ $item->fourth }}</th>
                                        <th>
                                            {{ computedGrade($item->first,$item->second,$item->third,$item->fourth,'final') }}
                                        </th>
                                        <th>
                                            {{ computedGrade($item->first,$item->second,$item->third,$item->fourth,'remark') }}
                                        </th>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th></th>
                                        <th colspan="4" class="text-center">General Average</th>
                                        <th></th>
                                        <th colspan="1"></th>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- ten --}}
                <div class="col-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <td>

                                            Section:
                                            <span class="badge badge-info">{{  $recordTen[0]->section_name ?? 'N/A' }}</span>
                                        </td>
                                        <td colspan="6" class="text-center">
                                            Class Adviser:
                                            <span class="badge badge-info pt-1 pb-1">
                                                {{  $recordTen[0]->fullname ?? 'N/A'}}
                                            </span> &nbsp;&nbsp;
                                            Grade Level: <b>10</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">LEARNING AREAS</td>
                                        <td colspan="4" class="text-center">Quarterly Rating</td>
                                        <td rowspan="2" class="text-center">Final Rating</td>
                                        <td rowspan="2">Remarks</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>

                                    </tr>
                                </thead>
                              
                                <tbody>
                                    @if (!empty($recordTen))
                                    @foreach ($recordTen as $item)
                                    <tr>
                                        <th>{{ $item->descriptive_title }}</th>
                                        <th>{{ $item->first }}</th>
                                        <th>{{ $item->second }}</th>
                                        <th>{{ $item->third }}</th>
                                        <th>{{ $item->fourth }}</th>
                                        <th>
                                            {{ computedGrade($item->first,$item->second,$item->third,$item->fourth,'final') }}
                                        </th>
                                        <th>
                                            {{ computedGrade($item->first,$item->second,$item->third,$item->fourth,'remark') }}
                                        </th>
                                    </tr>
                                   
                                    @endforeach
                                    <tr>
                                        <th></th>
                                        <th colspan="4" class="text-center">General Average</th>
                                        <th></th>
                                        <th colspan="1"></th>
                                    </tr>
                                    @endif
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