<footer>
  <div class="container-fluid">
    <div class="row mb-3 mb-sm-0">
      <div class="col-12 col-sm-7 col-md-9">
        <div class="row mb-2 mb-md-5">
          <div class="col-12 col-md-5 link-block mailing mb-3">
            <span class="title">Рассылка lobelie intime</span>
            <input class="subscribe-input" placeholder="Введите e-mail">
            <button class="subscribe-button">Подписаться</button>
          </div>
          <div class="col-12 col-md-7">
            <div class="row">
              <div class="col-12 col-sm-6 link-block mb-3 mb-sm-0">
                <span class="title">Покупателям</span>
                <a href="{{ route('profile.index') }}" class="link">Личный кабинет</a>
                <a href="{{ route('payment') }}" class="link">Доставка и оплата</a>
                <a href="{{ route('policy') }}" class="link">Политика конфидециальности</a>
              </div>
              <div class="col-12 col-sm-6 link-block mb-3 mb-sm-0">
                <span class="title">Каталог</span>
                @widget('footer-category')
              </div>
            </div>
          </div>
        </div>
        <div class="row d-none d-md-flex">
          <div class="col-12 col-sm-5 link-block">
            <a href="{{ route('policy') }}" class="link">Политика конфедециальности</a>
          </div>
          <div class="col-12 col-sm-7">
            <span class="copyright">Lobelie intime, 2021. Все права защищены</span>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-5 col-md-3">
        <div class="link-block mb-5">
          <span class="title">Способы оплаты</span>
          <img class="pay-methods" src="{{ asset('images/pay-methods.png') }}" alt="lobeliestore">
        </div>
        <div class="link-block">
          <span class="title">Контакты</span>
          <div class="phone-wrapper">
            <i class="las la-phone"></i>
            <a href="tel:+77074720332" class="link">+7(707)472-03-32</a>
          </div>
          <div class="email-wrapper">
            <i class="las la-envelope"></i>
            <a href="mailto:info@lobeliestore.com" class="link">info@lobeliestore.com</a>
          </div>
        </div>
      </div>
    </div>
    <div class="row d-flex d-md-none">
      <div class="col-12 col-sm-5 link-block">
        <a href="{{ route('policy') }}" class="link">Политика конфедециальности</a>
      </div>
      <div class="col-12 col-sm-7 d-flex justify-content-start justify-content-sm-end">
        <span class="copyright">Lobelie intime, 2021. Все права защищены</span>
      </div>
    </div>
  </div>
</footer>
