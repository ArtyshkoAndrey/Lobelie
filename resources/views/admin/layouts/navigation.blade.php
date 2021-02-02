<!-- Navbar -->
<nav class="navbar">
  <!-- Navbar content (with toggle sidebar button) -->
  <div class="navbar-content">
    <button class="btn btn-action" type="button" onclick="halfmoon.toggleSidebar()">
      <i class="bx bx-menu"></i>
      <span class="sr-only">Toggle sidebar</span> <!-- sr-only = show only on screen readers -->
    </button>
  </div>
  <!-- Navbar brand -->
  <a href="{{ route('admin.index') }}" class="navbar-brand d-none d-md-block w-100">
    <img src="{{ asset('images/logo-admin.svg') }}" class="invisible visible-dm position-absolute img-fluid my-auto w-100" alt="logo">
    <img src="{{ asset('images/logo-admin-light.svg') }}" class="invisible visible-lm img-fluid w-100 my-auto" alt="logo">
  </a>
  <!-- Navbar text -->
  <span class="navbar-text text-monospace">{{ config('app.admin.version') }}</span> <!-- text-monospace = font-family shifted to monospace -->
  <!-- Navbar nav -->
  <ul class="navbar-nav d-none d-md-flex"> <!-- d-none = display: none, d-md-flex = display: flex on medium screens and up (width > 768px) -->
    <li class="nav-item {{ Route::currentRouteNamed('admin.index') ? 'active' : '' }}">
      <a href="{{ route('admin.index') }}" class="nav-link">Главная</a>
    </li>
    <li class="nav-item {{ Route::currentRouteNamed('admin.product.*') ? 'active' : '' }}">
      <a href="{{ route('admin.product.index') }}" class="nav-link">Товары</a>
    </li>
  </ul>

  <!-- Navbar content (with the dropdown menu) -->
  <div class="navbar-content ml-auto"> <!-- d-md-none = display: none on medium screens and up (width > 768px), ml-auto = margin-left: auto -->
    <div class="dropdown with-arrow">
      <!-- Toggling dark mode -->
      <button class="btn align-middle btn-dark border-0 shadow-none" type="button" onclick="halfmoon.toggleDarkMode()"><i class="bx bxs-moon"></i></button>
      <button class="btn align-middle bg-transparent border-0 shadow-none" data-toggle="dropdown" type="button" id="navbar-dropdown-toggle-btn-1">
        Аккаунт
        <i class="bx bxs-chevron-down" aria-hidden="true"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-right w-200" aria-labelledby="navbar-dropdown-toggle-btn-1"> <!-- w-200 = width: 20rem (200px) -->
        <p class="dropdown-item d-flex align-items-center m-0">
          <img src="{{ auth()->user()->avatar_image }}" alt="person" class="img-fluid rounded-circle h-25 mr-10">
          {{ auth()->user()->name }}
        </p>
        <div class="dropdown-divider"></div>
        <a href="#" onclick="event.preventDefault();$('#logout').submit()" class="dropdown-item text-danger"><i class="bx bxs-log-out-circle mx-10"></i> Выйти</a>
        <form action="{{ route('logout') }}" id="logout" method="POST" class="d-none">
          @csrf
        </form>
      </div>
    </div>
  </div>
</nav>

<!-- Sidebar overlay -->
<div class="sidebar-overlay" onclick="halfmoon.toggleSidebar()"></div>
<!-- Sidebar -->
<div class="sidebar">
  <div class="sidebar-menu">
    <!-- Sidebar links and titles -->
    <h5 class="sidebar-title">Магазин</h5>
    <div class="sidebar-divider"></div>

    <a href="{{ route('admin.order.index') }}" class="sidebar-link sidebar-link-with-icon {{ Route::currentRouteNamed('admin.order.*') ? 'active' : '' }}">
      <span class="sidebar-icon bg-transparent justify-content-start mr-0">
        <i class="bx bx-package" aria-hidden="true"></i>
      </span>
      Заказы
    </a>

    <a href="{{ route('admin.coupon.index') }}" class="sidebar-link sidebar-link-with-icon {{ Route::currentRouteNamed('admin.coupon.*') ? 'active' : '' }}">
      <span class="sidebar-icon bg-transparent justify-content-start mr-0">
        <i class="bx bxs-coupon" aria-hidden="true"></i>
      </span>
      Промокоды
    </a>

    <br />
    <h5 class="sidebar-title">Товары</h5>
    <div class="sidebar-divider"></div>

    <a href="{{ route('admin.product.index') }}" class="sidebar-link sidebar-link-with-icon {{ Route::currentRouteNamed('admin.product.*') ? 'active' : '' }}">
      <span class="sidebar-icon bg-transparent justify-content-start mr-0">
        <i class="bx bxs-t-shirt" aria-hidden="true"></i>
      </span>
      Товары
    </a>

    <a href="{{ route('admin.brand.index') }}" class="sidebar-link sidebar-link-with-icon {{ Route::currentRouteNamed('admin.brand.*') ? 'active' : '' }}">
      <span class="sidebar-icon bg-transparent justify-content-start mr-0">
        <i class="bx bx-purchase-tag-alt" aria-hidden="true"></i>
      </span>
      Бренды
    </a>

    <a href="{{ route('admin.skus.index') }}" class="sidebar-link sidebar-link-with-icon {{ Route::currentRouteNamed('admin.skus.*') ? 'active' : '' }}">
      <span class="sidebar-icon bg-transparent justify-content-start mr-0">
        <i class="bx bx-purchase-tag" aria-hidden="true"></i>
      </span>
      Размеры
    </a>

    <a href="{{ route('admin.category.index') }}" class="sidebar-link sidebar-link-with-icon {{ Route::currentRouteNamed('admin.category.*') ? 'active' : '' }}">
      <span class="sidebar-icon bg-transparent justify-content-start mr-0">
        <i class="bx bx-purchase-tag" aria-hidden="true"></i>
      </span>
      Категории
    </a>

    <br />
    <h5 class="sidebar-title">Настройки</h5>
    <div class="sidebar-divider"></div>

    <a href="{{ route('admin.settings.money.index') }}" class="sidebar-link sidebar-link-with-icon {{ Route::currentRouteNamed('admin.settings.money.*') ? 'active' : '' }}">
      <span class="sidebar-icon bg-transparent justify-content-start mr-0">
        <i class="bx bx-money" aria-hidden="true"></i>
      </span>
      Виды оплат
    </a>

    <a href="{{ route('admin.settings.pickup.index') }}" class="sidebar-link sidebar-link-with-icon {{ Route::currentRouteNamed('admin.settings.pickup.*') ? 'active' : '' }}">
      <span class="sidebar-icon bg-transparent justify-content-start mr-0">
        <i class="bx bx-store" aria-hidden="true"></i>
      </span>
      Самовывоз
    </a>


    <a href="{{ route('telescope') }}" target="_blank" class="sidebar-link sidebar-link-with-icon">
      <span class="sidebar-icon bg-transparent justify-content-start mr-0">
        <i class="bx bx-bug" aria-hidden="true"></i>
      </span>
      Telescope
    </a>

  </div>
</div>
