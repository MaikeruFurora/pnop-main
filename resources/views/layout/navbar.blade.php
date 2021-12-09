<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars" style=""></i></a>
            </li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        @if (Auth::guard('web')->check())
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                {{-- <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1"> --}}
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::guard('web')->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                {{-- <div class="dropdown-title">Logged in 5 min ago</div> --}}
                <a href="#" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="{{ route('auth.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        @elseif (Auth::guard('teacher')->check())
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                {{-- <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1"> --}}
                <span class="badge badge-info pb-1 pt-1" style="font-size: 12px">Teacher</span>
                &nbsp;&nbsp;
                <div class="d-sm-none d-lg-inline-block">
                    Hi, {{ Auth::guard('teacher')->user()->fullname }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                {{-- <div class="dropdown-title">Logged in 5 min ago</div> --}}
                <a href="#" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="{{ route('auth.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        @elseif (Auth::guard('student')->check())
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle  nav-link-lg
            @if (count(auth()->user()->unreadNotifications)!=0)
            beep
            @endif
            "><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Notifications
                <div class="float-right">
                  <a href="{{ route('student.markAsRead') }}">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                @forelse (auth()->user()->notifications()->take(4)->get() as $item)
                <a href="@if ( $item->data['request']['type']=="grade") {{ route('student.grade') }} @else {{ route('student.dashboard') }} @endif" class="dropdown-item @if ($item->read_at == null) dropdown-item-unread @endif ">
                    <div class="dropdown-item-icon bg-primary text-white">
                      <i class="fas {{ $item->data['request']['icon'] }}"></i>
                    </div>
                    <div class="dropdown-item-desc">
                     {{ $item->data['request']['bodyMessage'] }}
                      <div class="time text-primary">{{ $item->created_at->diffForHumans() }}</div>
                    </div>
                  </a>
                @empty
                <p class="text-center">No notifications</p>
                @endforelse
              </div>
              <div class="dropdown-footer text-center">
                <a href="{{ route('student.notificationStudent') }}">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <span class="badge badge-info pb-1 pt-1" style="font-size: 12px">Student</span>
                &nbsp;&nbsp;
                @if (!empty(auth()->user()->profile_image))    
                <img alt="image" src="{{ asset('image/profile/'.auth()->user()->profile_image) }}" class="rounded-circle mr-1">
                @else
                <img alt="image" src="{{ asset('image/avatar-1.png') }}" class="rounded-circle mr-1">
                @endif
                <div class="d-sm-none d-lg-inline-block">
                    Hi, {{ Auth::guard('student')->user()->fullname }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                {{-- <div class="dropdown-title">Logged in 5 min ago</div> --}}
                <a href="#" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="{{ route('auth.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

        @endif
    </ul>
</nav>