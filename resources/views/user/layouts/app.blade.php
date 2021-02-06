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

  @include('user.layouts.header')
  <main>
    @yield('content')
  </main>
{{--  @include('user.layouts.footer')--}}
</div>
</body>

<!-- Scripts -->
<script src="{{mix('js/app.js')}}"></script>

<script>

</script>
@yield('js')
</html>
