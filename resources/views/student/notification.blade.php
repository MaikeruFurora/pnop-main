@extends('../layout/app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="col-12">
            <div class="row justify-content-between">
                <div class="col-lg-5 col-md-8">
                    <h2 class="section-title">Notifications</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
           <div class="card">
               <div class="card-header">
                   <a href="{{ route('student.markAsRead') }}" class="btn btn-success">
                    Mark As Read
                   </a>&nbsp;&nbsp;
                   <a href="{{ route('student.deleteNotification') }}" class="btn btn-warning">
                    Delete all Notifications
                   </a>
               </div>
               <div class="card-body">
                       @forelse (auth()->user()->notifications()->get() as $item)
                         <div class="card mb-1 @if ($item->read_at == null) card-info @else card-success @endif">
                             <div class="card-body">
                                <i class="fas {{ $item->data['request']['icon'] }}"></i> &nbsp;
                                {{ $item->data['request']['bodyMessage'] }}
                                <span class="float-right">{{ $item->created_at->diffForHumans() }}</span>
                             </div>
                         </div>
                       @empty
                       @endforelse
                   {{-- </table> --}}
               </div>
           </div>
        </div>
    </div>
</section>
@endsection