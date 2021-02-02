@extends('admin.layouts.app')

@section('title', 'Docku - Административная панель')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6">

        <div class="card p-0"> <!-- p-0 = padding: 0 -->
          <img src="{{ asset('images/admin-hello.png') }}" class="img-fluid rounded-top" alt="Приветствие"> <!-- rounded-top = rounded corners on the top -->
          <!-- Nested content container inside card -->
          <div class="content">
            <h2 class="content-title">
              Добро пожаловать
            </h2>
            <p class="text-muted">
              Ваш сайт перешёл на обновлённую администраативную панель.
            </p>
            <p class="text-muted">
              Это только начало!
            </p>
          </div>
        </div>

      </div>

      <div class="col-lg-4 col-md-6">

        <div class="card p-0"> <!-- p-0 = padding: 0 -->
          <img src="{{ asset('images/admin-hello-alert.png') }}" class="img-fluid rounded-top w-full" alt="Приветствие">
          <div class="content">
            <h2 class="content-title">
              Новые уведомления
            </h2>
            <p class="text-muted">Мы улучшели систему уведомлений. Теперь уведомления плавно выезжают, и незаметно исчезают</p>
            <br>
            <a class="btn" href="{{ route('admin.redirect') }}">Тык!</a>
          </div>
        </div>

      </div>
      <div class="col-lg-4 col-md-6">
        <div class="row">
          <div class="col-12">
            <div class="card p-0"> <!-- p-0 = padding: 0 -->

              <div class="content">
                <h2 class="content-title">
                  Модальные окна
                </h2>
                <a href="#modal-1" class="btn btn-" role="button">Попробовать</a>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card p-0 mt-0"> <!-- p-0 = padding: 0 -->

              <div class="content">
                <h2 class="content-title">
                  Горячиее клавиши
                </h2>
                <p><code class="code">Shift+S</code> - Открыть/Закрыть меню</p>
                <p><code class="code">Shift+D</code> - Сменить тему</p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- First comes the modal -->
  <div class="modal" id="modal-1" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <a href="#" class="close" role="button" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <h5 class="modal-title">Модальное окно</h5>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aliquam amet dignissimos, enim et ex fugit, illo inventore libero magnam nobis obcaecati quam quas quod reiciendis sed voluptatem! Aperiam autem consequuntur corporis labore maiores officiis provident quia similique velit vitae! Dolorem eos facere harum necessitatibus porro quaerat, recusandae sit suscipit.
        </p>
        <div class="text-right mt-20"> <!-- text-right = text-align: right, mt-20 = margin-top: 2rem (20px) -->
          <a href="#" class="btn mr-5" role="button">Закрыть</a>
          <a href="#" class="btn btn-primary" role="button">Я понял</a>
        </div>
      </div>
    </div>
  </div>
@endsection
