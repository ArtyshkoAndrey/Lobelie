@foreach($categories as $category)
  <div class="col-12 col-md-6 col-lg-4 d-flex flex-column">
    <div class="row category">
      <div class="col-6 d-flex flex-column">
        <h4>{{ $category->name }}</h4>
        @foreach($category->child as $ct)
          <a href="{{ route('product.all', ['category' => $ct->id]) }}">{{ $ct->name }}</a>
        @endforeach
      </div>
      <div class="col-6">
        <a href="{{ route('product.all', ['category' => $category->id]) }}" class="see-all">Смотреть все</a>
      </div>
    </div>
  </div>
@endforeach
