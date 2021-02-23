<a href="{{ route('product.show', $product->id) }}" class="item-link">

  <div class="item-card">
    <div class="row">
      <div class="col-12">
        <picture>
          <source type="image/webp" srcset="{{ $product->thumbnail_webp }}">
          <source type="image/jpeg" srcset="{{ $product->thumbnail_jpg }}">
          <img src="{{ $product->thumbnail_jpg }}" class="w-100 h-100" alt="{{ $product->name }}">
        </picture>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-12">
        <span class="item-name">{{ $product->title }}</span>
      </div>
    </div>
    <div class="row mb-2">
      <div class="col-12 d-flex justify-content-between">
        @if($product->on_sale)
          <span class="old-price">{{ $cost($store.state.currency.ratio * <?= $product->price ?>) }} @{{ $store.state.currency.symbol }}</span>
          <span class="price">{{ $cost($store.state.currency.ratio * <?= $product->price_sale ?>) }} @{{ $store.state.currency.symbol }}</span>
        @else
          <span class="price">{{ $cost($store.state.currency.ratio * <?= $product->price ?>) }} @{{ $store.state.currency.symbol }}</span>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-12 d-flex justify-content-between">
        @if($product->skuses->count() > 1)
          <div class="cart-button">
            <img class="shopping-bag active" src="{{ asset('images/la_shopping-bag.svg') }}" alt="bag">
            <img class="shopping-bag-alt" src="{{ asset('images/la_shopping-bag-alt.svg') }}" alt="bag">
            {{--        <i class="las la-shopping-bag"></i>--}}
            <span>Выбрать размер</span>
          </div>
        @else
          <div class="cart-button">
            <img class="shopping-bag active" src="{{ asset('images/la_shopping-bag.svg') }}" alt="bag">
            <img class="shopping-bag-alt" src="{{ asset('images/la_shopping-bag-alt.svg') }}" alt="bag">
            {{--        <i class="las la-shopping-bag"></i>--}}
            <span>В корзину</span>
          </div>
        @endif

        <span class="heart-button">
          <i class="fal fa-heart"></i>
        </span>
      </div>
    </div>
  </div>
</a>
