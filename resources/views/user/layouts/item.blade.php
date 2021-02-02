<div class="card bg-transparent shadow-0 h-100 {{ $item->on_sale ? 'sale' : null }}">

  <div class="card-body d-flex flex-column">
    <div class="row">
      <div class="col-12">
        <a href="{{ route('product.show', $item->id) }}" class="img-wrapper d-block">
          <div class="sale-badge">Sale</div>
          <picture>
            <source type="image/webp" srcset="{{ $item->thumbnail_webp }}">
            <source type="image/jpeg" srcset="{{ $item->thumbnail_jpg }}">
            <img src="{{ $item->thumbnail_jpg }}" class="w-100 h-100" alt="{{ $item->name }}">
          </picture>
        </a>
      </div>
    </div>
    <div class="row pt-3 mb-auto">
      <div class="col-12">
        <a class="title" href="{{ route('product.show', $item->id) }}">{{ $item->title }}</a>
      </div>
    </div>
    <div class="row context mt-auto">
      <div class="col-12 col-md-5 d-flex flex-column justify-content-center pl-2 pr-0">
        @if($item->on_sale)
          <span class="old-price">{{ $cost($store.state.currency.ratio * <? echo $item->price ?>) }} @{{ $store.state.currency.symbol }}</span>
          <span class="price">{{ $cost($store.state.currency.ratio * <? echo $item->price_sale ?>) }} @{{ $store.state.currency.symbol }}</span>
        @else
          <span class="price">{{ $cost($store.state.currency.ratio * <? echo $item->price ?>) }} @{{ $store.state.currency.symbol }}</span>
        @endif
      </div>
      <div class="col-12 col-md-7 d-flex justify-content-center align-items-center p-0 px-2">
        @if($item->skuses()->count() >=  2)
          <a href="{{ route('product.show', $item->id) }}" class="btn btn-outline-dark w-100 btn-to-cart">
            <i class="bx bx-cart"></i>
            <span>Выбрать</span>
          </a>
        @elseif($item->skuses()->count() === 1)
          <button class="btn btn-outline-dark btn-to-cart w-100 mt-2 mt-md-0"
              @click="$store.commit('addItem', {id: {{ $item->skuses()->first()->pivot->id }}, amount: 1})">
            <i class="bx bx-cart"></i>
            <span>В корзину</span>
          </button>
        @else
          <button class="btn btn-outline-dark btn-to-cart w-100 mt-2 mt-md-0" disabled>
            Товар распродан
          </button>
        @endif

      </div>
    </div>
  </div>
</div>
