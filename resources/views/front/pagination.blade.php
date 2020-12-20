@if ($paginator->hasPages())
  <div class="product__pagination">
    @if (!$paginator->onFirstPage())
      <a href="{{ $paginator->previousPageUrl() }}"><i class="fa fa-long-arrow-left"></i></a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
      {{-- "Three Dots" Separator --}}
      @if (is_string($element))
        <a href="#">{{ $element }}</a>
      @endif

      {{-- Array Of Links --}}
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <a class="active" href="#">{{ $page }}</a>
          @else
            <a href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach

    @if ($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-long-arrow-right"></i></a>
    @endif
  </div>
@endif
