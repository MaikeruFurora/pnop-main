<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img class="img-fluid mb-1 p-0" src="{{ asset('image/logo/'.$sprofile->school_logo ?? 'deped.png') }}"
            alt="PNHS LOGO" width="30px">
            <a style="top: 50px" href="{{ route('admin.dashboard') }}">
                PNOP
            </a>
            <p style="font-size: 11px;margin-top:-15px">
                {{ empty($activeAY)?'No active academic year':'S/Y '.$activeAY->from.'-'.$activeAY->to }}
            </p>

        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">
                <img class="img-fluid m-0 p-0" src="{{ asset('image/logo/'.$sprofile->school_logo ?? 'deped.png') }}"
                alt="PNHS LOGO" width="30px">
            </a>
            <p style="font-size: 11px;margin-top:-15px">
                @if (empty($activeAY))
                No active
                @else
                {{ Str::substr($activeAY->from, 2) }}-{{ Str::substr($activeAY->to, 2) }}
                @endif
            </p>
        </div>
        @if (Auth::guard('web')->check())
        @include('layout/partial/adminSide')
        @elseif(Auth::guard('teacher')->check())
        @include('layout/partial/teacherSide')
        @elseif(Auth::guard('student')->check())
        @include('layout/partial/studentSide')
        @endif
    </aside>
</div>
{{-- #2B58A5 --}}