<!DOCTYPE HTML>
<html lang="ru">
<head>
  <!-- Meta tags -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=3.0, minimum-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  @if (config('app.env') == 'local')
    <link rel="stylesheet" href="{{asset('css/admin/app.css')}}">
  @else
    <link rel="stylesheet" href="{{asset(mix('css/admin/app.css'), true)}}">
  @endif
  <link rel="stylesheet" href="{{ asset('css/boxicons.min.css') }}">
  @yield('css')
  <title>@yield('title')</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars dark-mode" data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" data-set-preferred-theme-onload="dark" data-set-preferred-mode-onload="true">

  <noscript>You need to enable JavaScript to run this app.</noscript>

  <div class="page-wrapper with-navbar with-sidebar with-navbar-fixed-bottom">
    <div class="sticky-alerts">
      <!-- Alert Success -->
      @if (session()->has('success'))
        @php($i = 1)
        @foreach (session('success') as $message)
          <div class="alert alert-success" role="alert" id="precompiled-alert-{{$i}}">
            <table>
              <tbody>
              <tr>
                <td>
                  <div class="w-50 h-50 d-flex align-items-center rounded-circle"> <!-- w-50 = width: 5rem (50px), h-50 = height: 5rem (50px), d-flex = display: flex, align-items-center = align-items: center, rounded-circle = border-radius: 50%, bg-white = background-color: white -->
                    <div class="m-auto text-white"> <!-- m-auto = margin: auto, text-primary = color: primary-color -->
                      <i class="bx bx-check bx-md" aria-hidden="true"></i>
                      <span class="sr-only">Успешно</span> <!-- sr-only = only for screen readers -->
                    </div>
                  </div>
                </td>
                <td class="pl-20">
                  <h4 class="alert-heading mb-5">Успешно</h4> <!-- mb-5 = margin-bottom: 0.5rem (5px) -->
                  <div>
                    {{ $message }}
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
          @php($i++)
        @endforeach
      @endif

      <!-- Alert Errors -->
      @if ($errors->any())
        @php($i = 1)
        @foreach ($errors->all() as $message)
          <div class="alert alert-danger" role="alert" id="precompiled-alert-error-{{$i}}">
            <table>
              <tbody>
              <tr>
                <td>
                  <div class="w-50 h-50 d-flex align-items-center rounded-circle"> <!-- w-50 = width: 5rem (50px), h-50 = height: 5rem (50px), d-flex = display: flex, align-items-center = align-items: center, rounded-circle = border-radius: 50%, bg-white = background-color: white -->
                    <div class="m-auto text-white"> <!-- m-auto = margin: auto, text-primary = color: primary-color -->
                      <i class="bx bx-exit bx-md" aria-hidden="true"></i>
                      <span class="sr-only">Ошибка</span> <!-- sr-only = only for screen readers -->
                    </div>
                  </div>
                </td>
                <td class="pl-20">
                  <h4 class="alert-heading mb-5">Ошибка</h4> <!-- mb-5 = margin-bottom: 0.5rem (5px) -->
                  <div>
                    {{ $message }}
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
          @php($i++)
        @endforeach
      @endif
    </div>

    @include('admin.layouts.navigation')
    <div id="app" class="content-wrapper">
      @yield('content')
    </div>
    @yield('modal')


    <!-- Navbar fixed bottom -->
    <nav class="navbar navbar-fixed-bottom">
      <div class="container">
        <div class="row w-full d-flex justify-content-end">
          <div class="col-auto mx-10">
            <p>При поддержке <a href="https://www.gethalfmoon.com" class="text-danger">Halfmoon</a></p>
          </div>
          <div class="col-auto mx-10">
            <p>Powered by <a href="{{ config('app.admin.link') }}" class="text-danger">{{ config('app.admin.name') }}</a></p>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <!-- Scripts -->
  @if (config('app.env') == 'local')
    <script src="{{asset('js/admin/app.js')}}"></script>
  @else
    <script src="{{asset(mix('js/admin/app.js'), true)}}"></script>
  @endif
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    window.onload = function() {
      halfmoon.onDOMContentLoaded();

      @if (session()->has('success'))
        @php($i = 1)
        @foreach (session('success') as $message)
          halfmoon.toastAlert('precompiled-alert-{{$i}}', 2500)
          @php($i++)
        @endforeach
      @endif

      @if ($errors->any())
        @php($i = 1)
        @foreach ($errors->all() as $error)
          halfmoon.toastAlert('precompiled-alert-error-{{$i}}', 2500)
        @php($i++)
        @endforeach
      @endif
    }
  </script>
  @yield('script')
</body>
</html>
