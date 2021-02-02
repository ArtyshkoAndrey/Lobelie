@auth
<li class="nav-item login dropdown d-none d-md-block">
  <a
    class="nav-link"
    href="#"
    id="user-dropdown"
    role="button"
    data-mdb-toggle="dropdown"
    aria-expanded="false"
  >
    Lorem ipsum.
  </a>
  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="user-dropdown">
    <div class="row m-0">
      <div class="col-12 m-0">
          <div class="row">
            <a href="{{ route('profile.index') }}" class="d-flex dropdown-item">
              <div class="col-2 d-flex align-items-center justify-content-center">
                <img class="rounded-circle"
                     src="{{ asset('images/user-o.png') }}"
                     style="width: 25px; height: 25px;" alt="logo"/>
              </div>
              <div class="col-auto mx-2">
                {{ auth()->user()->name }}
              </div>
            </a>
          </div>
{{--          @if(auth()->user()->is_admin)--}}
{{--          <div class="row">--}}
{{--            <a href="{{ route('admin.index') }}" class="d-flex dropdown-item">--}}
{{--              <div class="col-2 d-flex align-items-center justify-content-center">--}}
{{--                <i class="bx bx-sm bxs-dashboard"></i>--}}
{{--              </div>--}}
{{--              <div class="col-auto mx-2">--}}
{{--                Администитивная панель--}}
{{--              </div>--}}
{{--            </a>--}}
{{--          </div>--}}
{{--          @endif--}}
          <div class="row">
            <a href="#" class="d-flex dropdown-item" onclick="event.preventDefault();$('#logout').submit()">
              <div class="col-2 d-flex align-items-center justify-content-center">
                <i class="bx bx-sm bx-log-out"></i>
              </div>
              <div class="col-auto mx-2">
                Выйти
              </div>
            </a>
            <form action="{{ route('logout') }}" id="logout" method="POST" class="d-none">
              @csrf
            </form>
          </div>
      </div>
    </div>
  </div>
</li>

@else
  <li class="nav-item login d-none d-md-block">
    <a class="nav-link" href="{{ route('login') }}">
      Войти
    </a>
  </li>

@endauth
