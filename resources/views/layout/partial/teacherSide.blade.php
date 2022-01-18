<ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="{{ request()->is('teacher/my/dashboard')?'active':'' }}"><a class="nav-link"
            href="{{ route('teacher.dashboard') }}"><i class="fas fa-cube"></i><span>Dashboard</span></a>
    </li>
    <li class="{{ request()->is('teacher/my/profile')?'active':'' }}"><a class="nav-link"
            href="{{ route('teacher.profile') }}"><i class="fas fa-user"></i><span>My Profile</span></a>
    </li>
    @if (Auth::user()->section()->where('school_year_id', $activeAY->id)->exists())
    <li class="menu-header">Adviser Setting <span class="badge badge-info pt-1 pb-1 pl-2 pr-2" style="font-size: 10px">{{ Auth::user()->section->section_name }}</span></li>
    <li class="{{ request()->is('teacher/my/class/monitor')?'active':'' }}">
        <a class="nav-link" href="{{ route('teacher.class.monitor') }}">
            <i class="fas fa-puzzle-piece"></i><span>
                Class Monitor</span>
        </a>
    </li>
    <li class="{{ request()->is('teacher/my/class/assign')?'active':'' }}">
        <a class="nav-link" href="{{ route('teacher.class.assign') }}">
            <i class="fas fa-book-reader"></i>
            <span>Assign Subject</span>
        </a>
    </li>
    {{-- <li class="">
        <a class="nav-link" href="">
            <i class="fas fa-thumbtack"></i>
            <span>Student Reminder</span>
        </a>
    </li> --}}
    @endif
    <li class="menu-header">Data Entry</li>
    <li class="{{ request()->is('teacher/my/grading')?'active':'' }}"><a class="nav-link"
            href="{{ route('teacher.grading') }}"><i class="fas fa-users"></i><span>Grading</span></a>
    </li>
    @if (Auth::user()->chairman()->where('school_year_id', $activeAY->id)->exists())
    <li class="menu-header">Chairman Setting</li>
    <li class="{{ request()->is('teacher/my/section')?'active':'' }}">
        <a class="nav-link" href="{{ route('teacher.section') }}">
            <i class="fas fa-border-all"></i><span>Manage Section</span>
        </a>
    </li>
    <li class="{{ request()->is('teacher/my/enrollmentForm')?'active':'' }}">
        <a class="nav-link" href="{{ route('teacher.enrollmentForm') }}">
            <i class="fas fa-user-tie"></i><span>Enrollment Form</span>
        </a>
    </li>
    <li
        class="nav-item dropdown {{ request()->is('teacher/my/stem') || request()->is('teacher/my/bec') || request()->is('teacher/my/spa') || request()->is('teacher/my/spj')?'active':'' }}">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fas fa-users"></i><span>Enroll Student</span>
        </a>
        <ul class="dropdown-menu">
            <li class="{{ request()->is('teacher/my/stem')?'active':'' }}">
                <a class="nav-link" href="{{ route('teacher.stem') }}">
                    <i class="fas fa-atom"></i><span>STEM</span>
                </a>
            </li>
            <li class="{{ request()->is('teacher/my/bec')?'active':'' }}">
                <a class="nav-link" href="{{ route('teacher.bec') }}">
                    <i class="fas fa-users"></i><span>BEC</span>
                </a>
            </li>
            <li class="{{ request()->is('teacher/my/spa')?'active':'' }}">
                <a class="nav-link" href="{{ route('teacher.spa') }}">
                    <i class="fas fa-palette"></i><span>SP Art</span>
                </a>
            </li>
            <li class="{{ request()->is('teacher/my/spj')?'active':'' }}">
                <a class="nav-link" href="{{ route('teacher.spj') }}">
                    <i class="fas fa-file-signature"></i><span>SP Journalism</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="{{ request()->is('teacher/my/certificate')?'active':'' }}">
        <a class="nav-link" href="{{ route('teacher.certificate') }}">
            <i class="fas fa-certificate"></i><span>Certificate</span>
        </a>
    </li>
    @endif
    <li><a class="nav-link" href="{{ route('auth.logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                class="fas fa-sign-out-alt text-danger"></i><span class="text-danger">Logout</span></a>
        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</ul>