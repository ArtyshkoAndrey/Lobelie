<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-4 justify-content-between">
        <div class="d-flex flex-column">
          <span>Есть вопросы? Свяжитесь с нами :)</span>
          <a href="tel:+77475562383" class="number">+7 (747) 556-23-83</a>
        </div>
        <span>© dockuboardhouse.com 2020 – магазин сноубордов</span>
      </div>
      <div class="col-md-6 col-lg-3">
        <span class="title">Помощь по заказам</span>
        <a href="#!">Доставка и оплата</a>
        <a href="#!">Политика конфидециальности</a>
        <a href="#!">Свяжитесь с нами</a>
      </div>
      <div class="col-md-6 col-lg-2">
        <span class="title">Категории</span>
        @foreach(\App\Models\Category::whereDoesntHave('parents')->get() as $category)
          <a href="{{ route('product.all', ['category' => $category->id]) }}">{{ $category->name }}</a>
        @endforeach
      </div>
      <div class="col-md-6 col-lg-3">
        <span class="title">Как нас найти</span>
        <span>РК, Алматы Мкр. Самал-3,1 050059</span>
        <span>Аль Фараби угол ул. Достык, слева от центрального входа в ТРЦ “Ритц Палас” </span>
      </div>
    </div>
    <div class="row">
      <div class="col-12 text-center d-inline-block">
        <span>
          Разработано shopper при поддержке
          <a href="{{ config('app.admin.link') }}" style="color: #1266f1;" target="_blank">{{ config('app.admin.name') }}</a>
          и <a href="https://hugant.github.io" style="color: #1266f1;" target="_blank">Hugant Mirron</a>
        </span>
      </div>
    </div>
  </div>
</footer>
