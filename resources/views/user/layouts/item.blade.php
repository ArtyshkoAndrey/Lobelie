<a href="#" class="item-link">

  <div class="item-card">
    <div class="row">
      <div class="col-12">
        <picture>
          <source type="image/webp" srcset="{{ asset('images/product.png') }}">
          <source type="image/jpeg" srcset="{{ asset('images/product.png') }}">
          <img src="{{ asset('images/product.png') }}" class="w-100 h-100" alt="alt name">
        </picture>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-12">
        <span class="item-name">Полное название в одну строку</span>
      </div>
    </div>
    <div class="row mb-2">
      <div class="col-12 d-flex justify-content-between">
        {{--      <span class="old-price">100 000</span>--}}
        <span class="price">20 000 ₸</span>
      </div>
    </div>
    <div class="row">
      <div class="col-12 d-flex justify-content-between">
        <div class="cart-button">
          <img class="shopping-bag active" src="{{ asset('images/la_shopping-bag.svg') }}">
          <img class="shopping-bag-alt" src="{{ asset('images/la_shopping-bag-alt.svg') }}">
          {{--        <i class="las la-shopping-bag"></i>--}}
          <span>В корзину</span>
        </div>
        <span class="heart-button">
        <i class="fal fa-heart"></i>
      </span>
      </div>
    </div>
  </div>
</a>
