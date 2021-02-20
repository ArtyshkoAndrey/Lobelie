<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">
  <title>@yield('title', 'ЕБАл')</title>
  <!-- Styles -->
  <link rel="preload" href="{{ mix('css/app.css') }}" as="style" />
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body id="{{ str_replace('.', '-', Route::currentRouteName()) . '-page' }}">
<div id="app">

  <div data-mdb-color="danger" role="alert" class="alert alert-danger fade show info-alert">
    <div class="d-flex flex-column justify-content-center w-100">
      <strong>Ошибка!</strong>
      <span>Нет аккаунта с такими данными</span>
    </div>
    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
      <span aria-hidden="true">×</span>
    </button>
  </div>

  @include('user.layouts.header')
  <main>
    @yield('content')
  </main>
  @include('user.layouts.footer')
</div>
</body>

<!-- Scripts -->
<script src="{{mix('js/app.js')}}"></script>

<script>
  let heartButtons = $('.heart-button')
  let cartButtons = $('.cart-button')

  function passwordTypeToggle(button, elID) {
    let el = $('#' + elID)
    let icon = $(button).children('i')
    if (el.attr('type') === 'password') {
      el.attr('type', 'text')
      icon.removeClass('fa-eye')
      icon.addClass('fa-eye-slash')
    } else if (el.attr('type') === 'text') {
      el.attr('type', 'password')
      icon.addClass('fa-eye')
      icon.removeClass('fa-eye-slash')
    }
  }

  for (let button of heartButtons) {
    button = $(button)
    button.on('mouseenter', function() {
      button.children('i').removeClass('fal')
      button.children('i').addClass('fa')
    })

    button.on('mouseleave', function() {
      button.children('i').addClass('fal')
      button.children('i').removeClass('fa')
    })
  }

  for (let button of cartButtons) {
    button = $(button)
    button.on('mouseenter', function() {
      button.children('.shopping-bag').toggleClass('active')
      button.children('.shopping-bag-alt').toggleClass('active')
    })

    button.on('mouseleave', function() {
      button.children('.shopping-bag').toggleClass('active')
      button.children('.shopping-bag-alt').toggleClass('active')
    })
  }

  let isDesktopSafari = (navigator.userAgent.toLowerCase().indexOf('safari') !== -1 && navigator.userAgent.toLowerCase().indexOf('chrome') === -1) && typeof window.ontouchstart === 'undefined';
  let isMobileSafari = (navigator.userAgent.toLowerCase().indexOf('safari') !== -1 && navigator.userAgent.toLowerCase().indexOf('chrome') === -1) && typeof window.ontouchstart !== 'undefined';
  if (isDesktopSafari && isMobileSafari) {
    console.log(1);
    $('#cart .container-fluid:first-child').css('padding-bottom', '60px')
    $('#cart .price-result-wrapper').css('bottom', '80px')
  }
</script>
@yield('js')
</html>
