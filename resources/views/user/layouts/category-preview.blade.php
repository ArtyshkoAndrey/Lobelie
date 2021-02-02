<div class="container category-preview">
  <div class="title-wrapper">
    <span class="title">{{ $title }}</span>
    <a href="{{ $link }}"><i class="bx bx-right-arrow-alt"></i></a>
  </div>
  <div class="row">
    @foreach($products as $product)
      <div class="col-6 col-lg-4 col-xl-3 p-0">
        @include('user.layouts.item', ['item' => $product])
      </div>
    @endforeach
  </div>
</div>
