<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Docku')</title>

  <!-- Fonts -->
  <link rel="preload" href="https://fonts.googleapis.com/css?family=Nunito" as="style" />
  <link rel="preload" href="{{ asset('css/boxicons.min.css') }}" as="style" />
  <link rel="preload" href="{{ asset('fonts/boxicons.eot') }}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{ asset('fonts/boxicons.svg') }}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{ asset('fonts/boxicons.ttf') }}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{ asset('fonts/boxicons.woff') }}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{ asset('fonts/boxicons.woff2') }}" as="font" crossorigin="anonymous" />

  <link rel="preload" href="{{ asset('fonts/Montserrat/Montserrat-Regular.ttf') }}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{ asset('fonts/Montserrat/Montserrat-Medium.ttf') }}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{ asset('fonts/Montserrat/Montserrat-Bold.ttf') }}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{ asset('fonts/Montserrat/Montserrat-SemiBold.ttf') }}" as="font" crossorigin="anonymous" />

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito"/>
  <link rel="stylesheet" href="{{ asset('css/boxicons.min.css') }}"/>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"/>

  <!-- Styles -->
  @if (config('app.env') == 'local')
    <link rel="preload" href="{{ asset('css/app.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @else
    <link rel="preload" href="{{ asset(mix('css/app.css'), true) }}" as="style" />
    <link rel="stylesheet" href="{{ asset(mix('css/app.css'), true) }}">
  @endif
</head>
<body id="{{ str_replace('.', '-', Route::currentRouteName()) . '-page' }}">
<div id="app">
  @if(isset($errors))
    @if($errors->any())
      @foreach ($errors->all() as $error)
        <div class="alert alert-danger fade show info-alert" data-mdb-color="danger" role="alert">
          <div class="d-flex flex-column justify-content-center w-100">
            <strong>Ошибка!</strong>
            <span>{{ $error }}</span>
          </div>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endforeach
    @endif
  @endif
  @if (session()->has('success'))
    @foreach (session('success') as $message)
        <div class="alert alert-success fade show info-alert" data-mdb-color="success" role="alert">
          <div class="d-flex flex-column justify-content-center w-100">
            <strong>Успешно!</strong>
            <span>{{ $message }}</span>
          </div>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
    @endforeach
  @endif

  @include('user.layouts.header', ['theme_menu' => $theme_menu ?? 'dark-menu'])
  <main>
    @yield('content')
  </main>
  @include('user.layouts.footer')
</div>
</body>

<!-- Scripts -->

@if (config('app.env') == 'local')
  <script src="{{asset('js/app.js')}}"></script>
@else
  <script src="{{asset(mix('js/app.js'), true)}}"></script>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.2/jquery-migrate.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


<script>
  function toggleSearch() {
    let search = document.getElementsByClassName('search')[0];
    let categoryMenu = document.getElementsByClassName('category-menu')[0];
    if (search.classList.contains('hide')) {
      search.classList.remove('hide');
      categoryMenu.classList.add('hide');
    } else {
      search.classList.add('hide');
      categoryMenu.classList.remove('hide');
    }
  }

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

  (() => {
    'use strict';

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach((form) => {
      form.addEventListener('submit', (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();

  window.onload = function() {
    (function($){
      $.fn.isActive = function(){
        console.log(this)
        let ch = false
        let obj = this
        if(!Array.isArray(this))
          obj = [obj]
        obj.forEach(el => {
          el.hasClass('show') ? ch = true : null
        })
        return ch
      }
    })(jQuery)

    let isDesktopSafari = (navigator.userAgent.toLowerCase().indexOf('safari') !== -1 && navigator.userAgent.toLowerCase().indexOf('chrome') === -1) && typeof window.ontouchstart === 'undefined';
    let isMobileSafari = (navigator.userAgent.toLowerCase().indexOf('safari') !== -1 && navigator.userAgent.toLowerCase().indexOf('chrome') === -1) && typeof window.ontouchstart !== 'undefined';

    if (!isDesktopSafari && !isMobileSafari) {
      $('#intro').css('background-attachment', 'fixed')
    }

    function checkOpenCart() {
      if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
        if ($('[aria-labelledby="cart-dropdown"]').isActive() ||
            $('.category-menu .dropdown-menu').isActive()) {
          $('body').css("overflow", "hidden");
          $('html').css('overflow', 'hidden');
          $('.category-menu .dropdown-menu').css('overflow', 'auto');
        } else {
          $('body').css("overflow", "auto");
          $('html').css('overflow', 'auto');
          $('.category-menu .dropdown-menu').css('overflow', 'hidden');
        }
      }
    }

    $('#main-menu').on('show.bs.dropdown', function () {
      setTimeout(() => { checkOpenCart() }, 100)
    })

    $('#main-menu').on('hidden.bs.dropdown', function () {
      setTimeout(() => { checkOpenCart() }, 100)
    })

    $('.category-menu').on('show.bs.dropdown', function () {
      setTimeout(() => { checkOpenCart() }, 100)
    })

    $('.category-menu').on('hidden.bs.dropdown', function () {
      setTimeout(() => { checkOpenCart() }, 100)
    })
  }
</script>
@yield('js')
</html>
