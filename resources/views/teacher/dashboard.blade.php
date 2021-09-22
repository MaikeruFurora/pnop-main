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
                    <a href="#" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="far fa-user"></i>
                        Setup Profile</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('moreJs')
@if ( Auth::user()->chairman()->where('school_year_id', session('sessionAY')->id)->exists())
<script src="{{ asset('teacher/chairman/dashMonitor.js') }}"></script>
@endif
@endsection