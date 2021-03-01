<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <title>Lobelie | Резултаты поиска</title>
</head>
<body>
  <section class="container-fluid not-found-page">
    <div class="row h-100">
      <div class="col-2 d-none d-md-block"></div>
      <div class="col-md-6 wrapper">
        <div>
          <h1 class="title">Страница<br>не найдена :(</h1>
          <span class="subtitle">Возможно, вы ошиблись в адресе<br>или страница была перемешена</span>
          <a href="{{ route('index') }}" class="preview">Вернуться на главную <i class="bx bx-sm bx-run"></i></a>
        </div>
        <div class="d-flex justify-content-center justify-content-md-start">
          <img src="{{ asset('images/logo.svg') }}" alt="error-image">
        </div>
      </div>
    </div>
  </section>
</body>
</html>
