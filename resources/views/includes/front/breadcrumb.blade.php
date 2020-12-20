<section class="breadcrumb-section bg-primary" style="background-color: #23AB96 !important">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="breadcrumb__text">
          @if (isset($breadcrumbs))
            @php
            $currentPage = last(array_keys($breadcrumbs));
            @endphp
            <h2>{{ $currentPage }}</h2>
            <div class="breadcrumb__option">
              @php
              array_pop($breadcrumbs)
              @endphp
              @foreach ($breadcrumbs as $k => $v)
                <a href="{{ $v }}">{{ $k }}</a>
              @endforeach
              <span>{{ $currentPage }}</span>
            </div>
          @else
            <h2>Agropuro</h2>
            <div class="breadcrumb__option">
              <a href="{{ route('home') }}">Home</a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
