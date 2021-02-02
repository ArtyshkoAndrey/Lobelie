@if ($paginator->hasPages())
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <!-- Previous page -->
      @if ($paginator->onFirstPage())
        <li class="page-item disabled">
          <a href="#" class="page-link">
            <i class="bx bx-left-arrow" aria-hidden="true"></i>
            <span class="sr-only">Previous</span> <!-- sr-only = only for screen readers -->
          </a>
        </li>
      @else
        <li class="page-item ">
          <a href="{{ $paginator->previousPageUrl() }}" class="page-link">
            <i class="bx bx-left-arrow" aria-hidden="true"></i>
            <span class="sr-only">Previous</span> <!-- sr-only = only for screen readers -->
          </a>
        </li>
      @endif

      @foreach ($elements as $element)
        @if (is_string($element))
          <li class="page-item disabled" aria-current="page">
            <a href="#" class="page-link" tabindex="-1">{{ $element }}</a>
          </li>
        @endif

        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
                <li class="page-item active" aria-current="page">
                  <a href="#" class="page-link" tabindex="-1">{{ $page }}</a>
                </li>
            @else
              <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
            @endif
          @endforeach
        @endif
      @endforeach

      @if ($paginator->hasMorePages())
        <li class="page-item">
          <a href="{{ $paginator->nextPageUrl() }}" class="page-link">
            <i class="bx bx-right-arrow" aria-hidden="true"></i>
            <span class="sr-only">Next</span> <!-- sr-only = only for screen readers -->
          </a>
        </li>
      @else
        <li class="page-item disabled">
          <a href="#" class="page-link">
            <i class="bx bx-right-arrow" aria-hidden="true"></i>
            <span class="sr-only">Next</span> <!-- sr-only = only for screen readers -->
          </a>
        </li>
    @endif
    </ul>
  </nav>
@endif
