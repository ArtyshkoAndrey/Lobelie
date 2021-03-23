@extends('user.layouts.app')

@section('title', $product->title)

@section('content')
  <div class="container-fluid item-page">
    <div class="row mb-5">
      <div class="col-12 col-md-6 images-stack mb-3 mb-md-0">
        @foreach($product->photos as $photo)
          <div class="col-12 px-2 py-0 px-md-0 py-md-2">
            <picture>
              <source type="image/webp" srcset="{{ $photo->thumbnail_url_webp }}">
              <source type="image/jpeg" srcset="{{ $photo->thumbnail_url_jpg }}">
              <img src="{{ $photo->thumbnail_url_jpg }}" alt="{{ $photo->name }}">
            </picture>
          </div>
        @endforeach
      </div>
      <div class="col-12 col-md-6 pl-3 pl-md-4 item-details">
        <div class="row flex-column content-wrapper">
          <div class="col-12 breadcrumb">

            @foreach($categories as $category)
              <a class="breadcrumb-link" href="{{ route('product.all', ['category' => $category->id]) }}">{{ $category->name }}</a> / 
            @endforeach
            <span>{{ $product->title }}</span>

          </div>
          <div class="col-12 title-wrapper">{{ $product->title }}</div>
          <div class="col-12 type-wrapper mb-2">{{ $product->category->name ?? '' }}</div>
          <div class="col-12 prices-wrapper sale mb-2">
            @if($product->on_sale)
              <span class="old-price">{{ $cost($store.state.currency.ratio * <? echo $product->price ?>) }} тг.</span>
            @endif
            <span class="price">{{ $cost($store.state.currency.ratio * <? echo $product->on_sale ? $product->price_sale : $product->price?>) }} тг.</span>
          </div>
          <div class="col-12 sizes-wrapper mb-2">
            <div class="row">
              <div class="col-auto title">Выберите размер</div>
              <div class="col-12 mt-2 size-table">
               <div class="row">
                 @foreach($product->skuses as $skus)
                   <div class="col-auto">
                     <button class="size-box p-2 {{ $skus->pivot->stock === 0 ? 'disabled' : null }}"
                          :class="selectSkus === {{$skus->pivot->id}} ? 'selected' : null"
                          @click="selectSkus = {{$skus->pivot->stock ? $skus->pivot->id : 'null'}}">
                       {{ $skus->title }}
                     </button>
                   </div>
                 @endforeach
               </div>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3 d-flex">
            <button class="btn-to-cart mt-2 mt-md-0"
                    :disabled="selectSkus === null"
                    @click="$store.commit('addItem', {id: selectSkus, amount: 1})">
              <i class="las la-shopping-bag"></i>
              <span>В корзину</span>
            </button>
            <button class="btn-to-favorite mt-2 mt-md-0">
              <i class="fal fa-heart"></i>
            </button>
          </div>
          <div class="col-12 col-lg-8 description-wrapper">
            <div class="row">
              <div class="col-12 title">Описание</div>
              <div class="col-12 description">
                {!! $product->description !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if(count($similarProducts) > 0)
      <div class="row">
        <div class="col-12">
          <h1 class="title">Может быть интересно</h1>
        </div>
      </div>
      <div class="row">
        @foreach($similarProducts as $product)
          <div class="col-6 col-md-3 mb-4">
            @include('user.layouts.item', ['product' => $product])
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endsection

@section('js')
  <script src="https://unpkg.com/zooming"></script>
<script>
  let showItemAmount = 4
  let currentPosition = 0
  let currentItem = 0
  let scrollStep = 0
  let itemAmount = {{ count($product->photos) }};
  let itemHeight = 0
  // let itemMarginBottom = parseInt($('.slider-nav .item .img-wrapper').css('marginBottom'))
  let itemMarginBottom = 20

  function initSliderSize() {
    let previewImageHeight = $('.slider-for .img-wrapper').height()
    $('.slider-nav').height(previewImageHeight)
    itemHeight = previewImageHeight / showItemAmount - itemMarginBottom + itemMarginBottom / 4

    for (let item of $('.slider-nav .item .img-wrapper')) {
      $(item).css('height', itemHeight)
      $(item).css('width', itemHeight)
    }

    return itemHeight
  }

  document.addEventListener('animationstart', function (e) {
    if (e.animationName === 'fade-in') {
      e.target.classList.add('did-fade-in');
    }
  });

  document.addEventListener('animationend', function (e) {
    if (e.animationName === 'fade-out') {
      e.target.classList.remove('did-fade-in');
    }
  });

  $(window).resize(function() {
    itemHeight = initSliderSize()
    scrollStep = itemHeight + itemMarginBottom
    currentPosition = currentItem * scrollStep
    $('.slider-nav .scroll-wrapper').css('top', '-' + currentPosition + 'px')
  })

  $(window).ready(function() {
    itemHeight = initSliderSize()

    currentPosition = 0
    scrollStep = itemHeight + itemMarginBottom
    $('.slider-nav .scroll-wrapper').css('top', '-' + currentPosition + 'px')
  })

  $('.slider-button#prev').click(function() {
    if (currentPosition > 0) {
      currentItem--
      currentPosition -= scrollStep
      $('.slider-nav .scroll-wrapper').css('top', '-' + currentPosition + 'px')
    }
  })

  $('.slider-button#next').click(function() {
    if (currentPosition < (itemAmount - 2) * itemHeight) {
      currentItem++
      currentPosition += scrollStep
      $('.slider-nav .scroll-wrapper').css('top', '-' + currentPosition + 'px')
    }
  })

  $('.slider-nav .img-wrapper').click(function() {
    let imageID = $(this).attr('data-image-id')
    console.log($('.slider-for .img-wrapper[data-id=' + imageID + ']'))
    $('.slider-for .img-wrapper.active').removeClass('active')
    $('.slider-for .img-wrapper[data-id=' + imageID + ']').addClass('active')
  })

  new Zooming({
    onBeforeOpen: () => {
      $('body').css('overflow','hidden')
      $('hidden-overflow').css('overflow', 'auto')
    },
    onBeforeClose: () => {
      $('body').css('overflow','auto')
      $('hidden-overflow').css('overflow', 'hidden')
    },
    scaleBase: 1,
    scaleExtra: 1.5,
    scrollThreshold: 99999
  }).listen('.img-product')


</script>
@endsection
