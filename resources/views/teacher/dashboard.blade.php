@extends('../layout/app')
@section('content')
<section class="section">
    <div class="section-body">
        <h2 class="section-title">Dashboard </h2>
        @if ( Auth::user()->chairman()->where('school_year_id', session('sessionAY')->id)->exists())
        <div class="row dashMonitor"></div>
        @endif
        <div class="hero text-white hero-bg-image"
            style="background-image: url('assets/img/unsplash/eberhard-grossgasteiger-1207565-unsplash.jpg');">
            <div class="hero-inner">
                <h2>Welcome, {{ Auth::user()->fullname }}!</h2>
                <p class="lead">You almost arrived, complete the information about your account.</p>
                <div class="mt-4">
                    <a href="{{ route('teacher.profile') }}" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="far fa-user"></i>
                        Setup Profile</a>
                </div>
            </div>
        </div>
        {{-- announcement --}}
        <h2 class="section-title">Annoucement </h2>
        <div class="row">
            @foreach ($post as $item)
                @foreach ($item->visible_by as $value)
                   @if ($value==1)
                   <div class="col-lg-12">
                    <div class="card card-warning">
                        <div class="card-header">
                           <h4> {{$item->headline}}</h4>
                        </div>
                        <div class="card-body">
                             <p><i class="fa fa-clock"></i> {{ $item->created_at->diffForHumans() }}</p>
                            @php echo html_entity_decode($item->content_body) @endphp
                        </div>
                    </div>
                   </div>
                   @endif
                   @if ($value==2)
                   <div class="col-lg-12">
                    <div class="card card-warning">
                        <div class="card-header">
                           <h4> {{$item->headline}}</h4>
                        </div>
                        <div class="card-body">
                             <p><i class="fa fa-clock"></i> {{ $item->created_at->diffForHumans() }}</p>
                            @php echo html_entity_decode($item->content_body) @endphp
                        </div>
                    </div>
                   </div>
                   @endif
                   @if (Auth::user()->chairman()->where('school_year_id', $activeAY->id)->exists())
                  @if ($value==3)
                  <div class="col-lg-12">
                   <div class="card card-warning">
                       <div class="card-header">
                          <h4> {{$item->headline}}</h4>
                       </div>
                       <div class="card-body">
                            <p><i class="fa fa-clock"></i> {{ $item->created_at->diffForHumans() }}</p>
                           @php echo html_entity_decode($item->content_body) @endphp
                       </div>
                   </div>
                  </div>
                  @endif
                  @endif
                @endforeach
            @endforeach
        </div>
    </div>
</section>
@endsection
@section('moreJs')
@if ( Auth::user()->chairman()->where('school_year_id', session('sessionAY')->id)->exists())
<script src="{{ asset('teacher/chairman/dashMonitor.js') }}"></script>
@endif
@endsection