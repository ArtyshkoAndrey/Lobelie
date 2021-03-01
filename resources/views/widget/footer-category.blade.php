@foreach($categories as $category)
  <a href="{{ route('product.all', ['category' => $category]) }}" class="link">{{ $category->name }}</a>
@endforeach
