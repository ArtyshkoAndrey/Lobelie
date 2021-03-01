 <div class="item-card" id="product-item-{{ $product->id }}">
   <div onclick="location.href = '{{ route('product.show', $product->id) }}'" style="cursor: pointer">
      <div class="row mb-2">
      <div class="col-12">
        <picture>
          <source type="image/webp" srcset="{{ $product->thumbnail_webp }}">
          <source type="image/jpeg" srcset="{{ $product->thumbnail_jpg }}">
          <img src="{{ $product->thumbnail_jpg }}" class="w-100 h-100" alt="{{ $product->name }}">
        </picture>
      </div>
    </div>
      <div class="row mb-1 px-1 px-sm-2 px-md-3">
        <div class="col-12">
          <span class="item-name">{{ $product->title }}</span>
        </div>
      </div>
   </div>
    <div class="row mb-2 px-1 px-sm-2 px-md-3">
      <div class="col-12 d-flex flex-column flex-sm-row justify-content-between">
        @if($product->on_sale)
          <span class="old-price">{{ $cost($store.state.currency.ratio * <?= $product->price ?>) }} @{{ $store.state.currency.symbol }}</span>
          <span class="price">{{ $cost($store.state.currency.ratio * <?= $product->price_sale ?>) }} @{{ $store.state.currency.symbol }}</span>
        @else
          <span class="price">{{ $cost($store.state.currency.ratio * <?= $product->price ?>) }} @{{ $store.state.currency.symbol }}</span>
        @endif
      </div>
    </div>
    <div class="row px-1 px-sm-2 px-md-3">
      <div class="col-12 d-flex justify-content-between">
        @if($product->skuses->count() > 1)
          <a class="cart-button" href="{{ route('product.show', $product->id) }}">
            <img class="shopping-bag active" src="{{ asset('images/la_shopping-bag.svg') }}" alt="bag">
            <img class="shopping-bag-alt" src="{{ asset('images/la_shopping-bag-alt.svg') }}" alt="bag">
            {{--        <i class="las la-shopping-bag"></i>--}}
            <span class="d-none d-sm-block">Выбрать размер</span>
          </a>
        @else
          <button class="cart-button" @click="$store.commit('addItem', {id: {{ $product->skuses()->first()->pivot->id }}, amount: 1})">
            <img class="shopping-bag active" src="{{ asset('images/la_shopping-bag.svg') }}" alt="bag">
            <img class="shopping-bag-alt" src="{{ asset('images/la_shopping-bag-alt.svg') }}" alt="bag">
            {{--        <i class="las la-shopping-bag"></i>--}}
            <span class="d-none d-sm-block">В корзину</span>
          </button>
        @endif
        @if(auth()->check())
          @if(auth()->user()->favorites()->where('product_id', $product->id)->count() > 0)
            <button class="heart-button" @click="deleteFavor({{ $product->id }}, {{ $delete ?? false }})">
              <i class="fa fa-heart"></i>
            </button>
          @else
              <button class="heart-button" @click="addFavor({{ $product->id }})">
                <i class="fal fa-heart"></i>
              </button>
          @endif
        @else
          <button class="heart-button" @click="addFavor({{ $product->id }})">
            <i class="fal fa-heart"></i>
          </button>
        @endif

      </div>
    </div>
  </div>
